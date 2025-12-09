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
        return view('warga.letters.create', compact('type'));
    }

    /**
     * Store a newly created letter request in storage.
     */
    public function store(Request $request)
    {
        $letterType = LetterType::findOrFail($request->letter_type_id);

        // Validation Rules
        $rules = [
            'letter_type_id' => 'required|exists:letter_types,id',
            'purpose' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
        ];

        // Additional validation for Surat Kematian
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'kematian')) {
            $rules = array_merge($rules, [
                'deceased_name' => 'required|string|max:255',
                'deceased_nik' => 'required|numeric|digits:16',
                'deceased_kk' => 'nullable|string|max:20',
                'deceased_birth_place' => 'required|string|max:100',
                'deceased_birth_date' => 'required|date',
                'deceased_age' => 'required|integer',
                'deceased_address' => 'required|string',
                'death_day' => 'required|string',
                'death_date' => 'required|date',
                'death_place' => 'required|string',
                'death_cause' => 'required|string',
                'reporter_relationship' => 'required|string',
            ]);
        }

        // Additional validation for Surat Keterangan Usaha
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'usaha')) {
            $rules = array_merge($rules, [
                'business_name' => 'required|string|max:255',
                'business_type' => 'required|string|max:255',
                'business_address' => 'required|string|max:500',
            ]);
        }

        // Additional validation for Surat Ijin Cuti
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'cuti') || \Illuminate\Support\Str::contains(strtolower($letterType->name), 'ijin')) {
            $rules = array_merge($rules, [
                'company_name' => 'required|string|max:255',
                'leave_day' => 'required|string|max:20',
                'leave_date' => 'required|date',
                'leave_purpose' => 'required|string|max:500',
                'child_name' => 'nullable|string|max:255', // Opsional, context specific
            ]);
        }

        // Additional validation for Surat Keterangan Tidak Bekerja
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'tidak bekerja') || \Illuminate\Support\Str::contains(strtolower($letterType->name), 'tidak memiliki ijazah')) {
            $rules = array_merge($rules, [
                'marital_status' => 'required|string|max:50',
            ]);
        }
        
        // Additional validation for Surat Keterangan Kelahiran
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'kelahiran')) {
            $rules = array_merge($rules, [
                // Child
                'child_name' => 'required|string|max:255',
                'child_nik' => 'required|numeric|digits:16',
                'child_gender' => 'required|in:L,P',
                'child_birth_place' => 'required|string|max:255',
                'child_birth_date' => 'required|date',
                'child_address' => 'required|string|max:500',
                // Father
                'father_name' => 'required|string|max:255',
                'father_birth_place' => 'required|string|max:255',
                'father_birth_date' => 'required|date',
                'father_address' => 'required|string|max:500',
                // Mother
                'mother_name' => 'required|string|max:255',
                'mother_birth_place' => 'required|string|max:255',
                'mother_birth_date' => 'required|date',
                'mother_address' => 'required|string|max:500',
            ]);
        }

        // Additional validation for Surat Keterangan Ijin Keramaian
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'keramaian')) {
            $rules = array_merge($rules, [
                'event_day' => 'required|string|max:20',
                'event_date' => 'required|date',
                'event_time' => 'required|string|max:50',
                'event_place' => 'required|string|max:255',
                'event_name' => 'required|string|max:255',
                'event_entertainment' => 'nullable|string|max:255',
            ]);
        }

        // Additional validation for Surat Keterangan Domisili
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'domisili')) {
            $rules = array_merge($rules, [
                'previous_address' => 'required|string|max:500',
                'domicile_address' => 'required|string|max:500',
            ]);
        }

        // Additional validation for Surat Keterangan Tidak Mampu
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'tidak mampu')) {
            $rules = array_merge($rules, [
                // Father
                'father_name' => 'required|string|max:255',
                'father_nik' => 'required|numeric|digits:16',
                'father_job' => 'required|string|max:255',
                'father_address' => 'required|string|max:500',
                // Mother
                'mother_name' => 'required|string|max:255',
                'mother_nik' => 'required|numeric|digits:16',
                'mother_job' => 'required|string|max:255',
                'mother_address' => 'required|string|max:500',
            ]);
        }

        // Additional validation for Formulir Permohonan KTP
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'ktp')) {
            $rules = array_merge($rules, [
                'ktp_type' => 'required|in:Baru,Perpanjangan,Penggantian',
            ]);
        }

        $request->validate($rules);

        $data = [
            'user_id' => auth()->id(),
            'letter_type_id' => $request->letter_type_id,
            'purpose' => $request->purpose,
            'request_date' => now(),
            'status' => 'pending',
        ];

        // Store specific data for Surat Kematian
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'kematian')) {
            $data['data'] = $request->only([
                'deceased_name', 'deceased_nik', 'deceased_kk', 
                'deceased_birth_place', 'deceased_birth_date', 'deceased_age', 
                'deceased_address', 'death_day', 'death_date', 
                'death_place', 'death_cause', 'reporter_relationship'
            ]);
        }

        // Store specific data for Surat Keterangan Usaha
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'usaha')) {
            $data['data'] = $request->only([
                'business_name', 'business_type', 'business_address'
            ]);
        }

        // Store specific data for Surat Ijin Cuti
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'cuti') || \Illuminate\Support\Str::contains(strtolower($letterType->name), 'ijin')) {
            $data['data'] = $request->only([
                'company_name', 'leave_day', 'leave_date', 'leave_purpose', 'child_name'
            ]);
        }
        
         // Store specific data for Surat Keterangan Nicht Bekerja / Tidak Memiliki Ijazah
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'tidak bekerja') || \Illuminate\Support\Str::contains(strtolower($letterType->name), 'tidak memiliki ijazah')) {
            $data['data'] = $request->only([
                'marital_status'
            ]);
        }

        // Store specific data for Surat Keterangan Kelahiran
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'kelahiran')) {
            $data['data'] = $request->only([
                'child_name', 'child_nik', 'child_gender', 'child_birth_place', 'child_birth_date', 'child_address',
                'father_name', 'father_birth_place', 'father_birth_date', 'father_address',
                'mother_name', 'mother_birth_place', 'mother_birth_date', 'mother_address',
            ]);
        }

        // Store specific data for Surat Keterangan Ijin Keramaian
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'keramaian')) {
            $data['data'] = $request->only([
                'event_day', 'event_date', 'event_time', 'event_place', 'event_name', 'event_entertainment'
            ]);
        }

        // Store specific data for Surat Keterangan Domisili
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'domisili')) {
            $data['data'] = $request->only([
                'previous_address', 'domicile_address'
            ]);
        }

        // Store specific data for Surat Keterangan Tidak Mampu
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'tidak mampu')) {
            $data['data'] = $request->only([
                'father_name', 'father_nik', 'father_job', 'father_address',
                'mother_name', 'mother_nik', 'mother_job', 'mother_address',
            ]);
        }

        // Store specific data for Formulir Permohonan KTP
        if (\Illuminate\Support\Str::contains(strtolower($letterType->name), 'ktp')) {
            $data['data'] = $request->only([
                'ktp_type'
            ]);
        }

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

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
        if ($letter->user_id !== auth()->id()) {
            abort(403);
        }

        // Ideally only verified letters
        if ($letter->status !== 'verified') {
            return back()->with('error', 'Surat belum terverifikasi.');
        }

        $view = 'pdf.letter';
        
        if (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'skck')) {
            $view = 'pdf.skck';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'kematian')) {
            $view = 'pdf.surat-kematian';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'usaha')) {
            $view = 'pdf.surat-keterangan-usaha';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'cuti') || \Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'ijin')) {
            $view = 'pdf.surat-keterangan-ijin-cuti';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'tidak bekerja')) {
            $view = 'pdf.surat-keterangan-tidak-bekerja';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'tidak memiliki ijazah')) {
            $view = 'pdf.surat-keterangan-tidak-memiliki-ijazah';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'kelahiran')) {
            $view = 'pdf.surat-keterangan-kelahiran';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'keramaian')) {
            $view = 'pdf.surat-keterangan-ijin-keramaian';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'domisili')) {
            $view = 'pdf.surat-keterangan-domisili';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'tidak mampu')) {
            $view = 'pdf.surat-keterangan-tidak-mampu';
        } elseif (\Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'ktp')) {
            return $this->generateKtpExcel($letter);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($view, compact('letter'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Surat-' . str_replace('/', '-', $letter->letter_number) . '.pdf');
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
        $sheet->setCellValue('L' . $row, '..........................., ' . now()->translatedFormat('d F Y'));
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
