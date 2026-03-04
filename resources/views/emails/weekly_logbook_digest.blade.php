<!DOCTYPE html>
<html>
<head>
    <title>Weekly Logbook Digest</title>
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
        .student-box {
            background-color: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
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
        <h2>Weekly Logbook Digest</h2>
    </div>
    
    <div class="content">
        <p>Halo, <strong>{{ $mentor->name }}</strong>,</p>
        
        <p>Terdapat logbook harian dari mahasiswa magang bimbingan Anda yang belum dinilai/di-review minggu ini. Berikut adalah rinciannya:</p>

        @foreach($studentsData as $data)
            <div class="student-box">
                <h3 style="margin-top: 0; color: #111827;">{{ $data['student_name'] }}</h3>
                <p style="margin-bottom: 0;"><strong>{{ $data['pending_count'] }}</strong> logbook menunggu *review*.</p>
            </div>
        @endforeach

        <p>Mohon ketersediaan waktu Anda untuk memeriksa logbook mereka di aplikasi Telkom Internship.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('mentor.dashboard') }}" class="btn">Buka Dashboard Mentor</a>
        </div>
    </div>

    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem Telkom Internship.<br>
        PT Telkom Indonesia (Persero) Tbk.</p>
    </div>
</body>
</html>
