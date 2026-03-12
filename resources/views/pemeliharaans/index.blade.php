<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemeliharaan - BPS Kota Bontang</title>

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

        /* ── Page title ────────────────────────────────────── */
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
            border: 1px solid #cbd5e1;
        }

        .btn-add             { background-color: var(--bps-blue); color: white; border: none; }
        .btn-add:hover       { background-color: var(--bps-dark); color: white; transform: translateY(-1px); }

        .btn-export          { background-color: white; color: #334155; }
        .btn-export:hover    { background-color: #f1f5f9; }

        .btn-exit            { background-color: white; color: #334155; }
        .btn-exit:hover      { background-color: #fff5f5; }

        /* ── Asset info strip ──────────────────────────────── */
        .info-strip {
            background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
            border: 1px solid var(--border-color);
            border-left: 4px solid var(--bps-blue);
            border-radius: 10px;
            padding: 18px 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 0;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            padding: 0 28px 0 0;
        }

        .info-item + .info-item {
            padding-left: 28px;
            border-left: 1px solid var(--border-color);
        }

        .info-label {
            font-size: 0.7rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 0.92rem;
            color: var(--bps-dark);
            font-weight: 700;
            line-height: 1.3;
        }

        /* ── Table action buttons ──────────────────────────── */
        .btn-action-group {
            display: inline-flex;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        .btn-action-group a,
        .btn-action-group button {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: white;
            color: #64748b;
            font-size: 0.8rem;
            padding: 0;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
        }
        .btn-action-group a + a,
        .btn-action-group a + button { border-left: 1px solid var(--border-color); }
        .btn-act-view:hover  { background: #eff6ff !important; color: #2563eb !important; }
        .btn-act-edit:hover  { background: #fffbeb !important; color: #d97706 !important; }
        .btn-act-del:hover   { background: #fef2f2 !important; color: #dc2626 !important; }

        /* ── Search bar ────────────────────────────────────── */
        .search-container {
            background: white;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
        }

        /* ── Table ─────────────────────────────────────────── */
        .table-responsive {
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .table-bps {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table-bps thead {
            background-color: var(--bps-blue);
            color: white;
        }
        .table-bps thead th {
            background-color: var(--bps-blue) !important;
            color: white !important;
        }

        .table-bps th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 0.75rem;
            text-align: center;
            vertical-align: middle;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .table-bps td {
            font-size: 0.85rem;
            padding: 0.75rem;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        .table-bps tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* ── Budget badge ──────────────────────────────────── */
        .badge-budget {
            padding: 6px 12px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.75rem;
        }

        /* ── Responsive (mobile) ───────────────────────────── */
        @media (max-width: 768px) {
            .table-bps th,
            .table-bps td {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>

<body>

    {{-- ══════════════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════════════ --}}
    <nav class="navbar navbar-dark navbar-bps py-3 mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <img src="https://www.bps.go.id/_next/image?url=%2Fassets%2Flogo-bps.png&w=1080&q=75"
                     alt="Logo BPS" width="40" class="me-2">
                DATA PEMELIHARAAN BPS
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
            <div class="col-lg-5">
                <h1 class="h4 page-title">Manajemen Pemeliharaan Barang</h1>
            </div>
            <div class="col-lg-7 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('barangs.index', ['kategori_id' => request('kategori_id')]) }}"
                       class="btn-bps-action btn-exit shadow-sm">
                        Keluar ke Daftar Aset
                    </a>
                    <a href="{{ route('pemeliharaans.create', ['kategori_id' => request('kategori_id'), 'barang_id' => request('barang_id')]) }}"
                       class="btn-bps-action btn-add shadow-sm">
                        Tambah Data
                    </a>
                    <a href="{{ route('pemeliharaans.export.pdf', request()->only(['kategori_id', 'barang_id'])) }}"
                       class="btn-bps-action btn-export shadow-sm">
                        Cetak PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- Info Strip Aset --}}
        @if(isset($selectedBarang))
            <div class="info-strip shadow-sm">
                <div class="info-item">
                    <span class="info-label">NUP BMN</span>
                    <span class="info-value">{{ $selectedBarang->nup_bmn ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nama Aset</span>
                    <span class="info-value">{{ $selectedBarang->nama_barang ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Merk / Tipe</span>
                    <span class="info-value">{{ $selectedBarang->merk_type ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Lokasi Unit</span>
                    <span class="info-value">{{ $selectedBarang->lokasi ?? 'Bontang' }}</span>
                </div>
            </div>
        @endif

        {{-- Search Bar --}}
        {{-- Search Bar --}}
<div class="search-container mb-4">
    <form action="{{ route('pemeliharaans.index') }}" method="GET">
        {{-- Tetap simpan barang_id atau kategori_id jika sedang memfilter spesifik --}}
        @if(request('barang_id'))
            <input type="hidden" name="barang_id" value="{{ request('barang_id') }}">
        @endif

        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control border-start-0 border-end-0 ps-0 shadow-none"
                   placeholder="Cari berdasarkan uraian atau kode pemeliharaan...">

            @if(request()->filled('search'))
                <a href="{{ route('pemeliharaans.index', ['barang_id' => request('barang_id')]) }}"
                   class="input-group-text bg-transparent text-danger border-start-0 border-end-0" title="Bersihkan Pencarian">
                    <i class="bi bi-x-circle-fill"></i>
                </a>
            @endif

            <button type="submit"
                    class="btn-bps-action btn-add"
                    style="border-radius: 0 6px 6px 0; border-left: none;">
                Cari Riwayat
            </button>
        </div>

        @if(request()->filled('search'))
            <div class="mt-2 small text-muted">
                Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
            </div>
        @endif
    </form>
</div>

        {{-- Tabel Data --}}
        <div class="card border-0 shadow-sm overflow-hidden">
            @if($pemeliharaans->isEmpty())
                <div class="text-center py-5 bg-white">
                    <p class="text-muted m-0">Tidak ditemukan data pemeliharaan.</p>
                </div>
            @else
                <div class="table-responsive" style="overflow:hidden;">
                    <table class="table-bps">
                        <thead>
                            <tr>
                                <th style="width:4%">NO</th>
                                <th style="width:12%">Tanggal Pekerjaan</th>
                                <th style="width:30%;">Rincian Pekerjaan</th>
                                <th style="width:12%">Biaya (Rp)</th>
                                <th style="width:13%">Biaya Kumulatif</th>
                                <th style="width:12%">Pagu</th>
                                <th style="width:13%">Sisa Anggaran</th>
                                <th style="width:8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($pemeliharaans as $p)
                                @php $sisaAnggaran = $p->pagu - $p->biaya_kumulatif; @endphp
                                <tr>
                                    <td class="fw-bold text-muted">{{ $loop->iteration }}</td>

                                    <td class="small">
                                        <span class="d-block fw-semibold">
                                            {{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}
                                        </span>
                                        @if($p->tanggal_selesai)
                                            <span class="text-muted" style="font-size: 0.7rem;">
                                                s/d {{ $p->tanggal_selesai->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $p->rincian_pekerjaan }}</td>

                                    <td class="text-dark">Rp {{ number_format($p->biaya, 0, ',', '.') }}</td>

                                    <td class="text-dark">Rp {{ number_format($p->biaya_kumulatif, 0, ',', '.') }}</td>

                                    <td>Rp {{ number_format($p->pagu, 0, ',', '.') }}</td>

                                    <td>
                                        <span class="badge-budget {{ $sisaAnggaran >= 0 ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                            Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="btn-action-group">
                                            <a href="{{ route('pemeliharaans.show', $p->id) }}"
                                               class="btn-act-view" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('pemeliharaans.edit', $p->id) }}"
                                               class="btn-act-edit" title="Ubah">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('pemeliharaans.destroy', $p->id) }}"
                                                  method="POST" class="d-inline m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-act-del" title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus data pemeliharaan ini? Tindakan tidak dapat dibatalkan.')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center p-3 bg-white border-top">
                    {{ $pemeliharaans->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

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