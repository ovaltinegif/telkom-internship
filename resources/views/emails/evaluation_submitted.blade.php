<!DOCTYPE html>
<html>
<head>
    <title>Evaluasi Magang Selesai</title>
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
        .score-box {
            background-color: white;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            text-align: center;
        }
        .final-score {
            font-size: 32px;
            font-weight: bold;
            color: #ef4444;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            background-color: #ef4444;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
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
        <h2>Nilai Magang Anda Telah Keluar</h2>
    </div>
    
    <div class="content">
        <p>Halo, <strong>{{ $internship->student->name }}</strong>,</p>
        
        <p>Mentor Anda, <strong>{{ $internship->mentor->name }}</strong>, telah memberikan nilai akhir (*Evaluation*) untuk program magang Anda di divisi <strong>{{ $internship->division->name }}</strong>.</p>
        
        <div class="score-box">
            <p style="margin: 0;">Nilai Akhir Anda:</p>
            <div class="final-score">{{ $evaluation->final_score }} / 100</div>
        </div>

        <p>Silakan masuk ke aplikasi Telkom Internship untuk melihat rincian nilai beserta *feedback* (masukan) dari Mentor Anda di menu **Documents** atau *Dashboard* Anda.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('documents.index') }}" class="btn">Lihat Detail Nilai</a>
        </div>
    </div>

    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem Telkom Internship.<br>
        PT Telkom Indonesia (Persero) Tbk.</p>
    </div>
</body>
</html>
