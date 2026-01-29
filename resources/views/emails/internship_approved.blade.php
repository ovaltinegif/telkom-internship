<!DOCTYPE html>
<html>
<head>
    <title>Magang Diterima</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo, {{ $internship->student->name }}!</h2>
    
    <p>Selamat! Pengajuan magang Anda di <strong>Telkom Witel Jateng Semarang Utara</strong> telah verifikasi dan <strong>DITERIMA</strong>.</p>
    
    <h3>Detail Magang:</h3>
    <ul>
        <li><strong>Posisi:</strong> {{ $internship->division->name }}</li>
        <li><strong>Mentor:</strong> {{ $internship->mentor->name ?? 'Akan diinformasikan' }}</li>
        <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}</li>
        <li><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</li>
    </ul>

    <p>Status akun Anda sekarang <strong>AKTIF</strong>. Anda sekarang dapat login dan mengakses menu <strong>Logbook Harian</strong> untuk mencatat aktivitas magang Anda.</p>

    <p>
        <a href="{{ route('login') }}" style="background-color: #dc2626; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Login ke Dashboard</a>
    </p>

    <p>Semangat dan sukses untuk magang Anda!</p>
    
    <hr>
    <p style="font-size: 12px; color: #777;">Email ini dikirim secara otomatis oleh Sistem Magang Telkom.</p>
</body>
</html>
