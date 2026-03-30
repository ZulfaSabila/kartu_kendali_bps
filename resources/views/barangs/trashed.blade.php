<x-app-layout>
    <x-slot name="header">
        <style>
            .asset-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 20px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                height: 100%;
                display: flex;
                flex-direction: column;
            }
            .asset-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            }
            .asset-header {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 16px;
            }
            .asset-icon {
                width: 40px;
                height: 40px;
                background-color: #fee2e2;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #dc2626;
                font-size: 1.25rem;
                flex-shrink: 0;
            }
            .asset-title-area {
                flex-grow: 1;
                min-width: 0;
            }
            .asset-name {
                font-size: 16px;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 2px;
                text-transform: uppercase;
                line-height: 1.2;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .badge-nup {
                background-color: #f1f5f9;
                color: #64748b;
                font-size: 12px;
                font-weight: 600;
                padding: 2px 8px;
                border-radius: 4px;
                display: inline-block;
            }
            .asset-divider {
                border: 0;
                border-top: 1px solid #e2e8f0;
                margin: 16px 0 0 0;
                padding-top: 12px;
            }
            .asset-actions {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 12px;
            }
        </style>
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6b7280;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}" class="text-decoration-none" style="color: #6b7280;">Inventaris</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Arsip Terhapus</li>
                    </ol>
                </nav>
                <h1 class="page-title" style="color: #003366;"><i class="bi bi-archive me-2"></i>Arsip Terhapus</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('barangs.index') }}" class="btn-bps btn-bps-outline px-4 py-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Inventaris
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
    </div>

    <!-- Search Section -->
    <div class="card-bps p-2 mb-2 mt-2 border-primary border-opacity-10">
        <form action="{{ route('barangs.trashed') }}" method="GET">
            <div class="input-group" style="height: 40px;">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control border-0 shadow-none"
                       style="font-style: italic;"
                       placeholder="Cari arsip terhapus berdasarkan NUP, Nama, atau Merk...">
                <button type="submit" class="btn-bps btn-bps-primary px-4" style="border-radius: 8px !important; height: 40px;">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Trashed Barang Grid -->
    <div class="row g-3">
        @forelse($barangs as $barang)
        <div class="col-xl-4 col-lg-6">
            <div class="asset-card border-primary border-opacity-10">
                <div class="asset-header">
                    <div class="asset-icon" style="background-color: #f0f7ff; color: #003366;">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div class="asset-title-area">
                        <h5 class="asset-name text-muted">{{ $barang->nama_barang }}</h5>
                        <span class="badge-nup">NUP: {{ $barang->nup_bmn ?? '-' }}</span>
                        <div class="small text-muted mt-1" style="font-size: 0.7rem;">
                            Dihapus pada: {{ $barang->deleted_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                <div class="asset-divider"></div>

                <div class="asset-actions mt-3">
                    <form action="{{ route('barangs.restore', $barang->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-bps btn-bps-primary btn-sm px-3 py-2 rounded-3 shadow-none border-0">
                            <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                        </button>
                    </form>

                    <form action="{{ route('barangs.force-delete', $barang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara PERMANEN? Tindakan ini tidak dapat dibatalkan dan seluruh riwayat pemeliharaan akan ikut terhapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2 rounded-3 shadow-none">
                            <i class="bi bi-x-circle"></i> Hapus Permanen
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
                <h5 class="fw-bold text-muted">Tidak ada data di arsip terhapus</h5>
                <p class="text-muted small">Data yang dihapus akan muncul di sini untuk sementara sebelum dihapus permanen.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($barangs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $barangs->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</x-app-layout>