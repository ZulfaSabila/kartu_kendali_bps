<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kendali BMN — BPS Kota Bontang</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ── VARIABEL WARNA RESMI BPS ── */
        :root {
            --bps-blue: #003366;
            --bps-blue-dark: #002244;
            --bps-orange: #E8751A;
            --bps-green: #77B02A;
            --white: #ffffff;
            --gray-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ── RESET & BASE ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--white);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ── NAVBAR ── */
        nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--white);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        nav::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--bps-blue) 33%, var(--bps-orange) 33%, var(--bps-orange) 66%, var(--bps-green) 66%);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }

        .brand img { height: 50px; width: auto; }

        .brand-text { display: flex; flex-direction: column; }

        .brand-title {
            color: var(--bps-blue);
            font-weight: 800;
            font-size: 1.2rem;
            line-height: 1.1;
        }

        .brand-tagline {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 2px;
        }

        /* ── HERO SECTION ── */
        .hero {
            background-color: var(--bps-blue);
            background-image: radial-gradient(circle at 80% 20%, rgba(232, 117, 26, 0.15) 0%, transparent 40%),
                              radial-gradient(circle at 10% 80%, rgba(119, 176, 42, 0.1) 0%, transparent 30%);
            min-height: 85vh;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
            padding: 2rem 8%;
            gap: 4rem;
            color: var(--white);
        }

        .hero-content { z-index: 5; }

        .badge-year {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .badge-year i { color: var(--bps-green); }

        .hero h1 {
            font-size: clamp(2.5rem, 4vw, 3.8rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .hero h1 span { color: var(--bps-orange); }

        .hero p {
            font-size: 1.15rem;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 3rem;
            max-width: 550px;
        }

        /* ── INFO BOX (Kanan Hero) ── */
        .info-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-box {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: var(--transition);
        }

        .info-box:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(10px);
        }

        .info-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .ic-1 { background: rgba(255, 255, 255, 0.1); color: var(--white); }
        .ic-2 { background: rgba(232, 117, 26, 0.2); color: var(--bps-orange); }
        .ic-3 { background: rgba(119, 176, 42, 0.2); color: var(--bps-green); }

        .info-text h4 { font-weight: 700; font-size: 1.1rem; margin-bottom: 2px; }
        .info-text p { font-size: 0.85rem; margin-bottom: 0; color: rgba(255, 255, 255, 0.6); }

        /* ── BUTTONS ── */
        .btn-group { display: flex; gap: 1.2rem; flex-wrap: wrap; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--bps-orange);
            color: var(--white);
            box-shadow: 0 8px 20px rgba(232, 117, 26, 0.25);
        }

        .btn-primary:hover {
            background: #ff8a30;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(232, 117, 26, 0.4);
        }

        .btn-ghost {
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--white);
        }

        /* ── FOOTER ── */
        footer {
            padding: 2.5rem 8%;
            background: var(--white);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eef2f6;
        }

        .footer-copy {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .footer-accents { display: flex; gap: 6px; }
        .footer-accents span {
            width: 30px;
            height: 4px;
            border-radius: 2px;
        }
        .acc-1 { background: var(--bps-blue); }
        .acc-2 { background: var(--bps-orange); }
        .acc-3 { background: var(--bps-green); }

        /* ── RESPONSIVE ── */
        @media (max-width: 860px) {
            .hero {
                grid-template-columns: 1fr;
                padding-top: 6rem;
                padding-bottom: 6rem;
                text-align: center;
            }
            .hero p { margin-left: auto; margin-right: auto; }
            .btn-group { justify-content: center; }
            .info-container { margin-top: 2rem; }
            .info-box:hover { transform: translateY(-5px); }
        }

        @media (max-width: 480px) {
            .brand-tagline { display: none; }
            .hero h1 { font-size: 2.2rem; }
            .btn { width: 100%; justify-content: center; }
            footer {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    {{-- ══ NAVBAR ══ --}}
    <nav>
        <a href="/" class="brand">
            <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" 
                 onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg/1200px-Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg.png'">
            <div class="brand-text">
                <span class="brand-title">BPS KOTA BONTANG</span>
                <span class="brand-tagline">Profesional • Integritas • Amanah</span>
            </div>
        </a>
    </nav>

    {{-- ══ MAIN HERO ══ --}}
    <main>
        <div class="hero">
            <div class="hero-content">
                <div class="badge-year">
                    <i class="bi bi-patch-check-fill"></i> Sistem Aktif • Tahun Anggaran {{ date('Y') }}
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
                            <a href="{{ route('register') }}" class="btn btn-ghost">
                                <i class="bi bi-person-plus"></i> Daftar Akun
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="info-container">
                <div class="info-box">
                    <div class="info-icon ic-1"><i class="bi bi-layers"></i></div>
                    <div class="info-text">
                        <h4>Manajemen Aset BMN</h4>
                        <p>Pengelolaan data aset kendaraan dinas.</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon ic-2"><i class="bi bi-graph-up"></i></div>
                    <div class="info-text">
                        <h4>Monitoring Anggaran</h4>
                        <p>Pantau sisa pagu anggaran secara real-time.</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon ic-3"><i class="bi bi-file-earmark-check"></i></div>
                    <div class="info-text">
                        <h4>Ekspor PDF & Excel</h4>
                        <p>Laporan kartu kendali siap cetak otomatis.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- ══ FOOTER ══ --}}
    <footer>
        <div class="footer-copy">
            &copy; {{ date('Y') }} Badan Pusat Statistik Kota Bontang
        </div>
        <div class="footer-accents">
            <span class="acc-1"></span>
            <span class="acc-2"></span>
            <span class="acc-3"></span>
        </div>
    </footer>

</body>
</html>