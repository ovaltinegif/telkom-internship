<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logbook Magang - {{ $internship->student->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ed1c24;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #ed1c24;
            font-size: 20px;
            text-transform: uppercase;
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
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .main-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            color: #555;
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
            text-align: right;
            font-size: 10px;
            color: #777;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Logbook Kegiatan Magang</h1>
        <p>Telkom Indonesia - Internship Management System</p>
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
            <td>: {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</td>
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
                        {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                    </td>
                    <td>
                        {!! $logbook->activity !!}
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
        Dicetak otomatis melalui IMS Telkom pada {{ now()->format('d/m/Y H:i') }} WIB
    </div>
</body>
</html>
