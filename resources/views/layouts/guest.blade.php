<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="transition-colors duration-300">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Telkom Witel Internship') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        // Force light mode on guest pages (login/register)
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    </script>

    <style>
        /* Custom CSS untuk Telkom Witel Internship Theme */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }
        .logo img { height: 80px; width: auto; transition: all 0.3s ease; }
        .main-website-btn {
            background-color: #D6001C; color: #fff; text-decoration: none;
            padding: 10px 25px; border-radius: 20px; font-weight: bold; font-size: 14px;
            box-shadow: 0 4px 12px rgba(214,0,28,0.2); transition: all 0.3s ease;
        }
        .main-website-btn:hover { background-color: #b00017; transform: translateY(-1px); box-shadow: 0 6px 15px rgba(214,0,28,0.3); }

        /* Main Content */
        main {
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            padding-bottom: 50px;
            min-height: 90vh;
            justify-content: center;
        }
        h1.page-title {
            font-family: 'Times New Roman', Times, serif; font-size: 120px; font-weight: normal;
            margin: 0 0 65px 0; text-align: center; color: #000; line-height: 1;
            display: block; height: 300px; overflow: hidden; margin: 0 0 -60px 0; padding-top: 0px;
        }

        /* Hero & Form Section */
        .hero-section {
            position: relative; width: 100%; display: flex; justify-content: center;
            align-items: center; padding: 0 0 20px 0;
        }
        .red-stripe {
            position: absolute; background-color: #EE0000; height: 420px; width: 100%;
            z-index: 1; top: 50%; transform: translateY(-50%);
            box-shadow: inset 0 0 100px rgba(0,0,0,0.1);
        }
        .content-container {
            position: relative; z-index: 2; display: flex; align-items: center;
            justify-content: center; gap: 40px; width: 100%; max-width: 1200px;
        }
        .char-img { height: 470px; width: auto; object-fit: contain; margin-bottom: 30px; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.2)); }

        /* Login Form Styles */
        .login-wrapper { width: 345px; flex-shrink: 0; padding: 0 20px; display: flex; flex-direction: column; }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block; color: #fff; font-weight: 600; font-size: 14px;
            margin-bottom: 5px; text-align: left;
        }
        .custom-input {
            width: 100%; padding: 12px 18px; border-radius: 12px; border: 2px solid transparent;
            background-color: #FEF2D5; font-size: 14px; outline: none; box-sizing: border-box;
            transition: all 0.3s ease; color: #333;
        }
        .custom-input:focus { border-color: #fff; box-shadow: 0 0 15px rgba(255,255,255,0.3); }
        .forgot-password { text-align: right; margin-top: -10px; margin-bottom: 20px; }
        .forgot-password a { color: #fff; font-size: 12px; text-decoration: none; opacity: 0.8; transition: opacity 0.3s; }
        .forgot-password a:hover { opacity: 1; text-decoration: underline; }
        .login-btn {
            width: 100%; padding: 14px; background: linear-gradient(135deg, #ff4d4d 0%, #b30000 100%);
            border: 2px solid rgba(255,255,255,0.2); color: white; font-weight: 800; border-radius: 25px;
            cursor: pointer; box-shadow: 0 8px 20px rgba(179,0,0,0.3); font-size: 16px; text-transform: uppercase; letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .login-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(179,0,0,0.4); border-color: rgba(255,255,255,0.4); }
        .login-btn:active { transform: translateY(0); }

    </style>
</head>
<body class="bg-white text-slate-800 transition-colors duration-300">

    <header class="bg-white border-b border-slate-50">
        <div class="flex-shrink-0 group">
            <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom Indonesia" class="h-20 w-auto dark:hidden transition-all">
            <img src="{{ asset('images/logo-telkom-white.png') }}" alt="Telkom Indonesia Logo" class="h-20 w-auto hidden dark:block transition-all">
        </div>
        <a href="/" class="main-website-btn">Main Website</a>
    </header>

    <main>
        {{ $slot }}
    </main>

    @include('partials.footer')

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

</body>
</html>
                                                                                                                                                                                                                     