<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Telkom Witel Internship') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom CSS untuk Telkom Witel Internship Theme */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background-color: #fff;
        }
        .logo img { height: 100px; width: auto; }
        .main-website-btn {
            background-color: #D6001C; color: #fff; text-decoration: none;
            padding: 10px 25px; border-radius: 20px; font-weight: bold; font-size: 14px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: background 0.3s;
        }
        .main-website-btn:hover { background-color: #b00017; }

        /* Main Content */
        main {
            flex: 1; display: flex; flex-direction: column; align-items: center; padding-bottom: 50px;
        }
        h1.page-title {
            font-family: 'Times New Roman', Times, serif; font-size: 100px; font-weight: normal;
            margin: 30px 0 40px 0; text-align: center; color: #000;
        }

        /* Hero & Form Section */
        .hero-section {
            position: relative; width: 100%; display: flex; justify-content: center;
            align-items: center; padding: 20px 0;
        }
        .red-stripe {
            position: absolute; background-color: #EE0000; height: 420px; width: 100%;
            z-index: 1; top: 45%; transform: translateY(-50%);
        }
        .content-container {
            position: relative; z-index: 2; display: flex; align-items: center;
            justify-content: center; gap: 20px; width: 100%; max-width: 1200px;
        }
        .char-img { height: 380px; width: auto; object-fit: contain; }

        /* Login Form Styles */
        .login-wrapper { width: 320px; padding: 0 20px; display: flex; flex-direction: column; }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block; color: #fff; font-weight: 600; font-size: 14px;
            margin-bottom: 5px; text-align: left;
        }
        .custom-input {
            width: 100%; padding: 12px 15px; border-radius: 12px; border: none;
            background-color: #FEF2D5; font-size: 14px; outline: none; box-sizing: border-box;
        }
        .forgot-password { text-align: right; margin-top: -10px; margin-bottom: 20px; }
        .forgot-password a { color: #fff; font-size: 12px; text-decoration: none; }
        .login-btn {
            width: 100%; padding: 12px; background: radial-gradient(circle, #ff3333 0%, #cc0000 100%);
            border: 2px solid #ff6666; color: white; font-weight: bold; border-radius: 25px;
            cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.3); font-size: 16px;
        }
        .login-btn:hover { transform: scale(1.02); }

        /* Footer */
        footer {
            background-color: #fff;
            padding: 20px 50px; /* Padding sedikit diperkecil biar ga terlalu tebal */
            /* Ganti border keras dengan shadow halus atau border sangat tipis */
            border-top: 1px solid #f2f2f2; 
            display: flex;
            justify-content: space-between;
            align-items: center; /* PENTING: Ubah dari flex-end ke center */
        }

        .footer-left .logo-footer img {
            height: 100px; /* Sedikit diperkecil agar proporsional sebagai footer */
            opacity: 0.8; /* Sedikit transparan biar ga terlalu mencolok */
        }

        .footer-right {
            text-align: right;
            font-size: 13px; /* Font diperkecil sedikit */
            color: #888; /* Warna diubah jadi abu-abu lembut */
            line-height: 1.5;
        }
        
        /* Link phone juga disamakan warnanya */
        .footer-right a {
            color: #888;
            transition: color 0.3s;
        }
        .footer-right a:hover {
            color: #D6001C; /* Merah pas di-hover aja */
        }

        .footer-icons {
            margin-top: 8px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            opacity: 0.7; /* Ikon juga dibuat agak soft */
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom Indonesia Logo">
        </div>
        <a href="/" class="main-website-btn">Main Website</a>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <div class="footer-left">
            <div class="logo-footer">
                <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom Indonesia">
            </div>
        </div>

        <div class="footer-right">
            <p>Jl. Pahlawan No.10, Pleburan, Kec. Semarang Selatan,<br>
            Kota Semarang, Jawa Tengah 50249.<br>
            Phone: <a href="tel:0248302006" style="color: inherit; text-decoration: none;">(024) 8302006</a></p>
            
            <div class="footer-icons">
                <span>📍</span>
                <span>🌐</span>
                <span>✉️</span>
            </div>
            
            <p style="margin-top: 10px; font-size: 12px; color: #666;">© {{ date('Y') }} PT Telkom Indonesia. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>