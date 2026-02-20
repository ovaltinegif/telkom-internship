<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - {{ $internship->student->name }}</title>
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 11pt; 
            line-height: 1.5; 
            color: #000; 
            padding: 40px 60px; 
            max-width: 800px; 
            margin: 0 auto; 
            background: white;
        }
        
        /* Header Section */
        .header-container { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        .header-left table { width: 100%; border-collapse: collapse; }
        .header-left td { padding: 2px 0; vertical-align: top; }
        .header-left .label { width: 80px; }
        .header-left .colon { width: 10px; text-align: center; }
        
        .logo img { height: 140px; }
        .logo p { font-size: 8pt; margin: 5px 0 0; font-style: italic; text-align: right; color: #555; }

        /* Addressee */
        .addressee { margin-bottom: 30px; }
        .addressee p { margin: 2px 0; }

        /* Body */
        .content { text-align: justify; margin-bottom: 20px; }
        
        /* Student Info Table */
        .student-info { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .student-info td { padding: 4px 10px; vertical-align: top; }
        .student-info .label { width: 20px; text-align: center; font-weight: bold; }
        .student-info .field { width: 150px; font-weight: bold; }
        .student-info .val { font-weight: bold; }

        /* Generic Table Style (for Attendance & Logbook) */
        .data-table { width: 100%; border-collapse: collapse; margin: 10px 0 30px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 6px; text-align: center; font-size: 10pt; vertical-align: middle; }
        .data-table th { background-color: #f9f9f9; font-weight: bold; }
        .data-table td.text-left { text-align: left; }
        .data-table .empty-row td { padding: 20px; font-style: italic; color: #666; }

        /* Section Headers */
        h4 { margin: 0 0 10px 0; font-size: 11pt; text-transform: uppercase; border-bottom: 1px solid #000; display: inline-block; padding-bottom: 2px; }

        /* Footer / Signature */
        .footer { margin-top: 40px; }
        .signature-block { width: 250px; float: left; } 
        
        .signature-block p { margin: 0; }
        .signature-block .role { font-weight: bold; margin-bottom: 10px; }
        .signature-block .qr-code { 
            width: 100px; height: 100px; margin: 5px 0; 
        }
        .signature-block .name { font-weight: bold; text-decoration: underline; }
        .signature-block .id { font-size: 9pt; }

        /* Print Controls */
        @media print {
            body { padding: 0; margin: 20px; box-shadow: none; }
            .print-btn { display: none; }
            /* Ensure tables don't break awkwardly if possible */
            tr { page-break-inside: avoid; }
        }

        .print-btn {
            position: fixed; top: 20px; right: 20px;
            background: #e11d48; color: white; border: none; padding: 10px 20px;
            border-radius: 5px; cursor: pointer; font-family: sans-serif; font-weight: bold;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: background 0.2s;
        }
        .print-btn:hover { background: #be123c; }

        /* Watermark */
        .watermark {
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80pt; color: rgba(0,0,0,0.03); z-index: -1; pointer-events: none;
            white-space: nowrap; font-weight: bold;
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="print-btn">
        <svg style="width:16px;height:16px;display:inline-block;vertical-align:middle;margin-right:5px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
        Cetak Laporan
    </button>
    
    <!-- Watermark -->
    <div class="watermark">{{ $internship->student->studentProfile->nim ?? 'REPORT' }}</div>

    <!-- Header -->
    <div class="header-container">
        <div class="header-left">
            <table>
                <tr>
                    <td class="label">Nomor</td>
                    <td class="colon">:</td>
                    <td>{{ 'Tel.' . str_pad($internship->id, 3, '0', STR_PAD_LEFT) . '/HC-00/LKB00/' . date('Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td><strong>Laporan Aktivitas & Kehadiran Bulanan</strong></td>
                </tr>
            </table>
        </div>
        <div class="logo">
            <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom Indonesia">
        </div>
    </div>

    <!-- Addressee -->
    <div class="addressee">
        <p>Kepada Yth.</p>
        <p>Manager / Mentor Unit {{ $internship->division->name }}</p>
        <p><strong>PT Telkom Indonesia</strong></p>
        <p>di Tempat</p>
    </div>

    <!-- Body -->
    <div class="content">
        <p>Dengan hormat,</p>
        <p>Berikut kami sampaikan laporan rekapan aktivitas harian (logbook) dan kehadiran (presensi) intern untuk periode <strong>{{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</strong>:</p>
        
        <table class="student-info">
            <tr>
                <td class="label">1.</td>
                <td class="field">Nama</td>
                <td class="colon">:</td>
                <td class="val">{{ $internship->student->name }}</td>
            </tr>
            <tr>
                <td class="label"></td>
                <td class="field">NIM</td>
                <td class="colon">:</td>
                <td class="val">{{ $internship->student->studentProfile->nim ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label"></td>
                <td class="field">Unit Intern</td>
                <td class="colon">:</td>
                <td class="val">{{ $internship->division->name }}</td>
            </tr>
        </table>
    </div>

    <!-- A. Kehadiran -->
    <h4>A. Rekap Kehadiran</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 120px;">Tanggal</th>
                <th style="width: 80px;">Jam Masuk</th>
                <th style="width: 80px;">Jam Keluar</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $att)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                <td>{{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('H:i') : '-' }}</td>
                <td>{{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('H:i') : '-' }}</td>
                <td>
                    <span style="text-transform: capitalize;">{{ $att->status }}</span>
                </td>
                <td class="text-left">{{ $att->notes ?? '-' }}</td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="6">Tidak ada data kehadiran pada bulan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- B. Logbook -->
    <h4>B. Logbook Harian</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 120px;">Tanggal</th>
                <th>Aktivitas</th>
                <th style="width: 100px;">Validasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbooks as $index => $log)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}</td>
                <td class="text-left">{!! $log->activity !!}</td>
                <td>{{ ucfirst($log->status) }}</td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="4">Tidak ada data logbook pada bulan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="content">
        <p>Demikian laporan ini dibuat dengan sebenar-benarnya untuk dapat digunakan sebagai monitoring kegiatan intern.</p>
    </div>

    <!-- Footer / Signature -->
    <div class="footer">
        <div class="signature-block">
            <p>Hormat Kami,</p>
            <p class="role">Intern</p>
            
            <!-- QR Code Validasi -->
            @php
                $qrData = "Validasi Laporan Bulanan - " . $internship->student->name . " - " . \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y');
            @endphp
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrData) }}" class="qr-code" alt="QR Code Validasi">

            <p class="name">{{ $internship->student->name }}</p>
            <p class="id">NIM. {{ $internship->student->studentProfile->nim ?? '-' }}</p>
        </div>
    </div>

</body>
</html>
