<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logbook Magang - {{ $internship->student->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }
        .kop-surat {
            width: 100%;
            border-bottom: 4px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .kop-surat table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-surat td {
            vertical-align: middle;
        }
        .kop-logo {
            width: 120px;
            text-align: center;
        }
        .kop-text {
            text-align: center;
        }
        .kop-text h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }
        .kop-text h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
            font-weight: bold;
            color: #000;
        }
        .kop-text p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #000;
        }
        .document-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .document-title h3 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
            text-decoration: underline;
            color: #000;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 3px 0;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .main-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            color: #000;
        }
        .status-badge {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
        }
        .status-approved {
            color: #065f46;
            background-color: #d1fae5;
        }
        .status-pending {
            color: #92400e;
            background-color: #fef3c7;
        }
        .footer {
            margin-top: 40px;
            text-align: left;
            font-size: 10px;
            color: #000;
            font-style: italic;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <table>
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('images/logo-telkom.png') }}" style="width: 100px;">
                </td>
                <td class="kop-text">
                    <h1>PT TELKOM INDONESIA (PERSERO) Tbk</h1>
                    <h2>Witel Semarang - Shared Service & General Support</h2>
                    <p>Jl. Pahlawan No. 10, Semarang, Jawa Tengah 50241</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="document-title">
        <h3>Logbook Kegiatan Magang</h3>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama Mahasiswa</td>
            <td>: {{ $internship->student->name }}</td>
            <td class="info-label">Divisi / Unit</td>
            <td>: {{ $internship->division->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Mentor</td>
            <td>: {{ $internship->mentor->name ?? '-' }}</td>
            <td class="info-label">Periode</td>
            <td>: {{ \Carbon\Carbon::parse($internship->start_date)->isoFormat('D MMMM YYYY') }} - {{ \Carbon\Carbon::parse($internship->end_date)->isoFormat('D MMMM YYYY') }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th style="width: 100px;">Hari / Tanggal</th>
                <th>Aktivitas & Kegiatan</th>
                <th style="width: 80px; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbooks as $index => $logbook)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($logbook->date)->isoFormat('dddd') }},<br>
                        {{ \Carbon\Carbon::parse($logbook->date)->isoFormat('D MMMM YYYY') }}
                    </td>
                    <td>
                        <div style="font-weight: bold; margin-bottom: 5px; font-size: 12px; color: #000;">
                            {{ $logbook->title ?? '-' }}
                        </div>
                        <div style="color: #444;">
                            {!! $logbook->activity !!}
                        </div>
                    </td>
                    <td style="text-align: center;">
                        @if($logbook->status == 'approved')
                            <span class="status-badge status-approved">Disetujui</span>
                        @else
                            <span class="status-badge status-pending">Menunggu</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #777;">Belum ada aktivitas yang dicatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak otomatis melalui Internship Management System (IMS) Telkom Witel Semarang pada {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB
    </div>
</body>
</html>
