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
        }
        .content-container {
            position: relative; z-index: 2; display: flex; align-items: center;
            justify-content: center; gap: 20px; width: 100%; max-width: 1200px;
        }
        .char-img { height: 470px; width: auto; object-fit: contain; margin-bottom: 30px; }

        /* Login Form Styles */
        .login-wrapper { width: 345px; flex-shrink: 0; padding: 0 20px; display: flex; flex-direction: column; }
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

    @include('partials.footer')

</body>
</html>                                                                                                                                                                                                                     