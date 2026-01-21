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
            overflow-x: hidden; /* Prevent horizontal scroll */
            /* overflow: hidden; Removed to allow scrolling */
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
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            padding-bottom: 50px;
            min-height: 90vh; /* Ensure content is tall enough to push footer below fold */
            justify-content: center; /* Keep login form centered vertically in the main area */
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
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 40px 20px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .footer-content {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 1100px;
            width: 100%;
            gap: 60px;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }

        .footer-logo {
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }
        .footer-logo:hover {
            transform: scale(1.05);
        }
        .footer-logo img {
            height: 85px;
            width: auto;
            object-fit: contain;
        }

        .footer-divider {
            width: 1px;
            height: 120px;
            background-color: #d1d5db; /* Neutral gray */
        }

        .footer-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
            text-align: left;
            color: #374151; /* Gray-700 */
        }

        .footer-address {
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
            color: #4b5563; /* Gray-600 */
        }

        .footer-contact a {
            color: #374151;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }
        .footer-contact a:hover {
            color: #dc2626; /* Telkom Red */
        }

        .footer-icons {
            display: flex;
            gap: 16px;
            margin-top: 4px;
        }

        .icon-circle {
            width: 36px;
            height: 36px;
            border: 1px solid #9ca3af;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #4b5563;
            transition: all 0.3s ease;
            cursor: pointer;
            background-color: transparent;
        }
        .icon-circle:hover {
            border-color: #dc2626;
            background-color: #dc2626;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        }

        .footer-copyright {
            font-size: 12px;
            color: #9ca3af; /* Gray-400 */
            margin-top: 8px;
            font-weight: 400;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                gap: 30px;
                text-align: center;
            }
            .footer-divider {
                display: none; /* Hide vertical divider on mobile */
            }
            .footer-info {
                align-items: center;
                text-align: center;
            }
            .footer-logo img {
                height: 70px;
            }
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
        <div class="footer-content">
            <!-- Logo Section -->
            <div class="footer-logo">
                <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom Indonesia">
            </div>

            <!-- Vertical Divider (Hidden on Mobile) -->
            <div class="footer-divider"></div>

            <!-- Info Section -->
            <div class="footer-info">
                <p class="footer-address">
                    <strong>Divisi Telkom Regional IV</strong><br>
                    Jl. Pahlawan No.10, Pleburan, Kec. Semarang Selatan,<br>
                    Kota Semarang, Jawa Tengah 50249.
                </p>
                
                <div class="footer-contact">
                    Phone: <a>(024) 8302006</a>
                </div>

                <div class="footer-icons">
                    <!-- Location Icon -->
                    <a href="https://www.google.com/maps/place/TELKOM+WITEL+SEMARANG/@-7.014223,110.4328813,17z/data=!3m1!4b1!4m6!3m5!1s0x2e708c879bc849f1:0x6c1566e0b320bd25!8m2!3d-7.014223!4d110.4354562!16s%2Fg%2F11cm0cwy3t?entry=ttu&g_ep=EgoyMDI2MDExMy4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="icon-circle" title="Location">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </a>
                    <!-- Website Icon -->
                    <a href="https://www.telkom.co.id" target="_blank" class="icon-circle" title="Website">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </a>
                    <!-- Mail Icon -->
                    <a href="mailto:hc.witelsju@gmail.com" class="icon-circle" title="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </a>
                </div>

                <div class="footer-copyright">
                    © {{ date('Y') }} PT Telkom Indonesia (Persero) Tbk. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>