<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kendali BMN - BPS Kota Bontang</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bps-blue: #003366;
            --bps-green: #77B02A;
            --bps-light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bps-light);
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--bps-blue) 0%, #001a33 100%);
            padding: 100px 0;
            color: white;
            border-bottom: 5px solid var(--bps-green);
        }

        .bps-logo {
            width: 120px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }

        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .btn-bps-green {
            background-color: var(--bps-green);
            color: white;
            font-weight: 600;
            padding: 12px 35px;
            border-radius: 8px;
            transition: all 0.3s;
            border: 2px solid var(--bps-green);
        }

        .btn-bps-green:hover {
            background-color: #639622;
            border-color: #639622;
            color: white;
            box-shadow: 0 4px 15px rgba(119, 176, 42, 0.4);
        }

        .btn-outline-white {
            background-color: transparent;
            color: white;
            font-weight: 600;
            padding: 12px 35px;
            border-radius: 8px;
            border: 2px solid white;
            transition: all 0.3s;
        }

        .btn-outline-white:hover {
            background-color: white;
            color: var(--bps-blue);
        }

        .footer {
            margin-top: auto;
            background: white;
            border-top: 1px solid #e2e8f0;
            padding: 25px 0;
        }
    </style>
</head>
<body>

    <header class="hero-section text-center">
        <div class="container">
            <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="bps-logo mb-4">
            <h1 class="display-5 fw-bold mb-2">KARTU KENDALI PEMELIHARAAN BMN</h1>
            <p class="lead mb-5 opacity-75">Sistem Monitoring Anggaran dan Riwayat Pemeliharaan Aset <br> Badan Pusat Statistik Kota Bontang</p>
            
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-bps-green btn-lg">
                        <i class="bi bi-speedometer2 me-2"></i>Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-bps-green btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-white btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card h-100 p-4 feature-card">
                    <div class="mb-3">
                        <i class="bi bi-shield-check fs-1 text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Manajemen Aset</h5>
                    <p class="text-muted small">Pendataan identitas barang BMN secara terstruktur berdasarkan NUP dan kategori unit milik BPS.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 feature-card">
                    <div class="mb-3">
                        <i class="bi bi-graph-up-arrow fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-bold">Monitoring Anggaran</h5>
                    <p class="text-muted small">Pantau penyerapan biaya kumulatif dan sisa pagu anggaran pemeliharaan secara real-time.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 feature-card">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                    </div>
                    <h5 class="fw-bold">Laporan Resmi</h5>
                    <p class="text-muted small">Ekspor riwayat pemeliharaan ke format PDF Kartu Kendali dan Excel sesuai standar pelaporan.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p class="text-muted small mb-0">&copy; 2026 Badan Pusat Statistik Kota Bontang. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>