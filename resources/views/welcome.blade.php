<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kendali BMN — BPS Kota Bontang</title>

    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bps.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg-primary: #0A0F1E;
            --bg-secondary: #0F1729;
            --bg-card: rgba(255, 255, 255, 0.04);
            --border-card: rgba(255, 255, 255, 0.08);
            --accent-orange: #F97316;
            --accent-blue: #3B82F6;
            --text-primary: #F1F5F9;
            --text-muted: #64748B;
            --transition: all 0.25s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.7;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .brand-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ── NAVBAR ── */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(10, 15, 30, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-card);
            transition: var(--transition);
        }

        nav.scrolled {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            padding: 0.75rem 0;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand img { height: 42px; width: auto; filter: brightness(1.1); }

        .brand-text { display: flex; flex-direction: column; }

        .brand-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.25rem;
            line-height: 1.1;
        }

        .brand-tagline {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* ── HERO SECTION ── */
        .hero-wrapper {
            position: relative;
            background-color: var(--bg-primary);
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(59, 130, 246, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 100% 100%, rgba(249, 115, 22, 0.05) 0%, transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
        }

        .hero-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(var(--border-card) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.04;
            pointer-events: none;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 64px;
            width: 100%;
        }

        .hero-content {
            animation: fadeInUp 0.6s ease forwards;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(34, 197, 94, 0.08);
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #22C55E;
            margin-bottom: 2rem;
            border: 1px solid rgba(34, 197, 94, 0.3);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .dot-pulse {
            width: 8px;
            height: 8px;
            background: #22C55E;
            border-radius: 50%;
            position: relative;
        }

        .dot-pulse::after {
            content: '';
            position: absolute;
            inset: 0;
            background: #22C55E;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .hero h1 span {
            color: var(--accent-orange);
            text-shadow: 0 0 30px rgba(249, 115, 22, 0.2);
        }

        .hero p {
            font-size: 1.05rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            max-width: 480px;
        }

        /* ── FEATURE CARDS ── */
        .feature-grid {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .feature-card {
            background: var(--bg-card);
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--border-card);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .feature-card:nth-child(1) { animation-delay: 0.1s; }
        .feature-card:nth-child(2) { animation-delay: 0.2s; }
        .feature-card:nth-child(3) { animation-delay: 0.3s; }

        .feature-card:hover {
            border-color: rgba(249, 115, 22, 0.4);
            background: rgba(249, 115, 22, 0.04);
            transform: translateY(-2px);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            color: var(--text-primary);
        }

        .feature-info h4 {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .feature-info p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 0;
        }

        /* ── BUTTONS ── */
        .btn-group { display: flex; gap: 1rem; flex-wrap: wrap; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            font-size: 1rem;
            cursor: pointer;
        }

        .btn:active { transform: scale(0.98); }

        .btn-primary {
            background: var(--accent-orange);
            color: white;
            box-shadow: 0 4px 20px rgba(249, 115, 22, 0.3);
        }

        .btn-primary:hover {
            filter: brightness(1.1);
            box-shadow: 0 6px 25px rgba(249, 115, 22, 0.45);
        }

        .btn-secondary {
            background: transparent;
            color: #CBD5E1;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            border-color: var(--accent-orange);
            color: var(--accent-orange);
        }

        /* ── FOOTER ── */
        footer {
            padding: 24px 0;
            background: var(--bg-primary);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-copy {
            color: #475569;
            font-size: 0.85rem;
        }

        .footer-accents { display: flex; gap: 8px; }
        .footer-accents span {
            width: 24px;
            height: 3px;
            border-radius: 2px;
        }
        .acc-1 { background: var(--accent-blue); }
        .acc-2 { background: var(--accent-orange); }
        .acc-3 { background: #22C55E; }

        /* ── ANIMATIONS ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            70% { transform: scale(2.5); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 992px) {
            .hero-grid { gap: 40px; }
        }

        @media (max-width: 768px) {
            .hero-wrapper { min-height: auto; padding: 120px 0 64px; }
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero p { margin: 0 auto 2.5rem; }
            .btn-group { justify-content: center; }
            .feature-grid { margin-top: 48px; text-align: left; }
        }

        @media (max-width: 480px) {
            .brand-tagline { display: none; }
            .hero h1 { font-size: 2.5rem; }
            .btn { width: 100%; justify-content: center; }
            footer .container {
                flex-direction: column;
                gap: 16px;
            }
        }
    </style>
</head>
<body>

    {{-- ══ NAVBAR ══ --}}
    <nav id="navbar">
        <div class="container">
            <a href="/" class="brand">
                <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" 
                     onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg/1200px-Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg.png'">
                <div class="brand-text">
                    <span class="brand-title">Kartu Kendali BMN</span>
                    <span class="brand-tagline">Badan Pusat Statistik Kota Bontang</span>
                </div>
            </a>
        </div>
    </nav>

    {{-- ══ MAIN HERO ══ --}}
    <main>
        <div class="hero-wrapper">
            <div class="container hero">
                <div class="hero-grid">
                    <div class="hero-content">
                        <div class="badge-pill">
                            <div class="dot-pulse"></div>
                            Sistem Aktif • TA {{ date('Y') }}
                        </div>
                        
                        <h1>Kartu Kendali <span>Pemeliharaan</span> BMN</h1>
                        
                        <p>
                            Aplikasi monitoring anggaran dan riwayat pemeliharaan Barang Milik Negara (BMN) di lingkungan Badan Pusat Statistik Kota Bontang.
                        </p>

                        <div class="btn-group">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                    <i class="bi bi-speedometer2"></i> Menuju Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right"></i> Masuk Sistem
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-secondary">
                                        <i class="bi bi-person-plus"></i> Daftar Akun
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="feature-grid">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi bi-layers"></i></div>
                            <div class="feature-info">
                                <h4>Manajemen Aset BMN</h4>
                                <p>Pengelolaan data aset kendaraan dinas.</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi bi-graph-up"></i></div>
                            <div class="feature-info">
                                <h4>Monitoring Anggaran</h4>
                                <p>Pantau sisa pagu anggaran secara real-time.</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi bi-file-earmark-check"></i></div>
                            <div class="feature-info">
                                <h4>Ekspor PDF & Excel</h4>
                                <p>Laporan kartu kendali siap cetak otomatis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- ══ FOOTER ══ --}}
    <footer>
        <div class="container">
            <div class="footer-copy">
                &copy; {{ date('Y') }} Badan Pusat Statistik Kota Bontang
            </div>
            <div class="footer-accents">
                <span class="acc-1"></span>
                <span class="acc-2"></span>
                <span class="acc-3"></span>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
 
 </body>
 </html>