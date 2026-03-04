<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemeliharaan - BPS Kota Bontang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bps-blue: #003366; --bps-green: #77B02A; --bps-light: #f8fafc; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bps-light); color: #334155; }
        .card-bps { border: none; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); overflow: hidden; }
        .card-header-bps { background-color: var(--bps-blue); border-bottom: 3px solid var(--bps-green); padding: 1.5rem; color: white; }
        .form-section-title { font-weight: 700; color: var(--bps-blue); text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em; margin-bottom: 1.5rem; border-left: 4px solid var(--bps-green); padding-left: 10px; }
        .form-label { font-weight: 600; color: #475569; font-size: 0.85rem; }
        .form-control { padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid #e2e8f0; }
        .btn-bps-blue { background-color: var(--bps-blue); color: white; font-weight: 600; border-radius: 8px; padding: 0.6rem 2rem; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-bps">
                    <div class="card-header-bps">
                        <h5 class="mb-0 fw-bold">Edit Data Pemeliharaan</h5>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <form action="{{ route('pemeliharaans.update', $pemeliharaan->id) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="form-section-title">Waktu & Pekerjaan</div>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" 
                                        value="{{ $pemeliharaan->tanggal_mulai ? $pemeliharaan->tanggal_mulai->format('Y-m-d') : '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control" 
                                        value="{{ $pemeliharaan->tanggal_selesai ? $pemeliharaan->tanggal_selesai->format('Y-m-d') : '' }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Rincian Pekerjaan</label>
                                    <textarea name="rincian_pekerjaan" class="form-control" rows="3" required>{{ $pemeliharaan->rincian_pekerjaan }}</textarea>
                                </div>
                            </div>

                            <div class="form-section-title">Anggaran & Biaya</div>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label class="form-label">Pagu Anggaran (Rp)</label>
                                    <input type="text" id="pagu_display" class="form-control" value="{{ number_format($pemeliharaan->pagu, 0, ',', '.') }}">
                                    <input type="hidden" name="pagu" id="pagu" value="{{ $pemeliharaan->pagu }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Biaya Realisasi (Rp)</label>
                                    <input type="text" id="biaya_display" class="form-control" value="{{ number_format($pemeliharaan->biaya, 0, ',', '.') }}">
                                    <input type="hidden" name="biaya" id="biaya" value="{{ $pemeliharaan->biaya }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Biaya Kumulatif (Rp)</label>
                                    <input type="text" id="kumulatif_display" class="form-control" value="{{ number_format($pemeliharaan->biaya_kumulatif, 0, ',', '.') }}">
                                    <input type="hidden" name="biaya_kumulatif" id="biaya_kumulatif" value="{{ $pemeliharaan->biaya_kumulatif }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                <a href="{{ route('pemeliharaans.index') }}" class="btn btn-light px-4 border fw-semibold">Batal</a>
                                <button type="submit" class="btn btn-bps-blue px-5 shadow-sm">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setupMask(displayId, hiddenId) {
            const display = document.getElementById(displayId);
            const hidden = document.getElementById(hiddenId);
            display.addEventListener('input', function(e) {
                let val = e.target.value.replace(/\D/g, '');
                display.value = val ? new Intl.NumberFormat('id-ID').format(val) : '';
                hidden.value = val || 0;
            });
        }
        setupMask('pagu_display', 'pagu');
        setupMask('biaya_display', 'biaya');
        setupMask('kumulatif_display', 'biaya_kumulatif');
    </script>
</body>
</html>