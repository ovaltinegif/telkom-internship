<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengajuan Izin Magang</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #334155; line-height: 1.6; padding: 30px; background-color: #f8fafc;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #e2e8f0;">
        <h2 style="color: #0f172a; margin-top: 0; font-size: 24px; font-weight: 800;">Pengajuan Izin Baru</h2>
        
        <p style="font-size: 16px; color: #475569;">Halo Bapak/Ibu Mentor,</p>
        <p style="font-size: 16px; color: #475569;">Terdapat pengajuan izin ketidakhadiran baru dari mahasiswa/siswa magang binaan Anda yang membutuhkan review. Berikut rinciannya:</p>
        
        <div style="background-color: #f1f5f9; padding: 20px; border-radius: 8px; margin: 25px 0;">
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 10px;"><strong style="color: #1e293b; display: inline-block; width: 140px;">Nama:</strong> {{ $internUser->name }}</li>
                <li style="margin-bottom: 10px;"><strong style="color: #1e293b; display: inline-block; width: 140px;">Asal Instansi:</strong> {{ $internUser->studentProfile->institution ?? 'Instansi' }}</li>
                <li style="margin-bottom: 10px;"><strong style="color: #1e293b; display: inline-block; width: 140px;">Kategori Izin:</strong> {{ $permissionData['permit_type'] === 'full' ? 'Full Day' : 'Sementara' }}</li>
                <li style="margin-bottom: 10px;"><strong style="color: #1e293b; display: inline-block; width: 140px;">Waktu Pelaksanaan:</strong> {{ $permissionData['duration_text'] }}</li>
                <li style="margin-bottom: 0;"><strong style="color: #1e293b; display: inline-block; width: 140px; vertical-align: top;">Alasan/Keterangan:</strong> <span style="display: inline-block; width: calc(100% - 150px); vertical-align: top;">{{ $permissionData['reason'] }}</span></li>
            </ul>
        </div>

        <div style="text-align: center; margin: 35px 0;">
            <a href="{{ route('mentor.dashboard') }}" style="background-color: #e11d48; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; font-size: 16px; box-shadow: 0 4px 6px -1px rgba(225, 29, 72, 0.4);">
                Review Pengajuan di Dashboard
            </a>
        </div>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-top: 40px; margin-bottom: 20px;">
        
        <p style="font-size: 12px; color: #94a3b8; text-align: center; margin-bottom: 0;">
            Email ini dikirim secara otomatis oleh Sistem Manajemen Magang Telkom Witel Semarang. Mohon untuk tidak membalas langsung ke alamat email ini.
        </p>
    </div>
</body>
</html>
