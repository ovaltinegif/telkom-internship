<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notifikasi Admin Web Magang</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #334155; line-height: 1.6; padding: 30px; background-color: #f8fafc;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #e2e8f0;">
        <h2 style="color: #0f172a; margin-top: 0; font-size: 24px; font-weight: 800;">Notifikasi Sistem Magang</h2>
        
        <p style="font-size: 16px; color: #475569;">Halo Admin,</p>

        @if($type === 'new_applicant')
            <p style="font-size: 16px; color: #475569;">Sistem mendeteksi adanya <strong>pengajuan magang baru</strong>. Pendaftar telah melengkapi data profil dan dokumen awal. Mohon segera melakukan reviu atas pengajuan ini. Saat ini status pendaftar adalah <strong>Pending</strong>.</p>
        @elseif($type === 'needs_induction')
            <p style="font-size: 16px; color: #475569;">Seorang mahasiswa magang telah berhasil mengunggah <strong>Pakta Integritas</strong> yang sudah ditandatangani. Anda dapat memvalidasinya dan segera mengatur <strong>Jadwal Induksi</strong>. Saat ini status peserta magang adalah <strong>Onboarding</strong>.</p>
        @endif
        
        <div style="background-color: #f1f5f9; padding: 20px; border-radius: 8px; margin: 25px 0;">
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 10px;"><strong style="color: #1e293b; display: inline-block; width: 140px;">Nama Pendaftar:</strong> {{ $internship->student?->name ?? '-' }}</li>
                <li style="margin-bottom: 10px;"><strong style="color: #1e293b; display: inline-block; width: 140px;">Asal Instansi:</strong> {{ $internship->student?->studentProfile?->university ?? '-' }}</li>
                <li style="margin-bottom: 0px;"><strong style="color: #1e293b; display: inline-block; width: 140px;">Jurusan:</strong> {{ $internship->student?->studentProfile?->major ?? '-' }}</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 35px 0;">
            <a href="{{ route('admin.internships.show', $internship->id) }}" style="background-color: #e11d48; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; font-size: 16px; box-shadow: 0 4px 6px -1px rgba(225, 29, 72, 0.4);">
                Buka Detail Mahasiswa
            </a>
        </div>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-top: 40px; margin-bottom: 20px;">
        
        <p style="font-size: 12px; color: #94a3b8; text-align: center; margin-bottom: 0;">
            Email ini dikirim secara otomatis oleh Sistem Manajemen Magang Telkom Witel Semarang. Mohon untuk tidak membalas langsung ke alamat email ini; gunakan tombol Reply di email client Anda untuk menghubungi pendaftar langsung.
        </p>
    </div>
</body>
</html>
