<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemeliharaan - BPS Kota Bontang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bps-blue: #003366; --bps-light: #f8fafc; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bps-light); }
        .detail-card { border: 1px solid #e2e8f0; border-radius: 8px; background: white; overflow: hidden; }
        .detail-header { background: var(--bps-blue); color: white; padding: 20px 30px; }
        .section-title { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 5px; }
        .label { font-size: 0.8rem; color: #94a3b8; margin-bottom: 2px; }
        .value { font-size: 0.95rem; font-weight: 600; color: #1e293b; margin-bottom: 20px; }
        .finance-box { background: #f8fafc; border-radius: 6px; padding: 20px; border: 1px solid #e2e8f0; }
        .btn-back { background: white; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; padding: 8px 25px; border-radius: 6px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="mb-4">
                    <a href="{{ route('pemeliharaans.index') }}" class="btn-back">Kembali</a>
                </div>

                <div class="detail-card shadow-sm">
                    <div class="detail-header">
                        <h5 class="m-0 fw-bold">Rincian Data Pemeliharaan</h5>
                        <small class="opacity-75">ID Transaksi: #{{ $pemeliharaan->id }}</small>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="section-title">Informasi Aset</div>
                                <div class="label">NUP BMN</div>
                                <div class="value">{{ $pemeliharaan->barang->nup_bmn ?? '-' }}</div>
                                
                                <div class="label">Nama Barang</div>
                                <div class="value">{{ $pemeliharaan->barang->nama_barang ?? '-' }}</div>

                                <div class="label">Lokasi Penempatan</div>
                                <div class="value">{{ $pemeliharaan->barang->lokasi ?? '-' }}</div>
                            </div>
                            
                            <div class="col-md-6 border-start ps-md-5">
                                <div class="section-title">Detail Pekerjaan</div>
                                <div class="label">Tanggal</div>
                                <div class="value">{{ $pemeliharaan->tanggal_mulai ? $pemeliharaan->tanggal_mulai->format('d F Y') : '-' }}</div>
                                
                                <div class="label">Rincian Pekerjaan</div>
                                <div class="value">{{ $pemeliharaan->rincian_pekerjaan }}</div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="section-title">Informasi Keuangan</div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="finance-box text-center">
                                            <div class="label">Pagu Anggaran</div>
                                            <div class="h5 fw-bold m-0 text-dark">Rp {{ number_format($pemeliharaan->pagu, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="finance-box text-center" style="border-top: 3px solid #ef4444;">
                                            <div class="label">Biaya Realisasi</div>
                                            <div class="h5 fw-bold m-0 text-danger">Rp {{ number_format($pemeliharaan->biaya, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="finance-box text-center" style="border-top: 3px solid #22c55e;">
                                            <div class="label">Sisa Anggaran</div>
                                            <div class="h5 fw-bold m-0 text-success">
                                                Rp {{ number_format($pemeliharaan->pagu - $pemeliharaan->biaya_kumulatif, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>