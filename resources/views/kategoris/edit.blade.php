<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori — Kartu Kendali BPS Kota Bontang</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .container-form {
            width: 100%;
            max-width: 620px;
            animation: fadeIn 0.5s ease-out;
        }

        /* ── CARD STYLING ── */
        .card-bps {
            background: var(--white);
            border: none;
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

        /* Aksen Oranye di bawah Header */
        .card-header-bps::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
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

        /* ── FORM CONTROL STYLING ── */
        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            color: #1e293b;
            transition: all 0.2s;
            background-color: #ffffff;
        }

        .form-control:focus {
            border-color: var(--bps-blue);
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1);
            outline: none;
        }

        /* Handling Error Laravel */
        .is-invalid {
            border-color: #ef4444 !important;
        }
        .invalid-feedback {
            font-weight: 500;
            font-size: 0.8rem;
        }

        /* ── BUTTON STYLING (TANPA IKON) ── */
        .btn-bps-blue {
            background-color: var(--bps-blue);
            color: var(--white);
            border: none;
            padding: 12px 35px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .btn-bps-blue:hover {
            background-color: var(--bps-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 51, 102, 0.2);
            color: var(--white);
        }

        .btn-cancel {
            background-color: transparent;
            color: #64748b;
            border: 1px solid #cbd5e1;
            padding: 12px 35px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background-color: #f1f5f9;
            color: #1e293b;
            border-color: #94a3b8;
        }

        /* ── FOOTER ── */
        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 576px) {
            .card-body-bps { padding: 30px 20px; }
            .btn-bps-blue, .btn-cancel { width: 100%; display: block; text-align: center; margin-bottom: 10px; }
            .d-flex-mobile { flex-direction: column-reverse; }
        }
    </style>
</head>
<body>

    <div class="container-form">
        <div class="card-bps">
            {{-- ══ HEADER ══ --}}
            <div class="card-header-bps">
                <h2 class="header-title">Edit Data Kategori</h2>
            </div>

            {{-- ══ FORM BODY ══ --}}
            <div class="card-body-bps">
                <form action="{{ route('kategoris.update', $kategori) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Kategori --}}
                    <div class="mb-4">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                               required>
                        @error('nama_kategori') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    {{-- Deskripsi Kategori --}}
                    <div class="mb-4">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    </div>

                    {{-- Action Buttons (Minimalis - Tanpa Ikon) --}}
                    <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top d-flex-mobile">
                        <a href="{{ route('kategoris.index') }}" class="btn-cancel">
                            Batal
                        </a>
                        <button type="submit" class="btn-bps-blue shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ══ FOOTER ══ --}}
        <p class="footer-text">
            &copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bontang</strong>
        </p>
    </div>

</body>
</html>