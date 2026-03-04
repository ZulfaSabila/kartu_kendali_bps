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
            --bps-blue: #003366;
            --bps-dark: #002347;
            --bps-green: #77B02A;
            --bps-light: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bps-light);
            color: #334155;
        }

        /* Navbar */
        .navbar-bps {
            background-color: var(--bps-blue);
            border-bottom: 3px solid var(--bps-green);
        }

        /* Judul & Button Styling */
        .page-title {
            color: var(--bps-blue);
            font-weight: 700;
            border-left: 4px solid var(--bps-green);
            padding-left: 15px;
            margin: 0;
        }

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

        .btn-add { background-color: var(--bps-blue); color: white; border: none; }
        .btn-add:hover { background-color: var(--bps-dark); color: white; transform: translateY(-1px); }
        
        .btn-export { background-color: white; color: #334155; }
        .btn-export:hover { background-color: #f1f5f9; }

        .btn-exit { background-color: white; color: #334155; }
        .btn-exit:hover { background-color: #fff5f5; }

        /* Info Strip Aset (Pengganti Header Biru) */
        .info-strip {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 25px;
        }

        .info-item { display: flex; flex-direction: column; }
        .info-label {
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 0.95rem;
            color: var(--bps-dark);
            font-weight: 600;
        }

        /* Search Bar */
        .search-container {
            background: white;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
        }

        /* Table Styling */
        .table-bps {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .table-bps thead {
            background-color: var(--bps-blue);
            color: white;
        }

        .table-bps th {
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 12px;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.1) !important;
            text-align: center !important;
        }

        .table-bps td {
            font-size: 0.85rem;
            padding: 12px;
            vertical-align: middle;
            text-align: center !important;
            border: 1px solid var(--border-color);
        }

        .badge-budget {
            padding: 5px 10px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.75rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark navbar-bps py-2 mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                DATA PEMELIHARAAN BPS
            </a>
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->name ?? 'User' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        {{-- Header & Tombol Aksi --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-5">
                <h1 class="h4 page-title">Manajemen Pemeliharaan Barang</h1>
            </div>
            <div class="col-lg-7 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('barangs.index', ['kategori_id' => request('kategori_id')]) }}" class="btn-bps-action btn-exit shadow-sm">
                        Keluar ke Daftar Aset
                    </a>
                    <a href="{{ route('pemeliharaans.create', ['kategori_id' => request('kategori_id'), 'barang_id' => request('barang_id')]) }}" class="btn-bps-action btn-add shadow-sm">
                        Tambah Data
                    </a>
                    <a href="{{ route('pemeliharaans.export.excel', request()->all()) }}" class="btn-bps-action btn-export shadow-sm">
                        Export Excel
                    </a>
                    <a href="{{ route('pemeliharaans.export.pdf', request()->only(['kategori_id', 'barang_id'])) }}" class="btn-bps-action btn-export shadow-sm">
                        Cetak PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- Info Strip Aset (Muncul jika ada barang terpilih) --}}
        @if(isset($selectedBarang))
        <div class="info-strip shadow-sm">
            <div class="info-item">
                <span class="info-label">NUP BMN</span>
                <span class="info-value">{{ $selectedBarang->nup_bmn ?? '-' }}</span>
            </div>
            <div class="info-item border-start ps-4">
                <span class="info-label">Nama Aset</span>
                <span class="info-value">{{ $selectedBarang->nama_barang ?? '-' }}</span>
            </div>
            <div class="info-item border-start ps-4">
                <span class="info-label">Merk / Tipe</span>
                <span class="info-value">{{ $selectedBarang->merk_type ?? '-' }}</span>
            </div>
            <div class="info-item border-start ps-4">
                <span class="info-label">Lokasi Unit</span>
                <span class="info-value">{{ $selectedBarang->lokasi ?? 'Bontang' }}</span>
            </div>
        </div>
        @endif

        {{-- Search Bar Minimalis --}}
        <div class="search-container shadow-sm">
            <form action="{{ route('pemeliharaans.index') }}" method="GET">
                @if(request('kategori_id')) <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}"> @endif
                @if(request('barang_id')) <input type="hidden" name="barang_id" value="{{ request('barang_id') }}"> @endif
                
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="form-control border-0 shadow-none" 
                        placeholder="Cari NUP, Nama Barang, atau Rincian Pekerjaan...">
                    <button type="submit" class="btn btn-add px-4 fw-bold">Cari Data</button>
                </div>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="card border-0 shadow-sm overflow-hidden">
            @if($pemeliharaans->isEmpty())
                <div class="text-center py-5 bg-white">
                    <p class="text-muted m-0">Tidak ditemukan data pemeliharaan.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bps table-hover mb-0">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Waktu</th>
                                <th>Rincian Pekerjaan</th>
                                <th>Biaya (Rp)</th>
                                <th>Biaya Kumulatif</th>
                                <th>Pagu</th>
                                <th>Sisa Anggaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($pemeliharaans as $p)
                                @php $sisaAnggaran = $p->pagu - $p->biaya_kumulatif; @endphp
                                <tr>
                                    <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                                    <td>{{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center">{{ $p->rincian_pekerjaan }}</td>
                                    <td class="text-dark">Rp {{ number_format($p->biaya, 0, ',', '.') }}</td>
                                    <td class="text-dark">Rp {{ number_format($p->biaya_kumulatif, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($p->pagu, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge-budget {{ $sisaAnggaran >= 0 ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                            Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('pemeliharaans.show', $p->id) }}" class="btn btn-sm btn-outline-primary btn-action-square" title="Detail"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('pemeliharaans.edit', $p->id) }}" class="btn btn-sm btn-outline-warning btn-action-square" title="Ubah"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('pemeliharaans.destroy', $p->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-action-square" onclick="return confirm('Hapus riwayat?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p-3 bg-white border-top">
                    {{ $pemeliharaans->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>