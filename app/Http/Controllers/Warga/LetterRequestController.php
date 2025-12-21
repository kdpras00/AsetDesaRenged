<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\LetterType;
use App\Models\User;
use App\Notifications\NewLetterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class LetterRequestController extends Controller
{
    /**
     * Display a listing of Letter Types or User's Letter History.
     */
    public function index(Request $request)
    {
        $view = $request->get('view', 'catalog');

        if ($view === 'history') {
            // Mark all unread notifications as read when viewing history
            auth()->user()->unreadNotifications->markAsRead();

            $letters = auth()->user()->letters()
                ->with('letterType')
                ->latest()
                ->paginate(10);
            return view('warga.letters.history', compact('letters'));
        }

        // Catalog
        $letterTypes = LetterType::all(); // Assuming small table, no pagination needed usually
        return view('warga.letters.index', compact('letterTypes'));
    }

    /**
     * Show the form for creating a new letter request.
     */
    public function create(LetterType $type)
    {
        // Enforce Profile Completion
        $user = auth()->user();
        if (empty($user->gender) || empty($user->birth_place) || empty($user->birth_date) || empty($user->religion) || empty($user->job)) {
            return redirect()->route('profile.edit')->with('warning', 'Mohon lengkapi biodata Anda (Jenis Kelamin, TTL, Agama, Pekerjaan) terlebih dahulu sebelum mengajukan surat.');
        }

        // Check Age (Must be 17+)
        $age = \Carbon\Carbon::parse($user->birth_date)->age;
        if ($age < 17) {
            return redirect()->route('warga.letters.index')->with('error', 'Maaf, Anda belum cukup umur untuk mengajukan surat. Usia minimal adalah 17 tahun.');
        }

        return view('warga.letters.create', compact('type'));
    }

    /**
     * Store a newly created letter request in storage.
     */
    public function store(Request $request)
    {
        $letterType = LetterType::findOrFail($request->letter_type_id);
        $user = auth()->user();

        // Check Age (Must be 17+)
        $age = \Carbon\Carbon::parse($user->birth_date)->age;
        if ($age < 17) {
            return redirect()->route('warga.letters.index')->with('error', 'Maaf, Anda belum cukup umur untuk mengajukan surat. Usia minimal adalah 17 tahun.');
        }

        // Core Validation Rules (Always required)
        $rules = [
            'letter_type_id' => 'required|exists:letter_types,id',
            'purpose' => 'required|string|max:1000',
            'ktp_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB
            'kk_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB
        ];

        // Load Dynamic Rules from Config
        // Fallback to empty array if config is null
        $dynamicRules = $letterType->form_config['validation_rules'] ?? [];
        $rules = array_merge($rules, $dynamicRules);

        $request->validate($rules);

        $data = [
            'user_id' => auth()->id(),
            'letter_type_id' => $request->letter_type_id,
            'purpose' => $request->purpose,
            'request_date' => now(),
            'status' => 'pending',
            'data' => [], // Initialize data array
        ];

        // Store Dynamic Data Fields
        // Only store fields defined in config to avoid polluting the JSON
        $fieldsToStore = $letterType->form_config['fields'] ?? [];
        
        $storedData = [];
        if (!empty($fieldsToStore)) {
             $storedData = $request->only($fieldsToStore);
        }

        // Handle Mandatory KTP & KK Uploads
        if ($request->hasFile('ktp_file')) {
            $storedData['ktp_file_path'] = $request->file('ktp_file')->store('letters/ktp', 'public');
        }
        if ($request->hasFile('kk_file')) {
            $storedData['kk_file_path'] = $request->file('kk_file')->store('letters/kk', 'public');
        }

        $data['data'] = $storedData;



        $letter = Letter::create($data);

        // Notify Operators
        $operators = User::where('role', 'operator')
                        ->where('id', '!=', auth()->id())
                        ->get();
        Notification::send($operators, new NewLetterRequest($letter));

        return redirect()->route('warga.letters.index', ['view' => 'history'])->with('success', 'Permohonan surat berhasil diajukan. Menunggu verifikasi.');
    }
    /**
     * Download the letter as PDF.
     */
    public function download(Letter $letter)
    {
        // Authorization: Warga can only download their own letters
        if ($letter->user_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh surat ini.');
        }

        // Ideally only verified letters
        if ($letter->status !== 'verified') {
            return back()->with('error', 'Surat belum terverifikasi. Status saat ini: ' . ucfirst($letter->status) . '.');
        }

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
        
        // Set Default Font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        // --- Layout Building ---

        // Form Code (Top Right)
        $sheet->setCellValue('Q1', 'F-1.21');
        $sheet->getStyle('Q1')->getFont()->setBold(true);
        $sheet->getStyle('Q1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Header Title
        $sheet->mergeCells('A2:R2');
        $sheet->setCellValue('A2', 'FORMULIR PERMOHONAN KARTU TANDA PENDUDUK (KTP) WARGA NEGARA INDONESIA');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        // Instructions
        $sheet->mergeCells('A4:R8');
        $sheet->setCellValue('A4', "Perhatian :\n1. Harap di isi dengan huruf cetak dan menggunakan tinta hitam\n2. Untuk kolom pilihan, harap memberi tanda silang (X) pada kotak pilihan.\n3. Setelah formulir ini diisi dan ditandatangani, harap diserahkan kembalike kantor Desa/Kelurahan");
        $sheet->getStyle('A4')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A4')->getFont()->setSize(9);

        // Administrative Info Grid
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
            
            // Draw Code Boxes
            $colIndex = 7; // G
            for ($i = 0; $i < strlen($data['code']); $i++) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + $i);
                $sheet->setCellValue($col . $row, $data['code'][$i]);
                $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }

            // Name
            $nameCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + strlen($data['code']) + 1);
            $sheet->setCellValue($nameCol . $row, $data['name']);
            $sheet->getStyle($nameCol . $row)->getFont()->setBold(true);

            $row++;
        }

        $row += 2;

        // Permohonan KTP Type
        $sheet->setCellValue('A' . $row, 'PERMOHONAN KTP');
        $sheet->getStyle('A' . $row)->getFont()->setItalic(true)->setUnderline(true)->setBold(true);
        
        $ktpType = $letter->data['ktp_type'] ?? '';
        
        // Checkboxes
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

        // User Data Fields (Name, KK, NIK, Alamat)
        $fields = [
            '1. Nama Lengkap' => ['val' => strtoupper($letter->user->name), 'max' => 32],
            '2. No. KK' => ['val' => $letter->user->kk ?? '', 'max' => 16],
            '3. NIK' => ['val' => $letter->user->nik ?? '', 'max' => 16],
            '4. Alamat' => ['val' => 'KP. ' . strtoupper($letter->user->address ?? ''), 'max' => 30],
        ];

        foreach ($fields as $label => $info) {
             $sheet->setCellValue('A' . $row, $label);
             
             $startColIndex = 6; // F
             $text = $info['val'];
             for ($i = 0; $i < $info['max']; $i++) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startColIndex + $i);
                $char = isset($text[$i]) ? $text[$i] : '';
                
                // Only draw box if within standard grid width (approx A-R or so) or just keep going
                // For layout purposes, standard forms align. Let's limit visual width.
                if ($startColIndex + $i > 26) break; // Limit horizontal spill

                $sheet->setCellValue($col . $row, $char);
                $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
             }
             $row += 2;
        }
        
        // RT/RW/Pos Code
        $row -= 1; // Move back up slightly
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
             $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(15 + $i); // O start
             $sheet->setCellValue($col . $row, $pos[$i]);
             $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
              $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        $row += 3;

        // Signatures
        // Table Header
        $sheet->setCellValue('A' . $row, 'Pas Photo (2x3)');
        $sheet->setCellValue('D' . $row, 'Cap Jempol');
        $sheet->mergeCells('G' . $row . ':R' . $row);
        $sheet->setCellValue('G' . $row, 'Specimen Tanda Tangan');
        $sheet->getStyle('A' . $row . ':R' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A' . $row . ':R' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row++;
        // Content Row (Box frames)
        $startRow = $row;
        $endRow = $row + 5;
        
        $sheet->mergeCells('A' . $startRow . ':C' . $endRow); // Photo
        $sheet->mergeCells('D' . $startRow . ':F' . $endRow); // Jempol
        $sheet->mergeCells('G' . $startRow . ':R' . $endRow); // Tanda Tangan

        $sheet->getStyle('A' . $startRow . ':R' . $endRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->setCellValue('A' . $startRow, 'Ket: Pas Photo');
        $sheet->getStyle('A' . $startRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        
        // Date and Signatures below
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

        $row += 4; // Space for signatures

        // Add QR Code
        if ($letter->status == 'verified' && $letter->sha256_hash) {
             try {
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(70)->generate(route('verification.verify.hash', $letter->sha256_hash));
                
                // Create temp file for QR
                $tempQrFile = tempnam(sys_get_temp_dir(), 'qr_code');
                file_put_contents($tempQrFile, $qrCode);

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('QR Code');
                $drawing->setDescription('QR Code');
                $drawing->setPath($tempQrFile);
                $drawing->setCoordinates('J' . ($row - 3)); // Position near Sekdes signature area
                $drawing->setHeight(70);
                $drawing->setWorksheet($sheet);

             } catch (\Exception $e) {
                 // Log error or ignore if QR fails, ensure download still works
             }
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


        // Auto-size specific columns (make grid columns narrow)
        foreach(range('A','R') as $col) {
            $sheet->getColumnDimension($col)->setWidth(3); // Narrow width for grid effect
        }
        // Widen specific columns containing labels if needed, or let them spill
        $sheet->getColumnDimension('A')->setWidth(5); 

        // Output Headers
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
