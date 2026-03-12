<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang — BPS Kota Bontang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --bps-blue: #003366;
            --bps-blue-dark: #002244;
            --bps-orange: #E8751A;
            --bps-green: #77B02A;
            --bg-body: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --error: #ef4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container { width: 100%; max-width: 800px; margin: auto; }

        .card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
        }

        .card-header {
            background-color: var(--bps-blue);
            padding: 30px;
            position: relative;
        }

        .card-header::after {
            content: "";
            position: absolute;
            bottom: 0; left: 0;
            width: 100%; height: 4px;
            background: var(--bps-orange);
        }

        .card-header h2 {
            color: var(--white);
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .card-body { padding: 40px; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .full-width { grid-column: span 2; }

        label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }

        input {
            width: 100%;
            padding: 12px 16px;
            font-family: inherit;
            font-size: 0.95rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            transition: all 0.2s ease;
            color: var(--text-main);
        }

        input:focus {
            outline: none;
            border-color: var(--bps-blue);
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1);
        }

        input.is-invalid { border-color: var(--error); }

        .invalid-feedback {
            color: var(--error);
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 4px;
        }

        .form-actions {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            font-family: inherit;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 12px 28px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-bps-blue {
            background-color: var(--bps-blue);
            color: var(--white);
            border: none;
            box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
        }

        .btn-bps-blue:hover {
            background-color: var(--bps-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 51, 102, 0.3);
        }

        .btn-cancel {
            background-color: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .btn-cancel:hover {
            background-color: #f1f5f9;
            color: var(--text-main);
            border-color: var(--text-muted);
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .form-actions { flex-direction: column-reverse; gap: 12px; }
            .btn { width: 100%; }
            .card-body { padding: 25px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            {{-- ══ HEADER ══ --}}
            <div class="card-header">
                <h2>Edit Data Barang</h2>
            </div>

            {{-- ══ FORM BODY ══ --}}
            <div class="card-body">
                <form action="{{ route('barangs.update', $barang->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- ✅ INI YANG WAJIB ADA AGAR UPDATE BISA BERJALAN --}}

                    {{-- Hidden Field Kategori --}}
                    <input type="hidden" name="kategori_id" value="{{ $barang->kategori_id }}">

                    <div class="form-grid">
                        {{-- Baris 1: NUP & Nama Barang --}}
                        <div class="form-group">
                            <label for="nup_bmn">Nomor Urut Pendaftaran (NUP)</label>
                            <input type="text" 
                                   id="nup_bmn"
                                   name="nup_bmn" 
                                   class="@error('nup_bmn') is-invalid @enderror" 
                                   value="{{ old('nup_bmn', $barang->nup_bmn) }}" 
                                   placeholder="Contoh: 0001" 
                                   required>
                            @error('nup_bmn')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" 
                                   id="nama_barang"
                                   name="nama_barang" 
                                   class="@error('nama_barang') is-invalid @enderror" 
                                   value="{{ old('nama_barang', $barang->nama_barang) }}" 
                                   placeholder="Contoh: Laptop Acer Swift" 
                                   required>
                            @error('nama_barang')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Baris 2: Merk/Tipe & Lokasi --}}
                        <div class="form-group">
                            <label for="merk_type">Merk / Tipe</label>
                            <input type="text" 
                                   id="merk_type"
                                   name="merk_type" 
                                   class="@error('merk_type') is-invalid @enderror" 
                                   value="{{ old('merk_type', $barang->merk_type) }}" 
                                   placeholder="Masukkan Merk/Tipe">
                            @error('merk_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lokasi">Lokasi Penempatan</label>
                            <input type="text" 
                                   id="lokasi"
                                   name="lokasi" 
                                   class="@error('lokasi') is-invalid @enderror" 
                                   value="{{ old('lokasi', $barang->lokasi) }}">
                            @error('lokasi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- ══ ACTION BUTTONS ══ --}}
                    <div class="form-actions">
                        <a href="{{ route('barangs.index', ['kategori_id' => $barang->kategori_id]) }}" class="btn btn-cancel">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-bps-blue">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ══ FOOTER ══ --}}
        <footer>
            &copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bontang</strong>
        </footer>
    </div>

</body>
</html>