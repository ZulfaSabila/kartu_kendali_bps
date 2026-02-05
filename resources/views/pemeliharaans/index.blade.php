<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemeliharaan - BPS Kota Bontang</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .btn {
            transition: all 0.2s ease-in-out;
        }
        .btn:hover {
            transform: scale(1.03);
        }
        .search-input {
            max-width: 300px;
        }
        .table-dark {
            background-color: #003366 !important;
        }
        .info-header {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: 600;
            color: #003366;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <h1 class="h3 mb-0" style="color: #003366;">
                <i class="bi bi-clipboard-check-fill me-2"></i> Data Pemeliharaan Barang
            </h1>

            <div class="d-flex flex-wrap gap-2">

                <!-- Tambah Pemeliharaan -->
                <a href="{{ route('pemeliharaans.create') }}" class="btn shadow-sm" style="background-color: #77B02A; color: white;">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Pemeliharaan
                </a>

                <!-- Export Excel -->
                <a href="{{ route('pemeliharaans.export.excel', request()->all()) }}" class="btn shadow-sm" style="background-color: #00AEEF; color: white;">
                    <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Excel
                </a>

                <!-- Cetak PDF -->
                <a href="{{ route('pemeliharaans.export.pdf', request()->all()) }}" class="btn shadow-sm" style="background-color: #F39200; color: white;">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
                </a>

                <!-- Dropdown User -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary shadow-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name ?? 'User' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-fill"></i> Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door-fill"></i> Dashboard
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

        <!-- Alert Success -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form Search & Filter -->
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <form action="{{ route('pemeliharaans.index') }}" method="GET" class="row g-3">
                    
                    <!-- Search -->
                    <div class="col-md-11">
                        <input  
                            type="text"  
                            name="search"  
                            value="{{ request('search') }}"  
                            class="form-control"  
                            placeholder="Cari NUP BMN / Nama Barang..."
                        >
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    @if(request()->hasAny(['search', 'kategori_id', 'tanggal_mulai', 'tanggal_selesai']))
                        <div class="col-12">
                            <a href="{{ route('pemeliharaans.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-circle"></i> Reset Filter
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Tabel -->
        <div class="card shadow-sm border-0">
            <div class="card-body">

                @if($pemeliharaans->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-center text-muted my-4">Belum ada data pemeliharaan.</p>
                        <a href="{{ route('pemeliharaans.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Tambah Data Pertama
                        </a>
                    </div>
                @else

                @foreach($pemeliharaans as $index => $p)
                    <!-- Info Header untuk setiap item -->
                    <div class="info-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <span class="info-label">NUP BMN:</span>
                                    <span>{{ $p->nup_bmn ?? '-' }}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="info-label">Nama Barang:</span>
                                    <span>{{ $p->nama_barang ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <span class="info-label">Merk/Type:</span>
                                    <span>{{ $p->merk_type ?? '-' }}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="info-label">Lokasi:</span>
                                    <span>Bontang</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel detail pemeliharaan -->
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>NO</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Rincian Pekerjaan</th>
                                    <th>Biaya (Rp)</th>
                                    <th>Biaya Kumulatif (Rp)</th>
                                    <th>Pagu (Rp)</th>
                                    <th>Sisa Anggaran (Rp)</th>
                                    <th width="180">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>{{ $pemeliharaans->firstItem() + $index }}</td>
                                    <td>{{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                    <td class="text-start" style="max-width: 250px;">
                                        {{ $p->rincian_pekerjaan ?? '-' }}
                                    </td>
                                    <td class="text-end">{{ number_format($p->biaya, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($p->biaya, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($p->pagu, 0, ',', '.') }}</td>
                                    <td class="text-end">
                                        <span class="{{ $p->sisa_anggaran >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                            {{ number_format($p->sisa_anggaran, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-1">

                                            <!-- Lihat -->
                                            <a href="{{ route('pemeliharaans.show', $p->id) }}" class="btn btn-sm" style="background-color: #00AEEF; color: white;" title="Lihat Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('pemeliharaans.edit', $p->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('pemeliharaans.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $pemeliharaans->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>

                @endif

            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>