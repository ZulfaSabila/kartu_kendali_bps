<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang - BPS Kota Bontang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bps-blue: #003366;
            --bps-dark: #002347;
            --bps-green: #77B02A;
            --bps-light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bps-light);
            color: #334155;
        }

        .card-bps {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header-bps {
            background-color: var(--bps-blue);
            border-bottom: 3px solid var(--bps-green);
            padding: 1.5rem;
            color: white;
        }

        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .btn-bps-blue {
            background-color: var(--bps-blue);
            color: white;
            font-weight: 700;
            padding: 10px 35px;
            border-radius: 8px;
            border: none;
            transition: all 0.2s;
        }

        .btn-bps-blue:hover {
            background-color: var(--bps-dark);
            color: white;
            transform: translateY(-1px);
        }

        .btn-cancel {
            background-color: white;
            color: #64748b;
            border: 1px solid #cbd5e1;
            font-weight: 600;
            padding: 10px 30px;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-bps">
                    <div class="card-header-bps">
                        <h5 class="mb-0 fw-bold">Edit Data Barang / Aset</h5>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <form action="{{ route('barangs.update', $barang->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">NUP BMN</label>
                                    <input type="text" name="nup_bmn" class="form-control @error('nup_bmn') is-invalid @enderror" 
                                           value="{{ old('nup_bmn', $barang->nup_bmn) }}">
                                    @error('nup_bmn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" 
                                           value="{{ old('nama_barang', $barang->nama_barang) }}">
                                    @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Merk / Tipe</label>
                                    <input type="text" name="merk_type" class="form-control @error('merk_type') is-invalid @enderror" 
                                           value="{{ old('merk_type', $barang->merk_type) }}">
                                    @error('merk_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Lokasi Penempatan</label>
                                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" 
                                           value="{{ old('lokasi', $barang->lokasi) }}">
                                    @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                <a href="{{ route('barangs.index', ['kategori_id' => $barang->kategori_id]) }}" class="btn-cancel">Batal</a>
                                <button type="submit" class="btn-bps-blue shadow-sm">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>