<!DOCTYPE html>
<html>
<head>
    <title>Magang Telkom - ID Card</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #d32f2f;">Selamat, Akun Magang Anda Telah Aktif!</h2>
        <p>Halo, <strong>{{ $name }}</strong></p>
        <p>Pakta Integritas Anda telah diverifikasi oleh admin. Sekarang status magang Anda adalah <strong>ACTIVE</strong>.</p>
        
        <div style="background-color: #f9f9f9; padding: 20px; border-left: 4px solid #d32f2f; margin: 25px 0; border-radius: 0 8px 8px 0;">
            <p style="margin-top: 0; margin-bottom: 15px; font-weight: bold; color: #d32f2f; font-size: 16px;">Panggilan Induksi Peserta Magang</p>
            <ul style="margin: 0; padding-left: 20px; color: #444;">
                <li style="margin-bottom: 8px;"><strong>Kegiatan:</strong> {{ $inductionData['activity'] ?? 'Induksi Peserta Magang' }}</li>
                <li style="margin-bottom: 8px;"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($inductionData['date'])->translatedFormat('l, d F Y') }}</li>
                <li style="margin-bottom: 8px;"><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($inductionData['time'])->format('H:i') }} WIB</li>
                <li style="margin-bottom: 0;"><strong>Tempat:</strong> {{ $inductionData['location'] ?? '-' }}</li>
            </ul>
        </div>

        <p>Tanggal Mulai Magang: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</p>
        
        <p>Silakan login ke dashboard untuk melihat detail mentor dan divisi Anda.</p>

        <p style="margin-top: 25px; margin-bottom: 25px;">
            <a href="{{ route('login') }}" style="background-color: #dc2626; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">Login ke Dashboard</a>
        </p>
        
        <p>Terima kasih,<br>Tim Magang Telkom</p>
    </div>
</body>
</html>
