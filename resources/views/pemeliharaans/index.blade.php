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

        .card-main {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }

        .info-header {
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
            border-left: 5px solid var(--bps-blue);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .info-label {
            font-weight: 700;
            color: var(--bps-blue);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .info-value {
            font-size: 0.95rem;
            color: #334155;
            font-weight: 500;
        }

        .table-bps thead {
            background-color: var(--bps-blue) !important;
            color: white;
        }

        .table-bps th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem;
            vertical-align: middle;
        }

        .table-bps td {
            font-size: 0.875rem;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .btn-bps-green { background-color: var(--bps-green); color: white; }
        .btn-bps-green:hover { background-color: #639622; color: white; transform: translateY(-2px); }
        
        .btn-bps-cyan { background-color: var(--bps-cyan); color: white; }
        .btn-bps-cyan:hover { background-color: #0096ce; color: white; transform: translateY(-2px); }

        .btn-bps-orange { background-color: var(--bps-orange); color: white; }
        .btn-bps-orange:hover { background-color: #d68100; color: white; transform: translateY(-2px); }

        .btn { transition: all 0.2s; border-radius: 8px; }

        .item-group {
            margin-bottom: 2.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark navbar-bps py-3 mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-clipboard-check-fill me-2 text-warning"></i>
                <span>DATA PEMELIHARAAN BPS</span>
            </a>
            
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name ?? 'User' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-fill me-2 text-muted"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill me-2 text-muted"></i>Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row align-items-center mb-4 g-3">
            <div class="col-lg-6">
                <h1 class="h4 fw-bold m-0" style="color: var(--bps-blue);">Manajemen Pemeliharaan Barang</h1>
                <p class="text-muted small mb-0">Kelola riwayat perbaikan dan monitoring anggaran BMN secara terpusat.</p>
            </div>
            <div class="col-lg-6 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('pemeliharaans.create', ['kategori_id' => request('kategori_id')]) }}" class="btn btn-success btn-sm shadow-sm px-3" style="background-color: var(--bps-green);">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Data
                    </a>
                    <a href="{{ route('pemeliharaans.export.excel', request()->all()) }}" class="btn btn-info btn-sm shadow-sm px-3 text-white" style="background-color: var(--bps-cyan);">
                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Excel
                    </a>
                    <a href="{{ route('pemeliharaans.export.pdf', ['kategori_id' => request('kategori_id')]) }}" class="btn btn-warning btn-sm shadow-sm px-3 text-white" style="background-color: var(--bps-orange);">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Cetak PDF
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

        <div class="card card-main p-3 mb-4 border-0">
            <form action="{{ route('pemeliharaans.index') }}" method="GET">
                @if(request('kategori_id'))
                    <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                @endif
                <div class="row g-2">
                    <div class="col-md-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 shadow-none" placeholder="Cari NUP BMN atau Nama Barang...">
                            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                        </div>
                    </div>
                    @if(request()->hasAny(['search']))
                    <div class="col-12 mt-2">
                        <a href="{{ route('pemeliharaans.index', ['kategori_id' => request('kategori_id')]) }}" class="text-decoration-none text-danger fw-bold" style="font-size: 0.85rem;">
                            <i class="bi bi-x-circle me-1"></i>Reset Pencarian
                        </a>
                    </div>
                    @endif
                </div>
            </form>
        </div>

        <div class="card card-main p-4 border-0">
            @if($pemeliharaans->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-2 text-muted"></i>
                    <p class="text-muted mt-3">Tidak ditemukan data pemeliharaan dalam sistem.</p>
                </div>
            @else
                @php
                    $groupedData = $pemeliharaans->groupBy('nup_bmn');
                @endphp

                @foreach($groupedData as $nupBmn => $items)
                    @php
                        $firstItem = $items->first();
                        $biayaKumulatif = 0;
                    @endphp

                    <div class="item-group">
                        <div class="info-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-label">NUP BMN</div>
                                    <div class="info-value">{{ $firstItem->nup_bmn ?? '-' }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-label">NAMA BARANG</div>
                                    <div class="info-value">{{ $firstItem->nama_barang ?? '-' }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-label">MERK/TYPE</div>
                                    <div class="info-value">{{ $firstItem->merk_type ?? '-' }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-label">LOKASI</div>
                                    <div class="info-value">
                                        <i class="bi bi-geo-alt-fill text-success"></i> {{ $firstItem->lokasi ?? 'Bontang' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <table class="table table-bps table-bordered align-middle text-center mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">NO</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Rincian Pekerjaan</th>
                                        <th>Biaya (Rp)</th>
                                        <th>Biaya Kumulatif (Rp)</th>
                                        <th>Pagu (Rp)</th>
                                        <th>Sisa Anggaran (Rp)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($items as $index => $p)
                                        @php
                                            $biayaKumulatif += $p->biaya;
                                            $sisaAnggaran = $p->pagu - $biayaKumulatif;
                                        @endphp
                                        <tr>
                                            <td class="fw-bold text-muted">{{ $index + 1 }}</td>
                                            <td class="small">{{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                                            <td class="small">{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                            <td class="text-start">{{ $p->rincian_pekerjaan ?? '-' }}</td>
                                            <td class="text-end fw-semibold">Rp {{ number_format($p->biaya, 0, ',', '.') }}</td>
                                            <td class="text-end fw-semibold text-muted">Rp {{ number_format($biayaKumulatif, 0, ',', '.') }}</td>
                                            <td class="text-end fw-semibold">Rp {{ number_format($p->pagu, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                <span class="badge {{ $sisaAnggaran >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                    Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('pemeliharaans.show', $p->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                    <a href="{{ route('pemeliharaans.edit', $p->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                                    <form action="{{ route('pemeliharaans.destroy', $p->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{ $pemeliharaans->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>