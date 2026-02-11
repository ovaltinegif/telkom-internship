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
        
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #d32f2f; margin: 20px 0;">
            <p style="margin: 0;"><strong>Langkah Selanjutnya:</strong></p>
            <p>silakan mengambil ID Card di unit Shared Service & General Support.</p>
            <p>Terima kasih.</p>
        </div>

        <p>Tanggal Mulai Magang: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</p>
        
        <p>Silakan login ke dashboard untuk melihat detail mentor dan divisi Anda.</p>
        
        <p>Terima kasih,<br>Tim Magang Telkom</p>
    </div>
</body>
</html>
