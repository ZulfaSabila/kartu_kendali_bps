<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemeliharaan BMN - BPS Kota Bontang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --bps-blue: #003366; --bps-cyan: #00AEEF; --bps-green: #77B02A; --bps-orange: #F39200; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .card-detail { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .detail-label { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 4px; }
        .detail-value { font-size: 1.05rem; font-weight: 600; color: #0f172a; margin-bottom: 20px; }
        .finance-card { border-radius: 10px; padding: 15px; border-left: 5px solid; }
        .progress { height: 12px; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0" style="color: var(--bps-blue);">Rincian Data Pemeliharaan</h2>
                <p class="text-muted m-0 small">NUP BMN: {{ $pemeliharaan->nup_bmn }}</p>
            </div>
            <a href="{{ route('pemeliharaans.index') }}" class="btn btn-outline-secondary shadow-sm"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card card-detail p-4 bg-white mb-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-2">Informasi Aset & Lokasi</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-label">Kategori Barang</div>
                            <div class="detail-value"><span class="badge px-3 py-2" style="background-color: var(--bps-cyan);">{{ $pemeliharaan->kategori->nama_kategori }}</span></div>
                            <div class="detail-label">Nama Barang</div>
                            <div class="detail-value text-primary">{{ $pemeliharaan->nama_barang }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">NUP BMN</div>
                            <div class="detail-value">{{ $pemeliharaan->nup_bmn ?? '-' }}</div>
                            <div class="detail-label">Merk/Type</div>
                            <div class="detail-value">{{ $pemeliharaan->merk_type ?? '-' }}</div>
                        </div>
                        <div class="col-md-12">
                            <div class="detail-label"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Lokasi Penempatan</div>
                            <div class="detail-value">{{ $pemeliharaan->lokasi }}</div>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-2 mb-4 border-bottom pb-2">Detail Pengerjaan</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-label">Waktu Pelaksanaan</div>
                            <div class="detail-value">
                                <i class="bi bi-calendar-event me-2 text-muted"></i>{{ $pemeliharaan->tanggal_mulai ? $pemeliharaan->tanggal_mulai->format('d F Y') : '-' }} s/d {{ $pemeliharaan->tanggal_selesai ? $pemeliharaan->tanggal_selesai->format('d F Y') : '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Durasi Pekerjaan</div>
                            <div class="detail-value"><span class="text-dark">{{ $pemeliharaan->tanggal_mulai && $pemeliharaan->tanggal_selesai ? $pemeliharaan->tanggal_mulai->diffInDays($pemeliharaan->tanggal_selesai) . ' Hari' : '-' }}</span></div>
                        </div>
                        <div class="col-12">
                            <div class="detail-label">Rincian Pekerjaan</div>
                            <div class="p-3 bg-light rounded border text-muted" style="min-height: 80px;">{{ $pemeliharaan->rincian_pekerjaan ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card card-detail p-4 bg-white">
                    <h5 class="fw-bold mb-4 border-bottom pb-2">Status Anggaran</h5>
                    <div class="finance-card mb-3" style="border-left-color: var(--bps-cyan); background-color: #f0f9ff;">
                        <div class="detail-label text-primary">Biaya Perbaikan</div>
                        <div class="h4 fw-bold m-0 text-primary">Rp {{ number_format($pemeliharaan->biaya, 0, ',', '.') }}</div>
                    </div>
                    
                    <div class="finance-card mb-3" style="border-left-color: var(--bps-green); background-color: #f0fdf4;">
                        <div class="detail-label text-success">Pagu Anggaran</div>
                        <div class="h5 fw-bold m-0 text-success">Rp {{ number_format($pemeliharaan->pagu, 0, ',', '.') }}</div>
                    </div>
                    
                    <div class="finance-card mb-4" style="border-left-color: {{ $pemeliharaan->sisa_anggaran >= 0 ? '#22c55e' : '#ef4444' }}; background-color: {{ $pemeliharaan->sisa_anggaran >= 0 ? '#f0fdf4' : '#fef2f2' }};">
                        <div class="detail-label">Sisa Anggaran</div>
                        <div class="h4 fw-bold m-0 {{ $pemeliharaan->sisa_anggaran >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($pemeliharaan->sisa_anggaran, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

                    <div class="mt-2">
                        @php $persentase = $pemeliharaan->pagu > 0 ? ($pemeliharaan->biaya / $pemeliharaan->pagu) * 100 : 0; @endphp
                        <div class="d-flex justify-content-between small fw-bold mb-2">
                            <span>Penyerapan</span>
                            <span class="{{ $persentase > 100 ? 'text-danger' : 'text-muted' }}">{{ number_format($persentase, 1) }}%</span>
                        </div>
                        <div class="progress shadow-sm mb-3">
                            <div class="progress-bar {{ $persentase > 100 ? 'bg-danger' : 'bg-success' }}" role="progressbar" style="width: {{ min($persentase, 100) }}%"></div>
                        </div>
                        @if($persentase > 100)
                            <div class="alert alert-danger py-2 px-3 small border-0 shadow-sm"><i class="bi bi-exclamation-triangle-fill me-2"></i>Melebihi Pagu!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>