<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}" class="text-decoration-none">Inventaris</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Barang</li>
                    </ol>
                </nav>
                <h1 class="page-title">Detail Barang</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0 d-flex justify-content-md-end gap-2">
                <a href="{{ route('barangs.index') }}" class="btn btn-outline-secondary btn-sm rounded-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('pemeliharaans.index', ['barang_id' => $barang->id]) }}" class="btn-bps btn-bps-primary">
                    <i class="bi bi-bar-chart-line"></i> Kelola Riwayat ({{ $barang->pemeliharaans_count ?? 0 }})
                </a>
            </div>
        </div>
    </x-slot>

    <div class="card-bps p-4">
        <div class="row">
            <div class="col-md-6 border-end">
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted uppercase mb-1">NUP BMN</label>
                    <div class="h5 fw-bold text-dark">{{ $barang->nup_bmn ?? '-' }}</div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted uppercase mb-1">NAMA BARANG</label>
                    <div class="h5 fw-bold text-dark">{{ $barang->nama_barang }}</div>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-bold text-muted uppercase mb-1">MERK / TIPE</label>
                    <div class="h5 fw-bold text-dark">{{ $barang->merk_type ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-6 ps-md-4">
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted uppercase mb-1">KATEGORI</label>
                    <div class="h5 fw-bold text-primary">{{ $barang->kategori->nama_kategori }}</div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted uppercase mb-1">LOKASI</label>
                    <div class="h5 fw-bold text-dark">{{ $barang->lokasi ?? 'Bontang' }}</div>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-bold text-muted uppercase mb-1">PAGU ANGGARAN</label>
                    <div class="h5 fw-bold text-success">Rp {{ number_format($barang->pagu_anggaran, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
