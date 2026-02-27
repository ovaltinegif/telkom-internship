<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transkrip Nilai Intern - {{ $internship->student->name }}</title>
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 11pt; 
            line-height: 1.4; 
            color: #000; 
            padding: 20px 40px; 
            max-width: 800px; 
            margin: 0 auto; 
            background: white;
        }
        
        /* Header Section */
        .header-container { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
        .header-left table { width: 100%; border-collapse: collapse; }
        .header-left td { padding: 2px 0; vertical-align: top; }
        .header-left .label { width: 80px; }
        .header-left .colon { width: 10px; text-align: center; }
        
        .logo img { height: 140px; }
        .logo p { font-size: 8pt; margin: 5px 0 0; font-style: italic; text-align: right; color: #555; }

        /* Addressee */
        .addressee { margin-bottom: 20px; }
        .addressee p { margin: 2px 0; }

        /* Body */
        .content { text-align: justify; margin-bottom: 15px; }
        
        /* Student Info Table */
        .student-info { width: 100%; margin: 10px 0; border-collapse: collapse; }
        .student-info td { padding: 4px 10px; vertical-align: top; }
        .student-info .label { width: 20px; text-align: center; font-weight: bold; }
        .student-info .field { width: 150px; font-weight: bold; }
        .student-info .val { font-weight: bold; }

        /* Grades Table */
        .grades-table { width: 100%; border-collapse: collapse; margin: 15px 0 20px; page-break-inside: avoid; }
        .grades-table th, .grades-table td { border: 1px solid #000; padding: 8px; text-align: center; font-size: 10pt; }
        .grades-table th { background-color: #f9f9f9; font-weight: bold; }
        .grades-table td.text-left { text-align: left; }
        .grades-table .footer-row { font-weight: bold; background-color: #fafafa; }
        .grades-table .footer-row td { border-top: 2px solid #000; }

        /* Rules List */
        .rules-list { margin: 10px 0 30px 20px; }
        .rules-list li { margin-bottom: 5px; }

        /* Footer / Signature */
        .footer { margin-top: 100px; page-break-inside: avoid; }
        .signature-block { width: 250px; float: left; } /* Or right based on image? Image 3 shows signature at bottom left? No, bottom left usually. Let's check Image 3 again. It has signature on left side? Mentors usually sign on right or left. I'll put it on the left as per standard or image. Wait, image 3 has signature on LEFT. "Hormat Kami, QR, Nama". OK. */
        
        .signature-block p { margin: 0; }
        .signature-block .role { font-weight: bold; margin-bottom: 10px; }
        .signature-block .qr-code { 
            width: 100px; height: 100px; margin: 5px 0; 
        }
        .signature-block .name { font-weight: bold; text-decoration: underline; }
        .signature-block .id { font-size: 9pt; }

        /* Print Controls */
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
            body { padding: 0 !important; margin: 0 !important; box-shadow: none; font-size: 10pt; line-height: 1.3; }
            .print-btn { display: none; }
            .watermark { font-size: 70pt; }
        }

        .print-btn {
            position: fixed; top: 20px; right: 20px;
            background: #e11d48; color: white; border: none; padding: 10px 20px;
            border-radius: 5px; cursor: pointer; font-family: sans-serif; font-weight: bold;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: background 0.2s;
        }
        .print-btn:hover { background: #be123c; }

        /* Watermark (Optional based on image) */
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
        Cetak Dokumen
    </button>
    
    <!-- Watermark -->
    <div class="watermark">{{ $internship->student->studentProfile->nim ?? 'TRANSKRIP' }}</div>

    <!-- Header -->
    <div class="header-container">
        <div class="header-left">
            <table>
                <tr>
                    <td class="label">Nomor</td>
                    <td class="colon">:</td>
                    <td>{{ 'Tel.' . str_pad($internship->id, 3, '0', STR_PAD_LEFT) . '/HC-00/HK000/' . date('Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>1 (satu) lembar</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td><strong>Transkrip Nilai Intern Industri</strong></td>
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
        <p>Ketua Program Studi / Koordinator Intern</p>
        <p><strong>{{ $internship->student->studentProfile->university ?? 'Universitas' }}</strong></p>
        <p>di Tempat</p>
    </div>

    <!-- Body -->
    <div class="content">
        <p>Dengan hormat,</p>
        <p>Sehubungan dengan telah berakhirnya pelaksanaan program Intern Industri intern berikut:</p>
        
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
            <tr>
                <td class="label"></td>
                <td class="field">Mentor</td>
                <td class="colon">:</td>
                <td class="val">{{ $internship->mentor ? $internship->mentor->name : '-' }}</td>
            </tr>
        </table>

        <p>Dengan ini kami sampaikan hasil penilaian akhir (Transkrip Nilai) selama periode magang tanggal <strong>{{ \Carbon\Carbon::parse($internship->start_date)->isoFormat('D MMMM Y') }}</strong> s.d. <strong>{{ \Carbon\Carbon::parse($internship->end_date)->isoFormat('D MMMM Y') }}</strong> sebagai berikut:</p>
    </div>

    <!-- Grades Table -->
    <table class="grades-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Komponen Penilaian</th>
                <th style="width: 100px;">Nilai</th>
                <th style="width: 100px;">Predikat</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="text-left">Kedisiplinan & Etika Kerja (Discipline)</td>
                <td>{{ $internship->evaluation->discipline_score }}</td>
                <td>{{ $internship->evaluation->discipline_score >= 85 ? 'A' : ($internship->evaluation->discipline_score >= 70 ? 'B' : 'C') }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="text-left">Kemampuan Teknis & Hasil Kerja (Technical Skill)</td>
                <td>{{ $internship->evaluation->technical_score }}</td>
                <td>{{ $internship->evaluation->technical_score >= 85 ? 'A' : ($internship->evaluation->technical_score >= 70 ? 'B' : 'C') }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td class="text-left">Komunikasi & Kerjasama Tim (Soft Skill)</td>
                <td>{{ $internship->evaluation->soft_skill_score }}</td>
                <td>{{ $internship->evaluation->soft_skill_score >= 85 ? 'A' : ($internship->evaluation->soft_skill_score >= 70 ? 'B' : 'C') }}</td>
            </tr>
            <tr class="footer-row">
                <td colspan="2" style="text-align: right; padding-right: 20px;">NILAI AKHIR (FINAL SCORE)</td>
                <td style="font-size: 11pt;">{{ $internship->evaluation->final_score }}</td>
                <td style="font-size: 11pt;">{{ $internship->evaluation->final_score >= 85 ? 'A' : ($internship->evaluation->final_score >= 70 ? 'B' : 'C') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="content">
        <p>Demikian surat keterangan dan transkrip nilai ini kami sampaikan untuk dapat dipergunakan sebagaimana mestinya. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
    </div>

    <!-- Footer / Signature -->
    <div class="footer">
        <div class="signature-block">
            <p>Hormat Kami,</p>
            <p class="role">Mgr Shared Service & General Support</p>
            
            <!-- QR Code Validasi -->
            @php
                $qrData = "Validasi Dokumen Intern Telkom - " . $internship->student->name . " - " . ($internship->student->studentProfile->nim ?? '') . " - Nilai Akhir: " . $internship->evaluation->final_score;
            @endphp
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrData) }}" class="qr-code" alt="QR Code Validasi">

            <p class="name">{{ $internship->mentor ? $internship->mentor->name : 'Lulu Kurnijati, S.T.' }}</p>
            <p class="id">NIK. {{ $internship->mentor ? '940012' : '......................' }}</p>
        </div>
    </div>

</body>
</html>
