<!DOCTYPE html>
<html>
<head>
    <title>Panggilan Induksi Magang Telkom</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-top: 5px solid #d32f2f; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #d32f2f; margin-top: 0;">Selamat, Akun Magang Anda Telah Aktif!</h2>
        <p>Halo, <strong>{{ $name }}</strong>,</p>
        <p>Pakta Integritas Anda telah berhasil diverifikasi oleh Admin. Status magang Anda saat ini telah berubah menjadi <strong>ACTIVE</strong>.</p>
        
        <div style="background-color: #fff8f8; padding: 20px; border-left: 4px solid #d32f2f; margin: 25px 0; border-radius: 4px;">
            <p style="margin-top: 0; margin-bottom: 15px; font-weight: bold; color: #d32f2f; font-size: 16px;">Panggilan Induksi Peserta Magang</p>
            <p style="margin-top: 0; margin-bottom: 15px; font-size: 14px;">Anda diwajibkan untuk hadir pada jadwal berikut:</p>
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <tr>
                    <td style="padding: 4px 0; width: 100px; vertical-align: top;"><strong>Kegiatan</strong></td>
                    <td style="padding: 4px 0; vertical-align: top;">: Induksi Peserta Magang & Pengambilan ID Card</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; vertical-align: top;"><strong>Tanggal</strong></td>
                    <td style="padding: 4px 0; vertical-align: top;">: {{ \Carbon\Carbon::parse($inductionData['date'])->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; vertical-align: top;"><strong>Waktu</strong></td>
                    <td style="padding: 4px 0; vertical-align: top;">: {{ \Carbon\Carbon::parse($inductionData['time'])->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; vertical-align: top;"><strong>Tempat</strong></td>
                    <td style="padding: 4px 0; vertical-align: top; line-height: 1.5;">: Ruang Kompeten Unit Shared Service & General Support Witel Semarang Jateng Utara Lantai 2 GMP Pahlawan, Jl. Pahlawan No. 10, Kota Semarang</td>
                </tr>
            </table>
        </div>

        <p><strong>Tanggal Mulai Magang:</strong> {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}</p>
        
        <p>Silakan login ke dashboard sistem untuk melihat detail informasi mengenai Mentor dan Divisi penempatan Anda.</p>

        <div style="text-align: center; margin-top: 30px; margin-bottom: 20px;">
            <a href="{{ route('login') }}" style="background-color: #d32f2f; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">Login ke Dashboard</a>
        </div>
        
        <p style="font-size: 13px; color: #777; border-top: 1px solid #ddd; padding-top: 15px; margin-top: 30px;">
            Terima kasih,<br><strong>Tim Pengelola Magang Telkom</strong>
        </p>
    </div>
</body>
</html>
