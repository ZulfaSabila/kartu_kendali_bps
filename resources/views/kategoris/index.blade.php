<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - BPS Kota Bontang</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-dark {
            background-color: #003366 !important;
        }
        .btn {
            transition: all 0.2s ease-in-out;
        }
        .btn:hover {
            transform: scale(1.03);
        }
    </style>
</head>

<body>
    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #003366;">
                    <i class="bi bi-folder-fill me-2"></i> Kelola Kategori Pemeliharaan
                </h1>
                <p class="text-muted mb-0">Daftar kategori barang yang dapat dipelihara</p>
            </div>

            <!-- Kembali ke Dashboard -->
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabel -->
        <div class="card shadow-sm border-0">
            <div class="card-body">

                @if($kategoris->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-folder-x" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-center text-muted my-4">Belum ada kategori.</p>
                    </div>
                @else

                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Nama Kategori</th>
                                <th width="40%">Deskripsi</th>
                                <th width="10%">Jumlah Data</th>
                                <th width="12%">Tanggal Dibuat</th>
                                <th width="8%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($kategoris as $index => $kategori)
                            <tr>
                                <td>{{ $kategoris->firstItem() + $index }}</td>
                                
                                <td class="text-start">
                                    <i class="bi bi-folder-fill me-2" style="color: #77B02A;"></i>
                                    <strong>{{ $kategori->nama_kategori }}</strong>
                                </td>
                                
                                <td class="text-start">
                                    <small class="text-muted">{{ $kategori->deskripsi ?? '-' }}</small>
                                </td>
                                
                                <td>
                                    <span class="badge" style="background-color: #00AEEF;">
                                        {{ $kategori->pemeliharaans_count }} Data
                                    </span>
                                </td>
                                
                                <td>
                                    <small>{{ $kategori->created_at->format('d/m/Y') }}</small>
                                </td>
                                
                                <td>
                                    <div class="d-flex justify-content-center gap-1">

                                        <!-- Edit -->
                                        <a href="{{ route('kategoris.edit', $kategori->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Hapus -->
                                        <form action="{{ route('kategoris.destroy', $kategori->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori {{ $kategori->nama_kategori }}? Semua data pemeliharaan dalam kategori ini akan ikut terhapus!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
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

                <!-- Pagination -->
                @if($kategoris->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $kategoris->links('pagination::bootstrap-5') }}
                    </div>
                @endif

                @endif

            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>