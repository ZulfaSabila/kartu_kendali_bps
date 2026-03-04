<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - Kartu Kendali BPS</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --bps-blue-primary: #003366;
                --bps-blue-dark: #001f3d;
                --bps-green: #77B02A;
                --bps-accent: #00AEEF;
            }

            body {
                /* Gradient Background yang lebih dalam dan profesional */
                background: radial-gradient(circle at top right, var(--bps-blue-primary), var(--bps-blue-dark));
                font-family: 'Plus Jakarta Sans', sans-serif;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                overflow: hidden;
            }

            /* Elemen Dekoratif Halus di Background */
            body::before {
                content: "";
                position: absolute;
                width: 500px;
                height: 500px;
                background: rgba(119, 176, 42, 0.05);
                border-radius: 50%;
                top: -100px;
                left: -100px;
                z-index: 0;
            }

            .login-container {
                position: relative;
                z-index: 1;
                width: 100%;
                max-width: 440px;
                padding: 20px;
                animation: fadeIn 0.8s ease-out;
            }

            .header-branding {
                text-align: center;
                margin-bottom: 2.5rem;
            }

            .bps-logo {
                width: 120px;
                height: auto;
                margin-bottom: 1.5rem;
                filter: drop-shadow(0 8px 15px rgba(0, 0, 0, 0.3));
            }

            .title-main {
                color: #ffffff;
                font-weight: 800;
                font-size: 1.5rem;
                letter-spacing: -0.02em;
                margin: 0;
                text-shadow: 0 4px 10px rgba(0,0,0,0.2);
            }

            .title-sub {
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.85rem;
                font-weight: 500;
                letter-spacing: 0.3em;
                text-transform: uppercase;
                margin-top: 0.5rem;
            }

            .login-card {
                background: rgba(255, 255, 255, 1);
                border-radius: 24px; /* Sudut lebih membulat (modern) */
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                padding: 45px;
                position: relative;
                overflow: hidden;
            }

            /* Garis Aksen Hijau Modern */
            .login-card::after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 5px;
                background: linear-gradient(90deg, var(--bps-green), #9ed157);
            }

            /* Footer Styling */
            .footer-copyright {
                text-align: center;
                margin-top: 3rem;
                color: rgba(255, 255, 255, 0.5);
                font-size: 0.75rem;
                line-height: 1.6;
            }

            .footer-copyright b {
                color: rgba(255, 255, 255, 0.8);
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Customizing Inner Form (Slot) if needed */
            ::placeholder { color: #94a3b8 !important; }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="header-branding">
                <a href="/">
                    <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="bps-logo mx-auto">
                </a>
                <h1 class="title-main">KARTU KENDALI BMN</h1>
            </div>

            <div class="login-card">
                <div class="form-wrapper">
                    {{ $slot }}
                </div>
            </div>

            <footer class="footer-copyright">
                <p>
                    &copy; {{ date('Y') }} <b>Badan Pusat Statistik Kota Bontang</b><br>
                </p>
            </footer>
        </div>
    </body>
</html>