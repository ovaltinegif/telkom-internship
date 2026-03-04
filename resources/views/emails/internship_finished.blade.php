<!DOCTYPE html>
<html>
<head>
    <title>Internship Finished</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #ef4444; /* Telkom Red */
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        .btn {
            display: inline-block;
            background-color: #ef4444;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Selamat! Magang Anda Telah Selesai</h2>
    </div>
    
    <div class="content">
        <p>Halo, <strong>{{ $internship->student->name }}</strong>,</p>
        
        <p>Selamat! Program magang Anda di <strong>PT Telkom Indonesia (Persero) Tbk</strong> telah resmi dinyatakan selesai (*Finished*).</p>

        <p>Terima kasih atas kontribusi, dedikasi, dan kerja keras Anda selama menjalankan program magang ini di divisi <strong>{{ $internship->division->name }}</strong> bersama Mentor <strong>{{ $internship->mentor->name }}</strong>.</p>
        
        <p>Saat ini, sertifikat dan transkrip nilai magang Anda mungkin sudah dapat diunduh. Silakan masuk ke aplikasi Telkom Internship untuk melihat informasi kelulusan Anda dan mengunduh dokumen yang diperlukan pada menu <strong>Documents</strong>.</p>

        <div style="text-align: center;">
            <a href="{{ route('documents.index') }}" class="btn">Buka Menu Dokumen</a>
        </div>
        
        <p style="margin-top: 30px;">Semoga pengalaman magang ini bermanfaat untuk perjalanan karir Anda selanjutnya. Sukses selalu!</p>
    </div>

    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem Telkom Internship.<br>
        PT Telkom Indonesia (Persero) Tbk.</p>
    </div>
</body>
</html>
