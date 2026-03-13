<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk — Kartu Kendali BPS Kota Bontang</title>

    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bps.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── VARIABEL WARNA BPS ── */
        :root {
            --bps-blue: #003366;
            --bps-blue-dark: #002244;
            --bps-orange: #E8751A;
            --bps-green: #77B02A;
            --white: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.7);
        }

        /* ── RESET & BASE ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bps-blue-dark);
            /* Background gradien agar konsisten dengan hero section welcome page */
            background: radial-gradient(circle at 0% 0%, var(--bps-blue) 0%, var(--bps-blue-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Dekorasi Background Halus */
        body::before {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(232, 117, 26, 0.05) 0%, transparent 70%);
            bottom: -200px;
            right: -100px;
            z-index: 0;
        }

        /* ── CONTAINER UTAMA ── */
        .auth-container {
            width: 100%;
            max-width: 450px;
            z-index: 10;
            animation: fadeInSlide 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* ── BRANDING ── */
        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-logo {
            width: 80px !important; /* Ukuran diperkecil agar tidak raksasa */
            height: auto !important;
            margin: 0 auto 1.2rem auto !important; /* Rata tengah dan beri jarak bawah */
            display: block !important;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.2));
        }
        
        .auth-logo:hover {
            transform: scale(1.05);
        }

        .auth-title {
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .auth-title span {
            color: var(--bps-orange);
        }

        .auth-subtitle {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0.5rem;
        }

        /* ── KARTU FORM (SLOT) ── */
        .auth-card {
            background: var(--white);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        /* Aksen Garis Atas (Konsisten dengan Navbar Welcome Page) */
        .auth-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--bps-blue) 33%, var(--bps-orange) 33%, var(--bps-orange) 66%, var(--bps-green) 66%);
        }

        /* ── FOOTER ── */
        .auth-footer {
            text-align: center;
            margin-top: 2.5rem;
            color: var(--text-muted);
            font-size: 0.8rem;
            line-height: 1.6;
        }

        .auth-footer b {
            color: var(--white);
            font-weight: 600;
        }

        .footer-lines {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 15px;
            opacity: 0.5;
        }

        .footer-lines span {
            height: 3px;
            border-radius: 2px;
        }
        .line-1 { width: 30px; background: var(--bps-blue); }
        .line-2 { width: 15px; background: var(--bps-orange); }
        .line-3 { width: 8px; background: var(--bps-green); }

        /* ── ANIMASI ── */
        @keyframes fadeInSlide {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 20px;
                border-radius: 20px;
            }
            .auth-title {
                font-size: 1.25rem;
            }
            .auth-logo {
                width: 70px;
            }
        }

        /* Menyesuaikan style input bawaan Breeze agar lebih rapi */
        input:focus {
            border-color: var(--bps-blue) !important;
            ring-color: var(--bps-blue) !important;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        {{-- ══ BRANDING SECTION ══ --}}
        <div class="auth-header">
            <a href="/">
                <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="auth-logo"
                     onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg/1200px-Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg.png'">
            </a>
            <h1 class="auth-title">Kartu Kendali <span>BMN</span></h1>
            <p class="auth-subtitle">BPS Kota Bontang</p>
        </div>

        {{-- ══ AUTH CARD (LOGIN/REGISTER FORM) ══ --}}
        <div class="auth-card">
            {{ $slot }}
        </div>

        {{-- ══ FOOTER SECTION ══ --}}
        <footer class="auth-footer">
            <p>&copy; {{ date('Y') }} <b>Badan Pusat Statistik Kota Bontang</b></p>
            <p>Profesional • Integritas • Amanah</p>
            
            <div class="footer-lines">
                <span class="line-1"></span>
                <span class="line-2"></span>
                <span class="line-3"></span>
            </div>
        </footer>
    </div>

</body>
</html>