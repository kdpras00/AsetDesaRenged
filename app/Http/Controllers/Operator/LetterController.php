<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\User;
use App\Notifications\LetterProcessed;
use App\Notifications\RequestRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class LetterController extends Controller
{
    /**
     * Display a listing of letters.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $letters = Letter::with(['user', 'letterType'])
            ->when($status, function ($query) use ($status) {
                if ($status === 'history') {
                    return $query->whereIn('status', ['verified', 'rejected']);
                }
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('operator.letters.index', compact('letters', 'status'));
    }

    /**
     * Process/Verify the letter administratively.
     */
    public function show(Letter $letter)
    {
        $letter->load(['user', 'letterType']);
        return view('operator.letters.show', compact('letter'));
    }

    /**
     * Process/Verify the letter administratively.
     */
    public function process(Request $request, Letter $letter)
    {
        $request->validate([
            'operator_notes' => 'nullable|string',
        ]);

        if ($letter->status !== 'pending') {
            return back()->with('error', 'Hanya surat pending yang dapat diproses.');
        }

        // Auto Generate Letter Number
        // Format: [Code]/[ID]/Ds.Rgd/[MonthRomawi]/[Year]
        // Example: 470/015/Ds.Rgd/XII/2025
        $code = $letter->letterType->code ?? '470';
        $month = \App\Helpers\Romawi::get(now()->month);
        $year = now()->year;
        $id = str_pad($letter->id, 3, '0', STR_PAD_LEFT);
        
        // Custom format for Domisili
        // Format: DOMISILI/code/day/month/year
        // Example: DOMISILI/470/14/12/2025
        // Final Standard Format (Client Request + Best Practice)
        // Format: [PREFIX] / [CODE] / [NO_URUT] / [ROMAWI_BLN] / [TAHUN]
        // Example: SKD/146/025/XII/2025
        
        $config = $letter->letterType->form_config;
        $prefix = $config['letter_number_prefix'] ?? $letter->letterType->slug; 
        
        // Use ID for Sequence to guarantee uniqueness and avoid duplicates.
        // This is robust and prevents collision even if multiple letters are processed simultaneously.
        $id = str_pad($letter->id, 3, '0', STR_PAD_LEFT); 
        $romawiMonth = \App\Helpers\Romawi::get(now()->month); 
        
        $autoNumber = "{$prefix}/{$code}/{$id}/{$romawiMonth}/{$year}";

        // Ensure uniqueness just in case (though ID makes it unique for that type/day combo usually? ID is globally unique)
        // If ID is unique, the whole string is unique.
        
        $letter->update([
            'status' => 'processed',
            'letter_number' => $autoNumber,
            'operator_id' => auth()->id(),
            'process_date' => now(),
            'operator_notes' => $request->operator_notes,
        ]);

        // Mark related notification as read for this operator
        $notification = auth()->user()->unreadNotifications
            ->where('data.letter_id', $letter->id)
            ->where('type', 'App\Notifications\NewLetterRequest')
            ->first();
        
        if ($notification) {
            $notification->markAsRead();
        }

        // Notify Kepala Desa
        $kades = User::where('role', 'kepala_desa')->get();
        Notification::send($kades, new LetterProcessed($letter));

        return redirect()->route('operator.letters.index')->with('success', 'Surat berhasil diproses (No: ' . $autoNumber . ') dan diteruskan ke Kepala Desa.');
    }

    /**
     * Reject the letter request.
     */
    public function reject(Request $request, Letter $letter)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        if ($letter->status !== 'pending') {
            return back()->with('error', 'Status surat tidak valid untuk ditolak.');
        }

        $letter->update([
            'status' => 'rejected',
            'operator_id' => auth()->id(),
            'rejection_reason' => $request->reason,
        ]);

        // Mark related notification as read for this operator
        $notification = auth()->user()->unreadNotifications
            ->where('data.letter_id', $letter->id)
            ->where('type', 'App\Notifications\NewLetterRequest')
            ->first();
        
        if ($notification) {
            $notification->markAsRead();
        }

        // Notify Warga
        $letter->user->notify(new RequestRejected(
            'Permohonan surat ' . $letter->letterType->name . ' ditolak: ' . $request->reason,
            route('warga.letters.index', ['view' => 'history'])
        ));

        return redirect()->back()->with('success', 'Pengajuan surat ditolak.');
    }
    /**
     * Download the letter as PDF (Operator View).
     */
    public function download(Letter $letter)
    {
        // Operator can download any letter, but maybe usually Processed or Verified?
        // Let's allow downloading at any stage for previewing content.
        
        $view = $letter->letterType->form_config['pdf_view'] ?? 'pdf.generic';
        
        // Specific fix for KTP to ensure PDF generation
        if ($letter->letterType->slug === 'KTP') {
             $view = 'pdf.formulir-permohonan-ktp';
        }

        if ($view === 'excel') {
             // Fallback if other excel configurations exist, but for now we redirect KTP to PDF above.
             return back()->with('error', 'Format Excel tidak lagi didukung. Hubungi admin.');
        }

        if (!$view) {
             return back()->with('error', 'Format surat tidak ditemukan dalam konfigurasi.');
        }

        if (!view()->exists($view)) {
             return back()->with('error', "File template ($view) tidak ditemukan di sistem.");
        }

        $letter->load(['user', 'letterType', 'kepalaDesa']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($view, compact('letter'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Surat-' . str_replace('/', '-', $letter->letter_number ?? 'DRAFT') . '.pdf');
    }

    private function generateKtpExcel($letter)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        // Header
        $sheet->setCellValue('Q1', 'F-1.21');
        $sheet->getStyle('Q1')->getFont()->setBold(true);
        $sheet->getStyle('Q1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->mergeCells('A2:R2');
        $sheet->setCellValue('A2', 'FORMULIR PERMOHONAN KARTU TANDA PENDUDUK (KTP) WARGA NEGARA INDONESIA');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $sheet->mergeCells('A4:R8');
        $sheet->setCellValue('A4', "Perhatian :\n1. Harap di isi dengan huruf cetak dan menggunakan tinta hitam\n2. Untuk kolom pilihan, harap memberi tanda silang (X) pada kotak pilihan.\n3. Setelah formulir ini diisi dan ditandatangani, harap diserahkan kembalike kantor Desa/Kelurahan");
        $sheet->getStyle('A4')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A4')->getFont()->setSize(9);

        $row = 10;
        $labels = [
            'PEMERINTAH PROVINSI' => ['code' => '36', 'name' => 'BANTEN'],
            'PEMERINTAH KABUPATEN/KOTA' => ['code' => '03', 'name' => 'TANGERANG'],
            'KECAMATAN' => ['code' => '06', 'name' => 'KRESEK'],
            'KELURAHAN/DESA' => ['code' => '2009', 'name' => 'RENGED'],
        ];

        foreach ($labels as $label => $data) {
            $sheet->setCellValue('A' . $row, $label);
            $sheet->setCellValue('F' . $row, ':');
            $colIndex = 7;
            for ($i = 0; $i < strlen($data['code']); $i++) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + $i);
                $sheet->setCellValue($col . $row, $data['code'][$i]);
                $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
            $nameCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + strlen($data['code']) + 1);
            $sheet->setCellValue($nameCol . $row, $data['name']);
            $sheet->getStyle($nameCol . $row)->getFont()->setBold(true);
            $row++;
        }

        $row += 2;
        $sheet->setCellValue('A' . $row, 'PERMOHONAN KTP');
        $sheet->getStyle('A' . $row)->getFont()->setItalic(true)->setUnderline(true)->setBold(true);
        
        $ktpType = $letter->data['ktp_type'] ?? '';
        $types = ['Baru' => 'F', 'Perpanjangan' => 'J', 'Penggantian' => 'O'];
        foreach ($types as $typeLabel => $col) {
            $checkVal = ($ktpType == $typeLabel) ? 'X' : '';
            $sheet->setCellValue($col . $row, $checkVal);
            $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            
            $labelCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col) + 1);
           $sheet->setCellValue($labelCol . $row, $typeLabel);
        }

        $row += 2;
        $fields = [
            '1. Nama Lengkap' => ['val' => strtoupper($letter->user->name), 'max' => 32],
            '2. No. KK' => ['val' => $letter->user->kk ?? '', 'max' => 16],
            '3. NIK' => ['val' => $letter->user->nik ?? '', 'max' => 16],
            '4. Alamat' => ['val' => 'KP. ' . strtoupper($letter->user->address ?? ''), 'max' => 30],
        ];

        foreach ($fields as $label => $info) {
             $sheet->setCellValue('A' . $row, $label);
             $startColIndex = 6;
             $text = $info['val'];
             for ($i = 0; $i < $info['max']; $i++) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startColIndex + $i);
                $char = isset($text[$i]) ? $text[$i] : '';
                if ($startColIndex + $i > 26) break;
                $sheet->setCellValue($col . $row, $char);
                $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
             }
             $row += 2;
        }
        
        $row -= 1;
        $sheet->setCellValue('F' . $row, 'RT');
        $sheet->getStyle('F' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $rt = $letter->user->rt ?? '00';
        $sheet->setCellValue('G' . $row, substr($rt, 0, 1));
        $sheet->setCellValue('H' . $row, substr($rt, 1, 1));
        $sheet->getStyle('G' . $row . ':H' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('G' . $row . ':H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('J' . $row, 'RW');
        $sheet->getStyle('J' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $rw = $letter->user->rw ?? '00';
        $sheet->setCellValue('K' . $row, substr($rw, 0, 1));
        $sheet->setCellValue('L' . $row, substr($rw, 1, 1));
        $sheet->getStyle('K' . $row . ':L' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('K' . $row . ':L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('N' . $row, 'Kode Pos');
        $sheet->getStyle('N' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $pos = "15620";
        for($i=0; $i<strlen($pos); $i++){
             $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(15 + $i);
             $sheet->setCellValue($col . $row, $pos[$i]);
             $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
              $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        $row += 3;
        $sheet->setCellValue('A' . $row, 'Pas Photo (2x3)');
        $sheet->setCellValue('D' . $row, 'Cap Jempol');
        $sheet->mergeCells('G' . $row . ':R' . $row);
        $sheet->setCellValue('G' . $row, 'Specimen Tanda Tangan');
        $sheet->getStyle('A' . $row . ':R' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A' . $row . ':R' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row++;
        $startRow = $row;
        $endRow = $row + 5;
        
        $sheet->mergeCells('A' . $startRow . ':C' . $endRow);
        $sheet->mergeCells('D' . $startRow . ':F' . $endRow);
        $sheet->mergeCells('G' . $startRow . ':R' . $endRow);

        $sheet->getStyle('A' . $startRow . ':R' . $endRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->setCellValue('A' . $startRow, 'Ket: Pas Photo');
        $sheet->getStyle('A' . $startRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $row = $endRow + 1;
        $sheet->mergeCells('L' . $row . ':R' . $row);
        $date = $letter->approved_date ?? $letter->process_date ?? $letter->request_date ?? now();
        $sheet->setCellValue('L' . $row, '..........................., ' . $date->translatedFormat('d F Y'));
        $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $row++;
        $sheet->setCellValue('A' . $row, 'Camat ........................................');
        $sheet->setCellValue('J' . $row, 'Mengetahui,');
        $sheet->mergeCells('N' . $row . ':R' . $row);
        $sheet->setCellValue('N' . $row, 'Pemohon,');
         $sheet->getStyle('N' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $row++;
        $sheet->setCellValue('I' . $row, "a.n. Kepala Desa Renged\nSekretaris Desa");
        $sheet->getStyle('I' . $row)->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row += 4; 

        if ($letter->status == 'verified' && $letter->sha256_hash) {
             try {
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(70)->generate(route('verification.verify.hash', $letter->sha256_hash));
                $tempQrFile = tempnam(sys_get_temp_dir(), 'qr_code');
                file_put_contents($tempQrFile, $qrCode);

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('QR Code');
                $drawing->setDescription('QR Code');
                $drawing->setPath($tempQrFile);
                $drawing->setCoordinates('J' . ($row - 3));
                $drawing->setHeight(70);
                $drawing->setWorksheet($sheet);
             } catch (\Exception $e) {}
        }
        
        $sheet->setCellValue('A' . $row, '( ..................................................... )');
        $sheet->setCellValue('I' . $row, '( DEVI FITRIA, S.Pd )');
        $sheet->getStyle('I' . $row)->getFont()->setBold(true)->setUnderline(true);
        $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('N' . $row . ':R' . $row);
        $sheet->setCellValue('N' . $row, '( ..................................................... )');
        $sheet->getStyle('N' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row++;
        $sheet->setCellValue('A' . $row, 'NIP.');

        foreach(range('A','R') as $col) {
            $sheet->getColumnDimension($col)->setWidth(3);
        }
        $sheet->getColumnDimension('A')->setWidth(5); 

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="Formulir-KTP-' . $letter->user->name . '.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
