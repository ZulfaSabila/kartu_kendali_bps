<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang - BPS Kota Bontang</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bps-blue:    #003366;
            --bps-dark:    #002347;
            --bps-green:   #77B02A;
            --bps-light:   #f8fafc;
            --border-color:#e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bps-light);
            color: #334155;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        body > .container { flex: 1; }
        footer { border-top: 1px solid var(--border-color); }

        /* ── Navbar ────────────────────────────────────────── */
        .navbar-bps {
            background-color: var(--bps-blue);
            border-bottom: 3px solid var(--bps-green);
        }

        /* ── Page title ─────────────────────────────────────── */
        .page-title {
            color: var(--bps-blue);
            font-weight: 700;
            border-left: 4px solid var(--bps-green);
            padding-left: 15px;
            margin: 0;
        }

        /* ── Action buttons ────────────────────────────────── */
        .btn-bps-action {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: 1px solid #cbd5e1;
        }

        .btn-add          { background-color: var(--bps-blue); color: white; border: none; }
        .btn-add:hover    { background-color: var(--bps-dark); color: white; transform: translateY(-1px); }

        /* ── Search bar ────────────────────────────────────── */
        .search-container {
            background: white;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
        }

        .form-control:focus {
            border-color: var(--bps-blue);
            box-shadow: none;
        }

        /* ── Barang Cards ──────────────────────────────────── */
        .barang-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.25s ease;
        }
        .barang-card:hover {
            box-shadow: 0 6px 16px rgba(0,51,102,0.12);
            transform: translateY(-2px);
        }

        .barang-icon {
            width: 44px; height: 44px;
            background-color: #eef2ff;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--bps-blue);
            flex-shrink: 0;
        }

        .nup-badge {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--bps-blue);
            background: #e0eaff;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .info-row {
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #475569;
        }
        .info-row .label {
            color: #94a3b8;
            min-width: 80px;
        }
        .info-row .value {
            font-weight: 600;
            color: #1e293b;
        }

        .intensitas-badge {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--bps-blue);
            text-decoration: none;
        }
        .intensitas-badge:hover { text-decoration: underline; }

        /* ── Card footer ───────────────────────────────────── */
        .card-footer-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
        }

        /* Kelola Riwayat — tumbuh mengisi sisa ruang */
        .btn-kelola {
            flex: 1;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            background-color: var(--bps-blue);
            color: white;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: background 0.2s;
            white-space: nowrap;
        }
        .btn-kelola:hover { background-color: var(--bps-dark); color: white; }

        /* 3-dot — ukuran tetap, langsung di samping tombol */
        .btn-dots {
            width: 32px; height: 32px;
            flex-shrink: 0;
            border-radius: 6px;
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: center;
            padding: 0;
            color: #64748b;
            transition: background 0.15s;
        }
        .btn-dots:hover { background: #e2e8f0; }

        .dropdown-menu { font-size: 0.85rem; }
    </style>
</head>

<body>

    {{-- ══════════════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════════════ --}}
    <nav class="navbar navbar-dark navbar-bps py-3 mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="https://www.bps.go.id/_next/image?url=%2Fassets%2Flogo-bps.png&w=1080&q=75"
                     alt="Logo BPS" width="40" class="me-2">
                DAFTAR ASET - SEMUA UNIT
            </a>

            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle border-0"
                            type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name ?? 'User' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-fill me-2 text-muted"></i>Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door-fill me-2 text-muted"></i>Dashboard
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════ --}}
    <div class="container pb-5">

        {{-- Header & Tombol Aksi --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-6">
                <h1 class="h4 page-title">Inventaris Barang</h1>
            </div>
            <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('barangs.create', ['kategori_id' => request('kategori_id')]) }}"
                   class="btn-bps-action btn-add shadow-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Barang
                </a>
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="search-container mb-4">
            <form action="{{ route('barangs.index') }}" method="GET">
                @if(request('kategori_id'))
                    <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                @endif

                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control border-start-0 border-end-0 ps-0 shadow-none"
                           placeholder="Cari berdasarkan NUP, Nama Barang, atau Merk...">

                    @if(request()->filled('search'))
                        <a href="{{ route('barangs.index', ['kategori_id' => request('kategori_id')]) }}"
                           class="input-group-text bg-transparent text-danger border-start-0 border-end-0"
                           title="Bersihkan Pencarian" style="text-decoration:none;">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    @endif

                    <button type="submit"
                            class="btn-bps-action btn-add"
                            style="border-radius: 0 6px 6px 0; border-left: none;">
                        Cari Aset
                    </button>
                </div>

                @if(request()->filled('search'))
                    <div class="mt-2 small text-muted">
                        Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                    </div>
                @endif
            </form>
        </div>

        {{-- Barang Cards --}}
        <div class="row g-3">
            @forelse($barangs as $barang)
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="barang-card p-4">

                    {{-- Header: ikon + nama + nup --}}
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="barang-icon">
                            <i class="bi bi-box-seam fs-5"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1 text-dark" style="font-size:0.95rem;line-height:1.3;">
                                {{ $barang->nama_barang }}
                            </h6>
                            <span class="nup-badge">NUP: {{ $barang->nup_bmn ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Info rows --}}
                    <div class="d-flex flex-column gap-1 mb-3">
                        <div class="info-row">
                            <i class="bi bi-tag" style="font-size:0.8rem;color:#94a3b8;"></i>
                            <span class="label">Merk/Type</span>
                            <span class="value">{{ $barang->merk_type ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <i class="bi bi-geo-alt" style="font-size:0.8rem;color:#94a3b8;"></i>
                            <span class="label">Lokasi</span>
                            <span class="value">{{ $barang->lokasi ?? 'Bontang' }}</span>
                        </div>
                        <div class="info-row">
                            <i class="bi bi-clock-history" style="font-size:0.8rem;color:#94a3b8;"></i>
                            <span class="label">Intensitas</span>
                            <a href="{{ route('pemeliharaans.index', ['barang_id' => $barang->id, 'kategori_id' => request('kategori_id')]) }}"
                               class="intensitas-badge">
                                {{ $barang->pemeliharaans_count ?? 0 }} Riwayat
                            </a>
                        </div>
                    </div>

                    {{-- Footer: Kelola Riwayat + 3-dot menu (rapat, sejajar) --}}
                    <div class="card-footer-actions">
                        <a href="{{ route('pemeliharaans.index', ['barang_id' => $barang->id, 'kategori_id' => request('kategori_id')]) }}"
                           class="btn-kelola">
                            <i class="bi bi-clipboard2-data"></i> Kelola Riwayat
                        </a>

                        <div class="dropdown">
                            <button class="btn-dots" data-bs-toggle="dropdown" aria-expanded="false"
                                    title="Opsi lainnya">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <a class="dropdown-item py-2"
                                       href="{{ route('barangs.edit', $barang->id) }}">
                                        <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item py-2 text-danger"
                                                onclick="return confirm('Yakin ingin menghapus barang ini? Semua data pemeliharaan terkait juga akan terhapus.')">
                                            <i class="bi bi-trash me-2"></i> Hapus
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm py-5">
                    <div class="card-body text-center">
                        <i class="bi bi-inbox opacity-25" style="font-size:4rem;color:var(--bps-blue);"></i>
                        <h5 class="text-muted mt-3 fw-bold">Barang Tidak Ditemukan</h5>
                        <p class="text-muted small">Coba kata kunci lain atau tambahkan barang baru.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($barangs->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $barangs->appends(request()->all())->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>{{-- /container --}}

    <footer class="bg-white py-4 mt-5">
        <div class="container text-center">
            <p class="text-muted small mb-0">
                &copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bontang</strong>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>