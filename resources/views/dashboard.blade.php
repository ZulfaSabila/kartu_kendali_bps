<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kartu Kendali Pemeliharaan BPS</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bps-blue: #003366;
            --bps-green: #77B02A;
            --bps-orange: #F39200;
            --bps-cyan: #00AEEF;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar-bps {
            background: linear-gradient(135deg, var(--bps-blue) 0%, #004080 100%);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .logo-bps {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .logo-bps i {
            color: var(--bps-green);
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .stat-card .card-body {
            padding: 1.5rem;
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .kategori-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: white;
            cursor: pointer;
            height: 100%;
            text-decoration: none;
            color: inherit;
            display: block;
            overflow: hidden;
        }

        .kategori-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }

        .kategori-card .card-header {
            border: none;
            padding: 1.5rem;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .kategori-card .card-body {
            padding: 1.5rem;
        }

        .badge-count {
            font-size: 2rem;
            font-weight: bold;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .btn-bps {
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-bps:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--bps-blue);
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--bps-green);
        }

        .kategori-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .info-text {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-bps navbar-dark mb-4">
        <div class="container">
            <a href="{{ route('dashboard') }}" class="logo-bps">
                <i class="bi bi-building"></i> BPS Kota Bontang
            </a>
            
            <div class="d-flex gap-2">
                <a href="{{ route('kategoris.create') }}" class="btn btn-light btn-bps">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
                </a>

                <div class="dropdown">
                    <button class="btn btn-outline-light btn-bps dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name ?? 'User' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-fill"></i> Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <!-- Statistics Cards -->
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-folder-fill stat-icon" style="color: var(--bps-blue);"></i>
                        <div class="text-muted small fw-bold text-uppercase mt-2">Total Kategori</div>
                        <div class="h2 fw-bold mb-0" style="color: var(--bps-blue);">{{ $totalKategori }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-tools stat-icon" style="color: var(--bps-green);"></i>
                        <div class="text-muted small fw-bold text-uppercase mt-2">Total Pemeliharaan</div>
                        <div class="h2 fw-bold mb-0" style="color: var(--bps-green);">{{ $totalPemeliharaan }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 stat-icon" style="color: var(--bps-orange);"></i>
                        <div class="text-muted small fw-bold text-uppercase mt-2">Total Biaya</div>
                        <div class="h5 fw-bold mb-0" style="color: var(--bps-orange);">
                            Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-piggy-bank stat-icon" style="color: {{ $sisaAnggaran >= 0 ? 'var(--bps-cyan)' : '#dc3545' }};"></i>
                        <div class="text-muted small fw-bold text-uppercase mt-2">Sisa Anggaran</div>
                        <div class="h5 fw-bold mb-0" style="color: {{ $sisaAnggaran >= 0 ? 'var(--bps-cyan)' : '#dc3545' }};">
                            Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Section -->
        <div class="section-title">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i> Kategori Pemeliharaan
        </div>

        @if($kategoris->isEmpty())
            <div class="card shadow-sm border-0 empty-state">
                <div class="card-body">
                    <i class="bi bi-inbox"></i>
                    <h4 class="text-muted mb-3">Belum Ada Kategori</h4>
                    <p class="text-muted mb-4">Mulai dengan menambahkan kategori pemeliharaan pertama Anda</p>
                    <a href="{{ route('kategoris.create') }}" class="btn btn-bps" style="background-color: var(--bps-green); color: white;">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori Pertama
                    </a>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($kategoris as $kategori)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('pemeliharaans.index', ['kategori_id' => $kategori->id]) }}" class="kategori-card shadow-sm">
                            <div class="card-header text-white text-center" style="background: linear-gradient(135deg, {{ $loop->iteration % 4 == 1 ? 'var(--bps-blue)' : ($loop->iteration % 4 == 2 ? 'var(--bps-green)' : ($loop->iteration % 4 == 3 ? 'var(--bps-orange)' : 'var(--bps-cyan)')) }} 0%, {{ $loop->iteration % 4 == 1 ? '#004080' : ($loop->iteration % 4 == 2 ? '#88c03a' : ($loop->iteration % 4 == 3 ? '#ffa500' : '#00c8ff')) }} 100%);">
                                <i class="bi bi-folder2-open kategori-icon"></i>
                                <div>{{ $kategori->nama_kategori }}</div>
                            </div>
                            <div class="card-body text-center">
                                <div class="badge-count" style="color: {{ $loop->iteration % 4 == 1 ? 'var(--bps-blue)' : ($loop->iteration % 4 == 2 ? 'var(--bps-green)' : ($loop->iteration % 4 == 3 ? 'var(--bps-orange)' : 'var(--bps-cyan)')) }};">
                                    {{ $kategori->pemeliharaans_count }}
                                </div>
                                <div class="info-text">Data Pemeliharaan</div>
                                
                                @if($kategori->deskripsi)
                                    <hr>
                                    <p class="text-muted small mb-0" style="font-size: 0.85rem;">
                                        {{ Str::limit($kategori->deskripsi, 60) }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Link ke halaman kategori lengkap -->
            <div class="text-center mt-4">
                <a href="{{ route('kategoris.index') }}" class="btn btn-outline-secondary btn-bps">
                    <i class="bi bi-list-ul me-1"></i> Lihat Semua Kategori
                </a>
            </div>
        @endif

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>