<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemeliharaan — Kartu Kendali BPS Kota Bontang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ── VARIABEL WARNA BPS ── */
        :root {
            --bps-blue: #003366;
            --bps-blue-dark: #002244;
            --bps-orange: #E8751A;
            --bps-green: #77B02A;
            --bg-body: #f8fafc;
            --border-color: #e2e8f0;
            --white: #ffffff;
        }

        /* ── BASE STYLING ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .container-form {
            width: 100%;
            max-width: 780px;
            animation: fadeIn 0.5s ease-out;
        }

        /* ── CARD STYLING ── */
        .card-bps {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .card-header-bps {
            background-color: var(--bps-blue);
            padding: 30px;
            position: relative;
        }

        .card-header-bps::after {
            content: "";
            position: absolute;
            bottom: 0; left: 0;
            width: 100%;
            height: 4px;
            background: var(--bps-orange);
        }

        .header-title {
            color: var(--white);
            font-weight: 800;
            font-size: 1.25rem;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .card-body-bps {
            padding: 40px;
        }

        /* ── SECTION TITLE ── */
        .form-section-title {
            font-weight: 800;
            color: var(--bps-blue);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            margin-bottom: 20px;
            margin-top: 32px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
        }

        .form-section-title:first-child { margin-top: 0; }

        /* ── FORM CONTROL STYLING ── */
        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            width: 100%;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            transition: all 0.2s;
            background-color: var(--white);
            outline: none;
        }

        .form-control:focus {
            border-color: var(--bps-blue);
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1);
        }

        .form-control::placeholder {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        textarea.form-control { resize: vertical; }

        /* ── INPUT GROUP (Rp prefix) ── */
        .input-group {
            display: flex;
        }

        .input-prefix {
            background: var(--bg-body);
            border: 1.5px solid var(--border-color);
            border-right: none;
            border-radius: 10px 0 0 10px;
            padding: 12px 14px;
            font-size: 0.88rem;
            font-weight: 700;
            color: #64748b;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .input-group .form-control:focus {
            border-color: var(--bps-blue);
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1);
        }

        /* ── GRID ROW ── */
        .row {
            display: grid;
            gap: 20px;
            margin-bottom: 0;
        }

        .row-2 { grid-template-columns: 1fr 1fr; }
        .row-3 { grid-template-columns: 1fr 1fr 1fr; }
        .row-1 { grid-template-columns: 1fr; }

        .mb-20 { margin-bottom: 20px; }

        /* ── BUTTON STYLING ── */
        .btn-bps-blue {
            background-color: var(--bps-blue);
            color: var(--white);
            border: none;
            padding: 12px 35px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-bps-blue:hover {
            background-color: var(--bps-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 51, 102, 0.2);
        }

        .btn-cancel {
            background-color: transparent;
            color: #64748b;
            border: 1px solid #cbd5e1;
            padding: 12px 35px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #f1f5f9;
            color: #1e293b;
            border-color: #94a3b8;
        }

        .action-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 36px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        /* ── FOOTER ── */
        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* ── ANIMATION ── */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 640px) {
            .card-body-bps { padding: 28px 20px; }
            .row-2, .row-3 { grid-template-columns: 1fr; }
            .action-row { flex-direction: column-reverse; gap: 12px; }
            .btn-bps-blue, .btn-cancel { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>

    <div class="container-form">
        <div class="card-bps">

            {{-- ══ HEADER ══ --}}
            <div class="card-header-bps">
                <h2 class="header-title">Edit Data Pemeliharaan</h2>
            </div>

            {{-- ══ FORM BODY ══ --}}
            <div class="card-body-bps">
                <form action="{{ route('pemeliharaans.update', $pemeliharaan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- ── WAKTU & PEKERJAAN ── --}}
                    <div class="form-section-title">Waktu & Pekerjaan</div>

                    <div class="row row-2 mb-20">
                        <div>
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control"
                                value="{{ $pemeliharaan->tanggal_mulai ? $pemeliharaan->tanggal_mulai->format('Y-m-d') : '' }}" required>
                        </div>
                        <div>
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ $pemeliharaan->tanggal_selesai ? $pemeliharaan->tanggal_selesai->format('Y-m-d') : '' }}">
                        </div>
                    </div>

                    <div class="row row-1 mb-20">
                        <div>
                            <label class="form-label">Rincian Pekerjaan</label>
                            <textarea name="rincian_pekerjaan" class="form-control" rows="4" required>{{ $pemeliharaan->rincian_pekerjaan }}</textarea>
                        </div>
                    </div>

                    {{-- ── ANGGARAN & BIAYA ── --}}
                    <div class="form-section-title">Anggaran & Biaya</div>

                    <div class="row row-3">
                        <div>
                            <label class="form-label">Biaya (Rp)</label>
                            <div class="input-group">
                                <span class="input-prefix">Rp</span>
                                <input type="text" id="biaya_display" class="form-control"
                                    value="{{ number_format($pemeliharaan->biaya, 0, ',', '.') }}">
                            </div>
                            <input type="hidden" name="biaya" id="biaya" value="{{ $pemeliharaan->biaya }}">
                        </div>
                        <div>
                            <label class="form-label">Biaya Kumulatif (Rp)</label>
                            <div class="input-group">
                                <span class="input-prefix">Rp</span>
                                <input type="text" id="kumulatif_display" class="form-control"
                                    value="{{ number_format($pemeliharaan->biaya_kumulatif, 0, ',', '.') }}">
                            </div>
                            <input type="hidden" name="biaya_kumulatif" id="biaya_kumulatif" value="{{ $pemeliharaan->biaya_kumulatif }}">
                        </div>
                        <div>
                            <label class="form-label">Pagu Anggaran (Rp)</label>
                            <div class="input-group">
                                <span class="input-prefix">Rp</span>
                                <input type="text" id="pagu_display" class="form-control"
                                    value="{{ number_format($pemeliharaan->pagu, 0, ',', '.') }}">
                            </div>
                            <input type="hidden" name="pagu" id="pagu" value="{{ $pemeliharaan->pagu }}">
                        </div>
                    </div>

                    {{-- ── ACTION BUTTONS ── --}}
                    <div class="action-row">
                        <a href="{{ route('pemeliharaans.index') }}" class="btn-cancel">Batal</a>
                        <button type="submit" class="btn-bps-blue">Simpan Perubahan</button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ══ FOOTER ══ --}}
        <p class="footer-text">
            &copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bontang</strong>
        </p>
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