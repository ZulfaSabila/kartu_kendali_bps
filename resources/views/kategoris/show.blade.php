<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item small"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item small"><a href="{{ route('kategoris.index') }}" class="text-decoration-none">Kelola Kategori</a></li>
                        <li class="breadcrumb-item small active" aria-current="page">Detail Kategori</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{ $kategori->nama_kategori }}</h1>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
                <a href="{{ route('kategoris.edit', $kategori) }}" class="btn-bps btn-bps-outline">
                    <i class="bi bi-pencil-square"></i> Edit Kategori
                </a>
                <a href="{{ route('pemeliharaans.create') }}?kategori_id={{ $kategori->id }}" class="btn-bps btn-bps-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Pemeliharaan
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Info Kategori -->
    <div class="card-bps p-4 mb-4 border-start border-primary border-5">
        <h5 class="fw-bold text-bps-blue mb-2">Deskripsi Kategori</h5>
        <p class="text-muted mb-0">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</p>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-bps p-4 text-center">
                <div class="text-muted small fw-bold uppercase mb-1">Total Pagu</div>
                <div class="h4 fw-bold text-dark mb-0">Rp {{ number_format($totalPagu, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-bps p-4 text-center">
                <div class="text-muted small fw-bold uppercase mb-1">Total Biaya</div>
                <div class="h4 fw-bold text-bps-orange mb-0">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-bps p-4 text-center">
                <div class="text-muted small fw-bold uppercase mb-1">Sisa Anggaran</div>
                <div class="h4 fw-bold mb-0 {{ $sisaAnggaran >= 0 ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Data Pemeliharaan -->
    <div class="card-bps">
        <div class="bg-light p-4 border-bottom">
            <h5 class="fw-bold mb-0 text-bps-blue"><i class="bi bi-list-ul me-2"></i>Daftar Pemeliharaan dalam Kategori Ini</h5>
        </div>
        <div class="table-responsive table-responsive-bps">
            <table class="table table-bps table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>Tanggal</th>
                        <th>Rincian Pekerjaan</th>
                        <th class="text-end">Biaya (Rp)</th>
                        <th class="text-end">Pagu (Rp)</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemeliharaans as $index => $item)
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $pemeliharaans->firstItem() + $index }}</td>
                            <td>{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                            <td class="small">{{ Str::limit($item->rincian_pekerjaan, 50) }}</td>
                            <td class="text-end fw-bold">{{ number_format($item->biaya, 0, ',', '.') }}</td>
                            <td class="text-end text-muted">{{ number_format($item->pagu, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('pemeliharaans.edit', $item) }}" class="btn btn-sm btn-outline-warning rounded-3 px-2" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pemeliharaans.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2" title="Hapus" onclick="return confirm('Hapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted opacity-25"></i>
                                <h5 class="mt-3 text-muted">Belum ada data pemeliharaan dalam kategori ini.</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pemeliharaans->hasPages())
            <div class="p-4 border-top bg-light">
                <div class="d-flex justify-content-center">
                    {{ $pemeliharaans->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
