<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Pemeliharaan - BPS Kota Bontang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bps-blue: #003366;
            --bps-green: #77B02A;
            --bps-light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bps-light);
            color: #334155;
        }

        /* Header Biru yang Dipertahankan & Dirapikan */
        .card-header-bps {
            background-color: var(--bps-blue);
            border-bottom: 3px solid var(--bps-green);
            padding: 1.5rem;
            color: white;
        }

        .card-bps {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-section-title {
            font-weight: 700;
            color: var(--bps-blue);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--bps-green);
            padding-left: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem;
        }

        .form-control, .form-select {
            padding: 0.6rem 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        /* Info Box Aset */
        .asset-info-box {
            background-color: #f1f5f9;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 2rem;
            display: none; /* Muncul via JS */
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .info-label { font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase; }
        .info-value { font-size: 0.9rem; font-weight: 600; color: var(--bps-blue); }

        .btn-bps-blue { background-color: var(--bps-blue); color: white; font-weight: 600; border-radius: 8px; padding: 0.6rem 2rem; }
        .btn-bps-blue:hover { background-color: #002347; color: white; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-bps">
                    <div class="card-header-bps">
                        <h5 class="mb-0 fw-bold">Tambah Data Pemeliharaan</h5>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <form action="{{ route('pemeliharaans.store') }}" method="POST">
                            @csrf

                            <div class="form-section-title">Pemilihan Aset</div>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoris as $k)
                                            <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Barang / NUP</label>
                                    <select name="barang_id" id="barang_id" class="form-select" required {{ !isset($barangs) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Barang --</option>
                                        @if(isset($barangs))
                                            @foreach($barangs as $b)
                                                <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}
                                                    data-nup="{{ $b->nup_bmn }}" data-nama="{{ $b->nama_barang }}" data-merk="{{ $b->merk_type }}" data-lokasi="{{ $b->lokasi }}">
                                                    {{ $b->nup_bmn }} - {{ $b->nama_barang }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div id="asset_info_display" class="asset-info-box shadow-sm">
                                <div class="info-grid">
                                    <div><div class="info-label">NUP</div><div id="info_nup" class="info-value">-</div></div>
                                    <div><div class="info-label">Aset</div><div id="info_nama" class="info-value">-</div></div>
                                    <div><div class="info-label">Merk</div><div id="info_merk" class="info-value">-</div></div>
                                    <div><div class="info-label">Lokasi</div><div id="info_lokasi" class="info-value">-</div></div>
                                </div>
                            </div>

                            <div class="form-section-title">Waktu & Pekerjaan</div>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Rincian Pekerjaan</label>
                                    <textarea name="rincian_pekerjaan" class="form-control" rows="3" placeholder="Contoh: Penggantian oli dan servis rutin..." required></textarea>
                                </div>
                            </div>

                            <div class="form-section-title">Anggaran & Biaya</div>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label class="form-label">Pagu Anggaran (Rp)</label>
                                    <input type="text" id="pagu_display" class="form-control" placeholder="0">
                                    <input type="hidden" name="pagu" id="pagu">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Biaya Realisasi (Rp)</label>
                                    <input type="text" id="biaya_display" class="form-control" placeholder="0">
                                    <input type="hidden" name="biaya" id="biaya">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Biaya Kumulatif Saat Ini (Rp)</label>
                                    <input type="text" id="kumulatif_display" class="form-control" placeholder="0">
                                    <input type="hidden" name="biaya_kumulatif" id="biaya_kumulatif">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                <a href="{{ route('pemeliharaans.index') }}" class="btn btn-light px-4 border fw-semibold">Batal</a>
                                <button type="submit" class="btn btn-bps-blue px-5 shadow-sm">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Logic Dropdown Dinamis & Masking
        const kategoriSelect = document.getElementById('kategori_id');
        const barangSelect = document.getElementById('barang_id');
        const infoDisplay = document.getElementById('asset_info_display');

        function updateAssetInfo() {
            const selected = barangSelect.options[barangSelect.selectedIndex];
            if (selected.value) {
                document.getElementById('info_nup').innerText = selected.dataset.nup;
                document.getElementById('info_nama').innerText = selected.dataset.nama;
                document.getElementById('info_merk').innerText = selected.dataset.merk;
                document.getElementById('info_lokasi').innerText = selected.dataset.lokasi;
                infoDisplay.style.display = 'block';
            } else {
                infoDisplay.style.display = 'none';
            }
        }

        barangSelect.addEventListener('change', updateAssetInfo);
        if(barangSelect.value) updateAssetInfo();

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