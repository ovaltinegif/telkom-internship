<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transkrip Nilai Magang - {{ $internship->student->name }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.5; color: #000; padding: 40px; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #000; padding-bottom: 20px; }
        .header img { max-height: 80px; margin-bottom: 10px; }
        .header h1 { font-size: 18pt; margin: 0; text-transform: uppercase; }
        .header h2 { font-size: 14pt; margin: 5px 0 0; font-weight: normal; }
        
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { padding: 5px 0; vertical-align: top; }
        .info-table .label { width: 150px; font-weight: bold; }
        .info-table .colon { width: 20px; text-align: center; }

        .grades-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .grades-table th, .grades-table td { border: 1px solid #000; padding: 10px; text-align: center; }
        .grades-table th { background-color: #f0f0f0; font-weight: bold; }
        .grades-table td.text-left { text-align: left; }

        .footer { margin-top: 50px; display: flex; justify-content: flex-end; }
        .signature { text-align: center; width: 250px; }
        .signature p { margin: 0; }
        .signature .date { margin-bottom: 80px; }
        .signature .name { font-weight: bold; text-decoration: underline; }

        @media print {
            body { padding: 0; }
            button { display: none; }
        }

        .print-btn {
            position: fixed; top: 20px; right: 20px;
            background: #0ea5e9; color: white; border: none; padding: 10px 20px;
            border-radius: 5px; cursor: pointer; font-family: sans-serif; font-weight: bold;
        }
        .print-btn:hover { background: #0284c7; }
    </style>
</head>
<body>

    <button onclick="window.print()" class="print-btn">Cetak Transkrip</button>

    <div class="header">
        <h1>Transkrip Nilai Magang</h1>
        <h2>PT Telkom Indonesia (Persero) Tbk</h2>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Mahasiswa</td>
            <td class="colon">:</td>
            <td>{{ $internship->student->name }}</td>
        </tr>
        <tr>
            <td class="label">Asal Instansi</td>
            <td class="colon">:</td>
            <td>{{ $internship->student->studentProfile->university }}</td>
        </tr>
        <tr>
            <td class="label">Divisi Magang</td>
            <td class="colon">:</td>
            <td>{{ $internship->division->name }}</td>
        </tr>
        <tr>
            <td class="label">Periode Magang</td>
            <td class="colon">:</td>
            <td>{{ \Carbon\Carbon::parse($internship->start_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($internship->end_date)->format('d F Y') }}</td>
        </tr>
    </table>

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
                <td class="text-left">Kedisiplinan & Etika Kerja</td>
                <td>{{ $internship->evaluation->discipline_score }}</td>
                <td>{{ $internship->evaluation->discipline_score >= 85 ? 'A' : ($internship->evaluation->discipline_score >= 70 ? 'B' : 'C') }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="text-left">Kemampuan Teknis & Hasil Kerja</td>
                <td>{{ $internship->evaluation->technical_score }}</td>
                <td>{{ $internship->evaluation->technical_score >= 85 ? 'A' : ($internship->evaluation->technical_score >= 70 ? 'B' : 'C') }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td class="text-left">Komunikasi & Kerjasama Tim</td>
                <td>{{ $internship->evaluation->soft_skill_score }}</td>
                <td>{{ $internship->evaluation->soft_skill_score >= 85 ? 'A' : ($internship->evaluation->soft_skill_score >= 70 ? 'B' : 'C') }}</td>
            </tr>
            <tr style="font-weight: bold; background-color: #fafafa;">
                <td colspan="2" class="text-right" style="padding-right: 20px;">Nilai Akhir Rata-Rata</td>
                <td style="font-size: 14pt;">{{ $internship->evaluation->final_score }}</td>
                <td style="font-size: 14pt;">{{ $internship->evaluation->final_score >= 85 ? 'A' : ($internship->evaluation->final_score >= 70 ? 'B' : 'C') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p class="date">Jakarta, {{ now()->format('d F Y') }}</p>
            <p>Pembimbing Lapangan,</p>
            <br><br><br>
            <p class="name">{{ $internship->mentor ? $internship->mentor->name : 'Manager Divisi' }}</p>
            <p>NIP. ...........................</p>
        </div>
    </div>

</body>
</html>
