<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemeliharaan - BPS Kota Bontang</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        .detail-value {
            font-size: 1.1rem;
            color: #212529;
            margin-bottom: 1rem;
        }
        .info-box {
            border-left: 4px solid;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.25rem;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0" style="color: #003366;">
                        <i class="bi bi-eye-fill me-2"></i> Detail Data Pemeliharaan
                    </h1>
                    <div class="d-flex gap-2">
                        </a>
                        <a href="{{ route('pemeliharaans.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header text-white" style="background-color: #003366;">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>Informasi Pemeliharaan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                            <!-- Kategori -->
                            <div class="col-md-6 mb-3">
                                <div class="detail-label">Kategori</div>
                                <div class="detail-value">
                                    <span class="badge" style="background-color: #00AEEF; font-size: 1rem;">
                                        {{ $pemeliharaan->kategori->nama_kategori }}
                                    </span>
                                </div>
                            </div>

                            <!-- NUP BMN -->
                            <div class="col-md-6 mb-3">
                                <div class="detail-label">NUP BMN</div>
                                <div class="detail-value">{{ $pemeliharaan->nup_bmn ?? '-' }}</div>
                            </div>

                            <!-- Nama Barang -->
                            <div class="col-md-6 mb-3">
                                <div class="detail-label">Nama Barang</div>
                                <div class="detail-value">{{ $pemeliharaan->nama_barang ?? '-' }}</div>
                            </div>

                            <!-- Merk/Type -->
                            <div class="col-md-6 mb-3">
                                <div class="detail-label">Merk/Type</div>
                                <div class="detail-value">{{ $pemeliharaan->merk_type ?? '-' }}</div>
                            </div>

                            <!-- Lokasi -->
                            <div class="col-md-12 mb-3">
                                <div class="detail-label">
                                    <i class="bi bi-geo-alt-fill text-danger"></i> Lokasi
                                </div>
                                <div class="detail-value">{{ $pemeliharaan->lokasi }}</div>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div class="col-md-6 mb-3">
                                <div class="detail-label">
                                    <i class="bi bi-calendar-check text-success"></i> Tanggal Mulai Pekerjaan
                                </div>
                                <div class="detail-value">
                                    {{ $pemeliharaan->tanggal_mulai ? $pemeliharaan->tanggal_mulai->format('d F Y') : '-' }}
                                </div>
                            </div>

                            <!-- Tanggal Selesai -->
                            <div class="col-md-6 mb-3">
                                <div class="detail-label">
                                    <i class="bi bi-calendar-x text-danger"></i> Tanggal Selesai Pekerjaan
                                </div>
                                <div class="detail-value">
                                    {{ $pemeliharaan->tanggal_selesai ? $pemeliharaan->tanggal_selesai->format('d F Y') : '-' }}
                                </div>
                            </div>

                            <!-- Durasi (jika ada kedua tanggal) -->
                            @if($pemeliharaan->tanggal_mulai && $pemeliharaan->tanggal_selesai)
                                <div class="col-md-12 mb-3">
                                    <div class="detail-label">
                                        <i class="bi bi-clock-history text-primary"></i> Durasi Pekerjaan
                                    </div>
                                    <div class="detail-value">
                                        {{ $pemeliharaan->tanggal_mulai->diffInDays($pemeliharaan->tanggal_selesai) }} hari
                                    </div>
                                </div>
                            @endif

                            <!-- Rincian Pekerjaan -->
                            <div class="col-md-12 mb-3">
                                <div class="detail-label">
                                    <i class="bi bi-list-ul text-info"></i> Rincian Pekerjaan
                                </div>
                                <div class="detail-value">
                                    <div class="p-3 bg-light rounded border">
                                        {{ $pemeliharaan->rincian_pekerjaan ?? '-' }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Financial Info -->
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header text-white" style="background-color: #F39200;">
                        <h5 class="mb-0">
                            <i class="bi bi-currency-dollar me-2"></i>Informasi Keuangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                            <!-- Biaya -->
                            <div class="col-md-4 mb-3">
                                <div class="info-box" style="border-left-color: #00AEEF;">
                                    <div class="detail-label">
                                        <i class="bi bi-cash-stack"></i> Biaya Pemeliharaan
                                    </div>
                                    <div class="h4 mb-0" style="color: #00AEEF;">
                                        Rp {{ number_format($pemeliharaan->biaya, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Pagu -->
                            <div class="col-md-4 mb-3">
                                <div class="info-box" style="border-left-color: #77B02A;">
                                    <div class="detail-label">
                                        <i class="bi bi-wallet2"></i> Pagu Anggaran
                                    </div>
                                    <div class="h4 mb-0" style="color: #77B02A;">
                                        Rp {{ number_format($pemeliharaan->pagu, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Sisa Anggaran -->
                            <div class="col-md-4 mb-3">
                                <div class="info-box" style="border-left-color: {{ $pemeliharaan->sisa_anggaran >= 0 ? '#28a745' : '#dc3545' }};">
                                    <div class="detail-label">
                                        <i class="bi bi-piggy-bank"></i> Sisa Anggaran
                                    </div>
                                    <div class="h4 mb-0" style="color: {{ $pemeliharaan->sisa_anggaran >= 0 ? '#28a745' : '#dc3545' }};">
                                        Rp {{ number_format($pemeliharaan->sisa_anggaran, 0, ',', '.') }}
                                    </div>
                                    @if($pemeliharaan->sisa_anggaran < 0)
                                        <small class="text-danger">
                                            <i class="bi bi-exclamation-triangle"></i> Melebihi Pagu
                                        </small>
                                    @else
                                        <small class="text-success">
                                            <i class="bi bi-check-circle"></i> Sesuai Pagu
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Persentase Penggunaan -->
                            <div class="col-md-12">
                                <div class="detail-label mb-2">Persentase Penggunaan Anggaran</div>
                                @php
                                    $persentase = $pemeliharaan->pagu > 0 ? ($pemeliharaan->biaya / $pemeliharaan->pagu) * 100 : 0;
                                    $progressColor = $persentase <= 100 ? 'bg-success' : 'bg-danger';
                                @endphp
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar {{ $progressColor }}" role="progressbar" 
                                         style="width: {{ min($persentase, 100) }}%;" 
                                         aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ number_format($persentase, 1) }}%
                                    </div>
                                </div>
                                @if($persentase > 100)
                                    <small class="text-danger">
                                        <i class="bi bi-exclamation-circle"></i> 
                                        Melebihi {{ number_format($persentase - 100, 1) }}% dari pagu
                                    </small>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="card shadow-sm border-0">
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-plus"></i> 
                                    <strong>Dibuat:</strong> {{ $pemeliharaan->created_at->format('d F Y') }}
                                 </small>
                            </div>
                            @if($pemeliharaan->updated_at != $pemeliharaan->created_at)
                                <div class="col-md-6 text-md-end">
                                    <small class="text-muted">
                                        <i class="bi bi-pencil"></i> 
                                        <strong>Terakhir diupdate:</strong> {{ $pemeliharaan->updated_at->format('d F Y') }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>