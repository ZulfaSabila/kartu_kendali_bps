<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Pemeliharaan - BPS Kota Bontang</title>

    {{-- ══ FONTS ══ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ── VARIABEL WAJIB ── */
        :root {
            --bps-blue: #003366;
            --bps-blue-dark: #002244;
            --bps-orange: #E8751A;
            --bps-green: #77B02A;
            --bg-body: #f8fafc;
            --border-color: #e2e8f0;
            --white: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        /* ── BASE STYLES ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        /* ── LAYOUT CONTAINER ── */
        .main-container {
            width: 100%;
            max-width: 780px;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── CARD STYLES ── */
        .card-bps {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 25px;
        }

        /* ── HEADER ── */
        .card-header-bps {
            background: var(--bps-blue);
            padding: 30px;
            position: relative;
        }

        .card-header-bps::after {
            content: "";
            position: absolute;
            bottom: 0; left: 0;
            width: 100%; height: 4px;
            background: var(--bps-orange);
        }

        .card-header-bps h4 {
            color: var(--white);
            font-weight: 800;
            font-size: 1.25rem;
            margin: 0;
            text-transform: none;
        }

        .card-header-bps p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* ── FORM STYLES ── */
        .card-body { padding: 28px 40px; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-group { margin-bottom: 16px; }
        .full-width { grid-column: span 2; }

        .form-label {
            display: block;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .form-control, .form-select, textarea {
            width: 100%;
            padding: 12px 16px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-main);
            background: var(--white);
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            transition: all 0.2s;
            outline: none;
        }

        .form-control:focus, .form-select:focus, textarea:focus {
            border-color: var(--bps-blue);
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1);
        }

        /* ── SECTION TITLES (NO ICON) ── */
        .section-divider {
            margin: 20px 0 14px 0;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--bps-blue);
            letter-spacing: 0.1em;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
        }

        /* ── ASSET INFO BOX ── */
        .asset-info-box {
            display: none;
            background: #f8fafc;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            padding: 10px 16px;
            margin: 0 0 16px 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 24px;
        }

        .info-item {
            display: flex;
            align-items: baseline;
            gap: 6px;
        }

        .info-item .info-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .info-item .info-label::after {
            content: ":";
        }

        .info-item .info-value {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--bps-blue);
        }

        /* ── INPUT GROUP Rp ── */
        .input-group {
            display: flex;
            align-items: stretch;
        }

        .input-group-text {
            background: #f8fafc;
            border: 1.5px solid var(--border-color);
            border-right: none;
            padding: 0 15px;
            display: flex;
            align-items: center;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.85rem;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        /* ── ACTION BUTTONS ── */
        .form-actions {
            display: flex;
            flex-direction: row;        /* pastikan horizontal */
            justify-content: flex-end;
            align-items: center;
            gap: 12px;                  /* jarak antar tombol */
            margin-top: 12px;
            padding-top: 20px;
            border-top: 1.5px solid var(--border-color);
        }

        .btn-submit {
            background: var(--bps-blue);
            color: var(--white);
            border: none;
            padding: 12px 30px;         /* samakan padding */
            border-radius: 10px;
            font-weight: 700;
            font-family: inherit;
            font-size: 0.95rem;         /* tambah font-size agar sama */
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: var(--bps-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.2);
        }
        
        .btn-cancel {
            text-decoration: none;
            color: var(--text-muted);
            background: transparent;
            border: 1.5px solid #cbd5e1;
            padding: 12px 30px;         /* samakan padding */
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
            color: var(--text-main);
        }

        /* ── FOOTER ── */
        .footer-text {
            text-align: center;
            color: #94a3b8;
            font-size: 0.8rem;
            margin-top: 20px;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
            .form-row, .info-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .form-actions { flex-direction: column-reverse; gap: 15px; }
            .btn-submit, .btn-cancel { width: 100%; text-align: center; }
        }
    </style>
</head>

<body>

    <div class="main-container">
        <div class="card-bps">
            
            {{-- ══ HEADER SECTION (NO ICON) ══ --}}
            <div class="card-header-bps">
                <h4>Tambah Data Pemeliharaan</h4>
                <p>Input rincian pemeliharaan aset BMN BPS Kota Bontang</p>
            </div>

            <div class="card-body">
                <form action="{{ route('pemeliharaans.store') }}" method="POST">
                    @csrf

                    {{-- ══ SECTION: INFORMASI ASET ══ --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kategori Aset</label>
                            <select name="kategori_id" id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama Barang / NUP</label>
                            <select name="barang_id" id="barang_id" class="form-select" required disabled>
                                <option value="">Pilih kategori dahulu</option>
                            </select>
                        </div>
                    </div>

                    {{-- ══ ASSET INFO DISPLAY ══ --}}
                    <div id="asset_info_display" class="asset-info-box">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">NUP BMN</div>
                                <div id="info_nup" class="info-value">-</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Nama Aset</div>
                                <div id="info_nama" class="info-value">-</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Merk/Type</div>
                                <div id="info_merk" class="info-value">-</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Lokasi</div>
                                <div id="info_lokasi" class="info-value">-</div>
                            </div>
                        </div>
                    </div>

                    {{-- ══ SECTION: DETAIL PEKERJAAN ══ --}}
                    <div class="section-divider">Detail Pekerjaan</div>

                    <div class="form-row" style="grid-template-columns: 1fr 1fr 2fr; gap: 16px;">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Rincian Perbaikan/Pemeliharaan</label>
                            <textarea name="rincian_pekerjaan" rows="3" required
                                      placeholder="Jelaskan detail perbaikan yang dilakukan..."></textarea>
                        </div>
                    </div>

                    {{-- ══ SECTION: INFORMASI BIAYA ══ --}}
                    <div class="section-divider">Informasi Biaya</div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label class="form-label">Biaya (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="biaya_display" class="form-control" placeholder="0">
                            </div>
                            <input type="hidden" id="biaya" name="biaya">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Biaya Kumulatif</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="kumulatif_display" class="form-control" placeholder="0">
                            </div>
                            <input type="hidden" id="biaya_kumulatif" name="biaya_kumulatif">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pagu Anggaran</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="pagu_display" class="form-control" placeholder="0">
                            </div>
                            <input type="hidden" id="pagu" name="pagu">
                        </div>
                    </div>

                    {{-- ══ ACTION BUTTONS (NO ICON) ══ --}}
                    <div class="form-actions">
                        <a href="{{ route('pemeliharaans.index') }}" class="btn-cancel">
                            Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <p class="footer-text">
            &copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bontang</strong>
        </p>
    </div>

    {{-- ══ JAVASCRIPT (LOGIKA TETAP SAMA) ══ --}}
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const kategoriSelect = document.getElementById('kategori_id');
        const barangSelect = document.getElementById('barang_id');
        const infoDisplay = document.getElementById('asset_info_display');

        kategoriSelect.addEventListener('change', function () {
            const kategoriId = this.value;
            barangSelect.innerHTML = '<option>Loading...</option>';
            barangSelect.disabled = true;
            infoDisplay.style.display = 'none';
            if (!kategoriId) return;

            fetch(`/api/barangs-by-kategori/${kategoriId}`, {
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                barangSelect.innerHTML = '<option value="">-- Pilih Barang --</option>';
                data.forEach(barang => {
                    const opt = document.createElement('option');
                    opt.value = barang.id;
                    opt.textContent = `${barang.nup_bmn} - ${barang.nama_barang}`;
                    opt.dataset.nup = barang.nup_bmn || '-';
                    opt.dataset.nama = barang.nama_barang || '-';
                    opt.dataset.merk = barang.merk_type || '-';
                    opt.dataset.lokasi = barang.lokasi || '-';
                    barangSelect.appendChild(opt);
                });
                barangSelect.disabled = false;
            });
        });

        barangSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            if (!selected.value) { infoDisplay.style.display = 'none'; return; }
            document.getElementById('info_nup').innerText = selected.dataset.nup;
            document.getElementById('info_nama').innerText = selected.dataset.nama;
            document.getElementById('info_merk').innerText = selected.dataset.merk;
            document.getElementById('info_lokasi').innerText = selected.dataset.lokasi;
            infoDisplay.style.display = 'block';
        });

        function setupCurrencyMask(displayId, hiddenId) {
            const display = document.getElementById(displayId);
            const hidden = document.getElementById(hiddenId);
            display.addEventListener('input', function () {
                const raw = this.value.replace(/\D/g, '');
                display.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                hidden.value = raw || 0;
            });
        }
        setupCurrencyMask('pagu_display', 'pagu');
        setupCurrencyMask('biaya_display', 'biaya');
        setupCurrencyMask('kumulatif_display', 'biaya_kumulatif');
    </script>
</body>
</html>