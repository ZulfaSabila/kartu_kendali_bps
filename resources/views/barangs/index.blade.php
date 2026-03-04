<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang - BPS Kota Bontang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bps-blue: #003366;
            --bps-cyan: #00AEEF;
            --bps-orange: #F39200;
            --bps-light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bps-light);
            color: #334155;
        }

        .navbar-bps {
            background-color: var(--bps-blue);
            border-bottom: 3px solid var(--bps-green);
        }

        .card-barang {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
        }

        .card-barang:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 51, 102, 0.15);
        }

        .asset-icon-box {
            width: 48px;
            height: 48px;
            background-color: #f1f5f9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--bps-blue);
        }

        .btn-bps-blue { background-color: var(--bps-blue); color: white; border-radius: 8px; }
        .btn-bps-blue:hover { background-color: #002347; color: white; }

        .search-container {
            background-color: white;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* CSS Tambahan agar tombol Edit dan Hapus simetris */
        .btn-action-square {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark navbar-bps py-3 mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-box-seam-fill me-2 text-warning"></i>
                <span>DAFTAR ASET - {{ $kategori->nama_kategori ?? 'SEMUA UNIT' }}</span>
            </a>
            
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger fw-bold"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="fw-bold m-0" style="color: var(--bps-blue);">Inventaris Barang</h4>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex gap-2 justify-content-md-end">
                    <a href="{{ route('barangs.create', ['kategori_id' => request('kategori_id')]) }}" class="btn btn-bps-blue shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Barang
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary bg-white">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="search-container mb-4">
            <form action="{{ route('barangs.index') }}" method="GET">
                @if(request('kategori_id'))
                    <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                @endif
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 border-end-0 ps-0 shadow-none" placeholder="Cari berdasarkan NUP, Nama Barang, atau Merk...">
                    
                    @if(request()->filled('search'))
                        <a href="{{ route('barangs.index', ['kategori_id' => request('kategori_id')]) }}" class="input-group-text bg-transparent text-danger" title="Bersihkan Pencarian">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    @endif
                    
                    <button type="submit" class="btn btn-bps-blue px-4">Cari Aset</button>
                </div>
                @if(request()->filled('search'))
                    <div class="mt-2 small text-muted">
                        Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                    </div>
                @endif
            </form>
        </div>

        @if($barangs->isEmpty())
            <div class="card card-barang py-5 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam opacity-25" style="font-size: 4rem; color: var(--bps-blue);"></i>
                    <h5 class="text-muted mt-3 fw-bold">Data Barang Tidak Ditemukan</h5>
                    <p class="text-muted small">Silakan tambahkan barang baru atau bersihkan filter pencarian Anda.</p>
                    @if(request()->filled('search'))
                        <a href="{{ route('barangs.index', ['kategori_id' => request('kategori_id')]) }}" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset Pencarian
                        </a>
                    @else
                        <a href="{{ route('barangs.create', ['kategori_id' => request('kategori_id')]) }}" class="btn btn-bps-blue mt-2">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Barang Pertama
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($barangs as $barang)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-barang h-100 border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="asset-icon-box me-3">
                                        <i class="bi bi-box-seam fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $barang->nama_barang }}</h6>
                                        <span class="badge bg-light text-primary border border-primary border-opacity-10 mt-1" style="font-size: 0.7rem;">
                                            NUP: {{ $barang->nup_bmn ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted"><i class="bi bi-tags me-2"></i>Merk/Type</small>
                                        <small class="fw-semibold text-dark">{{ $barang->merk_type ?? '-' }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted"><i class="bi bi-geo-alt me-2"></i>Lokasi</small>
                                        <small class="fw-semibold text-dark">{{ $barang->lokasi }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted"><i class="bi bi-clock-history me-2"></i>Intensitas</small>
                                        <span class="badge rounded-pill bg-info bg-opacity-10 text-info fw-bold">{{ $barang->jumlah_pemeliharaan }} Riwayat</span>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('pemeliharaans.index', ['barang_id' => $barang->id]) }}" class="btn btn-sm btn-bps-blue flex-fill py-2 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clipboard2-data me-2"></i> Kelola Riwayat
                                    </a>
                                    
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning btn-action-square" title="Edit Identitas">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('⚠️ Hapus barang ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action-square" title="Hapus Aset">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $barangs->appends(request()->all())->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>