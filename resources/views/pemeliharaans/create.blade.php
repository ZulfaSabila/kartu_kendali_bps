<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pemeliharaan - BPS Kota Bontang</title>

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
                            <i class="bi bi-plus-circle me-2"></i>Tambah Data Pemeliharaan
                        </h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pemeliharaans.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                
                                <!-- ========================================= -->
                                <!-- KATEGORI - INI YANG ANDA LUPA TAMBAHKAN! -->
                                <!-- ========================================= -->
                                <div class="col-md-12">
                                    <label for="kategori_id" class="form-label">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->id }}" {{ old('kategori_id', request('kategori_id')) == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- NUP BMN -->
                                <div class="col-md-6">
                                    <label for="nup_bmn" class="form-label">NUP BMN</label>
                                    <input type="text" name="nup_bmn" id="nup_bmn" 
                                           class="form-control @error('nup_bmn') is-invalid @enderror" 
                                           value="{{ old('nup_bmn') }}" 
                                           placeholder="Masukkan NUP BMN">
                                    @error('nup_bmn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nama Barang -->
                                <div class="col-md-6">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" name="nama_barang" id="nama_barang" 
                                           class="form-control @error('nama_barang') is-invalid @enderror" 
                                           value="{{ old('nama_barang') }}" 
                                           placeholder="Masukkan nama barang">
                                    @error('nama_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Merk/Type -->
                                <div class="col-md-6">
                                    <label for="merk_type" class="form-label">Merk/Type</label>
                                    <input type="text" name="merk_type" id="merk_type" 
                                           class="form-control @error('merk_type') is-invalid @enderror" 
                                           value="{{ old('merk_type') }}" 
                                           placeholder="Masukkan merk/type barang">
                                    @error('merk_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Lokasi -->
                                <div class="col-md-6">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" id="lokasi" 
                                           class="form-control @error('lokasi') is-invalid @enderror" 
                                           value="{{ old('lokasi', 'Bontang') }}" 
                                           placeholder="Masukkan lokasi">
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Mulai -->
                                <div class="col-md-6">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Pekerjaan</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                                           class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                           value="{{ old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="col-md-6">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai Pekerjaan</label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                                           class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                           value="{{ old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Rincian Pekerjaan -->
                                <div class="col-md-12">
                                    <label for="rincian_pekerjaan" class="form-label">Rincian Pekerjaan</label>
                                    <textarea name="rincian_pekerjaan" id="rincian_pekerjaan" rows="3" 
                                              class="form-control @error('rincian_pekerjaan') is-invalid @enderror" 
                                              placeholder="Masukkan rincian pekerjaan pemeliharaan">{{ old('rincian_pekerjaan') }}</textarea>
                                    @error('rincian_pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Biaya -->
                                <div class="col-md-6">
                                    <label for="biaya" class="form-label">
                                        Biaya Kumulatif (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="biaya" id="biaya" 
                                           class="form-control @error('biaya') is-invalid @enderror" 
                                           value="{{ old('biaya', 0) }}" 
                                           min="0" required
                                           placeholder="Contoh: 5000000">
                                    <small class="text-muted">Masukkan angka tanpa titik atau koma</small>
                                    @error('biaya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Pagu -->
                                <div class="col-md-6">
                                    <label for="pagu" class="form-label">
                                        Pagu (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="pagu" id="pagu" 
                                           class="form-control @error('pagu') is-invalid @enderror" 
                                           value="{{ old('pagu', 0) }}" 
                                           min="0" required
                                           placeholder="Contoh: 10000000">
                                    <small class="text-muted">Masukkan angka tanpa titik atau koma</small>
                                    @error('pagu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('pemeliharaans.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn text-white" style="background-color: #77B02A;">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-calculate sisa anggaran
        const biayaInput = document.getElementById('biaya');
        const paguInput = document.getElementById('pagu');

        function validateBudget() {
            const biaya = parseFloat(biayaInput.value) || 0;
            const pagu = parseFloat(paguInput.value) || 0;

            if (biaya > pagu && pagu > 0) {
                alert('Peringatan: Biaya melebihi pagu anggaran!');
            }
        }

        biayaInput.addEventListener('change', validateBudget);
        paguInput.addEventListener('change', validateBudget);
    </script>

</body>
</html>