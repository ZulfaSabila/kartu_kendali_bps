<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - BPS Kota Bontang</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white" style="background-color: #003366;">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-pencil-square me-2"></i>Edit Kategori
                        </h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kategoris.update', $kategori) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Kategori -->
                            <div class="mb-4">
                                <label for="nama_kategori" class="form-label">
                                    Nama Kategori <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="nama_kategori" 
                                       id="nama_kategori" 
                                       class="form-control @error('nama_kategori') is-invalid @enderror" 
                                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                       required>
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" 
                                          id="deskripsi" 
                                          rows="4" 
                                          class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
                                </i> Batal
                                </a>
                                <button type="submit" class="btn text-white" style="background-color: #F39200;">
                                </i> Update Kategori
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="card shadow-sm border-0 mt-3">
                    <div class="card-body bg-light">
                        <small class="text-muted">
                            <i class="bi bi-calendar-plus"></i> 
                            <strong>Dibuat:</strong> {{ $kategori->created_at->format('d F Y') }} </small>
                            @if($kategori->updated_at != $kategori->created_at)
                                <br>
                                <i class="bi bi-pencil"></i> 
                                <strong>Terakhir diupdate:</strong> {{ $kategori->updated_at->format('d F Y, H:i') }} WIB
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>