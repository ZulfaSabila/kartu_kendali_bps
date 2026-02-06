<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pemeliharaan - BPS Kota Bontang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --bps-blue: #003366; --bps-orange: #F39200; --bps-light: #f8fafc; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bps-light); }
        .card-edit { border: none; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .form-section { border-left: 4px solid var(--bps-orange); padding-left: 10px; font-weight: 700; color: var(--bps-blue); margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-edit overflow-hidden">
                    <div class="card-header py-3 text-white d-flex align-items-center" style="background-color: var(--bps-blue);">
                        <i class="bi bi-pencil-square fs-4 me-2 text-warning"></i>
                        <h2 class="h5 mb-0 fw-bold">Edit Riwayat Pemeliharaan</h2>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <form action="{{ route('pemeliharaans.update', $pemeliharaan) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="form-section">Data Dasar & Lokasi</div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->id }}" {{ old('kategori_id', $pemeliharaan->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">NUP BMN</label>
                                    <input type="text" name="nup_bmn" class="form-control" value="{{ old('nup_bmn', $pemeliharaan->nup_bmn) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $pemeliharaan->nama_barang) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Merk/Type</label>
                                    <input type="text" name="merk_type" class="form-control" value="{{ old('merk_type', $pemeliharaan->merk_type) }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control bg-light" value="{{ old('lokasi', $pemeliharaan->lokasi) }}">
                                </div>
                            </div>

                            <div class="form-section">Waktu & Pekerjaan</div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $pemeliharaan->tanggal_mulai ? $pemeliharaan->tanggal_mulai->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $pemeliharaan->tanggal_selesai ? $pemeliharaan->tanggal_selesai->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Rincian Pekerjaan</label>
                                    <textarea name="rincian_pekerjaan" rows="3" class="form-control">{{ old('rincian_pekerjaan', $pemeliharaan->rincian_pekerjaan) }}</textarea>
                                </div>
                            </div>

                            <div class="form-section">Realisasi Anggaran</div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Biaya (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="biaya" id="biaya" class="form-control fw-bold text-primary" value="{{ old('biaya', $pemeliharaan->biaya) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Pagu (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="pagu" id="pagu" class="form-control fw-bold text-success" value="{{ old('pagu', $pemeliharaan->pagu) }}" required>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="alert {{ $pemeliharaan->sisa_anggaran >= 0 ? 'alert-success' : 'alert-danger' }} border-0 shadow-sm d-flex justify-content-between align-items-center">
                                        <span><strong>Status Anggaran Saat Ini:</strong></span>
                                        <h5 class="mb-0 fw-bold">Rp {{ number_format($pemeliharaan->sisa_anggaran, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5 border-top pt-3">
                                <a href="{{ route('pemeliharaans.index') }}" class="btn btn-outline-secondary px-4">Kembali</a>
                                <button type="submit" class="btn text-white px-5 fw-bold shadow-sm" style="background-color: var(--bps-orange);">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>