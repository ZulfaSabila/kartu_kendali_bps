<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - BPS Kota Bontang</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bps-blue: #003366;
            --bps-green: #77B02A;
            --bps-cyan: #00AEEF;
            --bps-light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bps-light);
            color: #334155;
        }

        .header-title {
            color: var(--bps-blue);
            font-weight: 700;
        }

        .card-bps {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            background-color: #f1f5f9;
            color: #475569;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            font-weight: 700;
            border: none;
            padding: 1rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .badge-count {
            background-color: var(--bps-blue);
            color: white;
            font-size: 0.7rem;
            padding: 0.35em 0.65em;
            border-radius: 50rem;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kategori</li>
                    </ol>
                </nav>
                <h1 class="header-title h3 mb-0">Kelola Kategori Aset</h1>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 shadow-sm">
                    <i class="bi bi-house me-2"></i>Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-bps">
            <div class="card-body p-0">
                @if($kategoris->isEmpty())
                    <div class="text-center py-5">
                        <img src="https://illustrations.popsy.co/slate/empty-folder.svg" alt="Kosong" style="width: 200px;" class="mb-3">
                        <h5 class="text-secondary">Belum ada kategori yang dibuat</h5>
                        <p class="text-muted">Gunakan menu tambah untuk membuat kategori baru.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Jumlah Barang</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategoris as $index => $kategori)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $kategoris->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ route('barangs.index', ['kategori_id' => $kategori->id]) }}" class="text-decoration-none fw-semibold text-dark hover-primary">
                                            {{ $kategori->nama_kategori }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-muted small">
                                            {{ Str::limit($kategori->deskripsi ?? 'Tidak ada deskripsi', 50) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-count">
                                            {{ $kategori->barangs_count ?? $kategori->barangs->count() }} Item
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('kategoris.edit', $kategori) }}" class="btn-action bg-warning bg-opacity-10 text-warning border-0" title="Edit Kategori">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $kategori->nama_kategori }}? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action bg-danger bg-opacity-10 text-danger border-0" title="Hapus Kategori">
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

                    @if($kategoris->hasPages())
                        <div class="card-footer bg-white border-0 py-4">
                            <div class="d-flex justify-content-center">
                                {{ $kategoris->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="text-center mt-5 mb-4">
            <p class="text-muted small">© 2026 Badan Pusat Statistik Kota Bontang - Divisi Umum</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>