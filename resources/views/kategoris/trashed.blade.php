<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6b7280;">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Arsip Kategori Terhapus</li>
                    </ol>
                </nav>
                <h1 class="page-title" style="color: #003366;"><i class="bi bi-archive me-2"></i>Arsip Kategori</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('dashboard') }}" class="btn-bps btn-bps-outline px-4 py-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Status Messages -->
    <div class="mt-2">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Trashed Category Grid -->
    <div class="row g-3 mt-2">
        @forelse($kategoris as $kategori)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card-bps h-100 p-3 d-flex flex-column border-primary border-opacity-10">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="rounded-2 bg-light p-1 text-muted">
                        <i class="bi bi-archive fs-6"></i>
                    </div>
                    <span class="badge-bps badge-bps-blue">
                        {{ $kategori->barangs_count ?? 0 }} Item
                    </span>
                </div>

                <h6 class="fw-bold text-muted mb-1">{{ $kategori->nama_kategori }}</h6>
                <div class="small text-muted mb-2" style="font-size: 0.7rem;">
                    Dihapus pada: {{ $kategori->deleted_at->format('d/m/Y') }}
                </div>

                <div class="d-flex gap-2 mt-auto pt-2 border-top">
                    <form action="{{ route('kategoris.restore', $kategori->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-bps btn-bps-primary w-100 justify-content-center py-1" style="font-size: 0.75rem;">
                            <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                        </button>
                    </form>
                    
                    <form action="{{ route('kategoris.force-delete', $kategori->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Kategori ini secara PERMANEN? Seluruh data yang terkait dengan kategori ini akan hilang selamanya.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-3 px-2 border" title="Hapus Permanen">
                            <i class="bi bi-x-circle" style="font-size: 0.8rem;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card-bps p-5 text-center">
                <div class="mb-3 text-muted">
                    <i class="bi bi-archive" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
                <h5 class="fw-bold text-muted">Tidak ada kategori di arsip terhapus</h5>
                <p class="text-muted small">Kategori yang dihapus akan muncul di sini.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($kategoris->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $kategoris->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</x-app-layout>
