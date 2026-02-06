<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pemeliharaan - BPS Kota Bontang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --bps-blue: #003366; --bps-green: #77B02A; --bps-light: #f8fafc; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bps-light); color: #334155; }
        .card-form { border: none; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        .form-section-title { border-left: 4px solid var(--bps-green); padding-left: 10px; font-weight: 700; color: var(--bps-blue); margin: 20px 0 15px 0; }
        .form-label { font-weight: 600; font-size: 0.875rem; color: #475569; }
        .btn-bps-green { background-color: var(--bps-green); color: white; border-radius: 8px; font-weight: 600; }
        .btn-bps-green:hover { background-color: #639622; color: white; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-form overflow-hidden">
                    <div class="card-header py-3 text-white d-flex align-items-center" style="background-color: var(--bps-blue);">
                        <i class="bi bi-plus-circle-fill fs-4 me-2 text-warning"></i>
                        <h2 class="h5 mb-0 fw-bold">Tambah Data Pemeliharaan Baru</h2>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <form action="{{ route('pemeliharaans.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-section-title mt-0">Identitas BMN & Lokasi</div>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori_id" id="kategori_id" class="form-select shadow-sm @error('kategori_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->id }}" {{ old('kategori_id', request('kategori_id')) == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NUP BMN</label>
                                    <input type="text" name="nup_bmn" class="form-control shadow-sm" value="{{ old('nup_bmn') }}" placeholder="Contoh: 0001">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control shadow-sm" value="{{ old('nama_barang') }}" placeholder="Masukkan nama aset">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Merk/Type</label>
                                    <input type="text" name="merk_type" class="form-control shadow-sm" value="{{ old('merk_type') }}" placeholder="Contoh: Honda Vario / Lenovo ThinkPad">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control shadow-sm" value="{{ old('lokasi', 'Bontang') }}">
                                </div>
                            </div>

                            <div class="form-section-title">Waktu & Rincian Pekerjaan</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Mulai Pekerjaan</label>
                                    <input type="date" name="tanggal_mulai" class="form-control shadow-sm" value="{{ old('tanggal_mulai') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Selesai Pekerjaan</label>
                                    <input type="date" name="tanggal_selesai" class="form-control shadow-sm" value="{{ old('tanggal_selesai') }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Rincian Pekerjaan</label>
                                    <textarea name="rincian_pekerjaan" rows="3" class="form-control shadow-sm" placeholder="Deskripsikan detail perbaikan...">{{ old('rincian_pekerjaan') }}</textarea>
                                </div>
                            </div>

                            <div class="form-section-title">Informasi Anggaran</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Biaya (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light fw-bold">Rp</span>
                                        <input type="text" name="biaya_display" id="biaya_display" class="form-control fw-bold text-primary" placeholder="0" required>
                                        <input type="hidden" name="biaya" id="biaya" value="{{ old('biaya', 0) }}">
                                    </div>
                                    <small class="text-muted">Format: 500.000</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pagu (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light fw-bold">Rp</span>
                                        <input type="text" name="pagu_display" id="pagu_display" class="form-control fw-bold text-success" placeholder="0" required>
                                        <input type="hidden" name="pagu" id="pagu" value="{{ old('pagu', 0) }}">
                                    </div>
                                    <small class="text-muted">Format: 1.000.000</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                                <a href="{{ route('pemeliharaans.index', ['kategori_id' => request('kategori_id')]) }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-bps-green px-5 shadow">
                                    <i class="bi bi-save me-2"></i>Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Format angka dengan titik pemisah ribuan
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Hapus format dan ambil angka murni
        function parseNumber(str) {
            return parseInt(str.replace(/\./g, '')) || 0;
        }

        // Biaya Input
        const biayaDisplay = document.getElementById('biaya_display');
        const biayaHidden = document.getElementById('biaya');

        biayaDisplay.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\./g, '');
            if (value && !isNaN(value)) {
                e.target.value = formatNumber(value);
                biayaHidden.value = value;
            } else {
                e.target.value = '';
                biayaHidden.value = '0';
            }
        });

        // Pagu Input
        const paguDisplay = document.getElementById('pagu_display');
        const paguHidden = document.getElementById('pagu');

        paguDisplay.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\./g, '');
            if (value && !isNaN(value)) {
                e.target.value = formatNumber(value);
                paguHidden.value = value;
            } else {
                e.target.value = '';
                paguHidden.value = '0';
            }
        });

        // Validasi budget
        function validateBudget() {
            const biaya = parseInt(biayaHidden.value) || 0;
            const pagu = parseInt(paguHidden.value) || 0;
            if (biaya > pagu && pagu > 0) {
                alert('Peringatan: Biaya melebihi pagu anggaran!');
            }
        }

        biayaDisplay.addEventListener('blur', validateBudget);
        paguDisplay.addEventListener('blur', validateBudget);
    </script>
</body>
</html>