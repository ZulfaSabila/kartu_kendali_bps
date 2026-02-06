<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kartu Kendali BPS</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bps-dark-blue: #002d57;
            --bps-blue: #003366;
            --bps-light-blue: #eef4f9;
            --bps-green: #77B02A;
            --bps-accent: #00AEEF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #334155;
        }

        /* Navbar Modern */
        .navbar-bps {
            background-color: var(--bps-dark-blue);
            border-bottom: 4px solid var(--bps-green);
        }

        .logo-text {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* Card Stats */
        .stat-card {
            border: none;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        /* Category Card */
        .kategori-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .kategori-card:hover {
            border-color: var(--bps-blue);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .card-category-title {
            color: var(--bps-blue);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
            background-color: #e2e8f0;
        }

        .section-header {
            border-left: 5px solid var(--bps-green);
            padding-left: 15px;
            margin-bottom: 25px;
        }

        .btn-bps-primary {
            background-color: var(--bps-blue);
            color: white;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-bps-primary:hover {
            background-color: var(--bps-dark-blue);
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-bps py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://www.bps.go.id/_next/image?url=%2Fassets%2Flogo-bps.png&w=1080&q=75" alt="Logo" width="40" class="me-2">
                <span class="logo-text">KARTU KENDALI BPS</span>
            </a>
            
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-block">Halo, <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong></span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <div class="section-header">
                    <h2 class="fw-bold m-0">Ringkasan Anggaran 2026</h2>
                    <p class="text-muted m-0">Pemeliharaan BMN BPS Kota Bontang</p>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('kategoris.create') }}" class="btn btn-bps-primary px-4">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
                </a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <div class="stat-icon-wrapper" style="background-color: #e0f2fe;">
                        <i class="bi bi-collection text-primary fs-4"></i>
                    </div>
                    <p class="text-muted small fw-medium mb-1">TOTAL KATEGORI</p>
                    <h3 class="fw-bold">{{ $totalKategori }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <div class="stat-icon-wrapper" style="background-color: #f0fdf4;">
                        <i class="bi bi-check2-circle text-success fs-4"></i>
                    </div>
                    <p class="text-muted small fw-medium mb-1">TOTAL PEKERJAAN</p>
                    <h3 class="fw-bold">{{ $totalPemeliharaan }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <div class="stat-icon-wrapper" style="background-color: #fefce8;">
                        <i class="bi bi-cash-stack text-warning fs-4"></i>
                    </div>
                    <p class="text-muted small fw-medium mb-1">REALISASI BIAYA</p>
                    <h3 class="fw-bold text-dark">Rp{{ number_format($totalBiaya, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <div class="stat-icon-wrapper" style="background-color: {{ $sisaAnggaran >= 0 ? '#ecfeff' : '#fef2f2' }};">
                        <i class="bi bi-wallet2 {{ $sisaAnggaran >= 0 ? 'text-info' : 'text-danger' }} fs-4"></i>
                    </div>
                    <p class="text-muted small fw-medium mb-1">SISA ANGGARAN</p>
                    <h3 class="fw-bold {{ $sisaAnggaran >= 0 ? 'text-dark' : 'text-danger' }}">
                        Rp{{ number_format($sisaAnggaran, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4 mb-5 bg-white" style="border-radius: 12px;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold m-0"><i class="bi bi-bar-chart-line me-2"></i>Penyerapan Anggaran Terhadap Pagu</h6>
                @php 
                    $pagu = $totalBiaya + $sisaAnggaran;
                    $persen = $pagu > 0 ? ($totalBiaya / $pagu) * 100 : 0;
                @endphp
                <span class="badge bg-{{ $persen > 90 ? 'danger' : 'primary' }}">{{ round($persen, 1) }}% Terpakai</span>
            </div>
            <div class="progress mb-2">
                <div class="progress-bar" role="progressbar" style="width: {{ $persen }}%; background-color: var(--bps-blue);" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between">
                <small class="text-muted">Total Pagu: Rp{{ number_format($pagu, 0, ',', '.') }}</small>
                <small class="text-muted">Target: Efisiensi Anggaran</small>
            </div>
        </div>

        <h5 class="fw-bold mb-4">Daftar Inventaris BMN</h5>
        <div class="row g-4">
            @forelse($kategoris as $kategori)
            <div class="col-md-4">
                <a href="{{ route('pemeliharaans.index', ['kategori_id' => $kategori->id]) }}" class="kategori-card d-block p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="card-category-title">{{ $kategori->nama_kategori }}</div>
                        <span class="badge bg-light text-dark border">{{ $kategori->pemeliharaans_count }} Data</span>
                    </div>
                    <p class="text-muted small mb-4">
                        {{ $kategori->deskripsi ?? 'Tidak ada deskripsi kategori.' }}
                    </p>
                    <div class="d-flex align-items-center text-primary fw-semibold small">
                        Lihat Rincian Pekerjaan <i class="bi bi-arrow-right ms-2"></i>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-clipboard-x display-1 text-light"></i>
                <p class="text-muted mt-3">Belum ada data kategori pemeliharaan.</p>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="text-center py-4 text-muted small">
        &copy; 2026 BPS Kota Bontang - Aplikasi Kartu Kendali Pemeliharaan
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>