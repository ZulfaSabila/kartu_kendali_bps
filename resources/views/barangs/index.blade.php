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
                background-color: #f0f7ff;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #003366;
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
                background-color: #e0e7ff;
                color: #4338ca;
                font-size: 12px;
                font-weight: 600;
                padding: 2px 8px;
                border-radius: 4px;
                display: inline-block;
            }
            .asset-details {
                margin-bottom: 0;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                gap: 4px;
            }
            .detail-row {
                display: flex;
                align-items: center;
                height: 28px;
            }
            .detail-label {
                width: 90px;
                font-size: 12px;
                color: #64748b;
                flex-shrink: 0;
            }
            .detail-value {
                font-size: 13px;
                font-weight: 600;
                color: #1e293b;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
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
                justify-content: space-between;
                gap: 12px;
            }
            .btn-manage-history {
                background-color: #003366;
                color: #ffffff;
                border: none;
                border-radius: 8px;
                padding: 8px 16px;
                font-size: 0.875rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
                transition: background 0.2s;
            }
            .btn-manage-history:hover {
                background-color: #002244;
                color: #ffffff;
            }
            .btn-more {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background-color: #f8fafc;
                border: 1px solid #e2e8f0;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #64748b;
                transition: all 0.2s;
            }
            .btn-more:hover {
                background-color: #f1f5f9;
                color: #1e293b;
            }
        </style>
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6b7280;">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Inventaris Barang</li>
                    </ol>
                </nav>
                <h1 class="page-title" style="color: #003366;">Inventaris Barang</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('barangs.create', ['kategori_id' => request('kategori_id')]) }}" class="btn-bps btn-bps-primary px-4 py-2">
                    <i class="bi bi-plus-lg"></i> Tambah Barang
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <!-- Search Section -->
    <div class="card-bps p-2 mb-2 mt-2">
        <form action="{{ route('barangs.index') }}" method="GET">
            @if(request('kategori_id'))
                <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
            @endif
            <div class="input-group" style="height: 40px;">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control border-0 shadow-none"
                       style="font-style: italic;"
                       placeholder="Cari berdasarkan NUP, Nama Barang, atau Merk...">
                <button type="submit" class="btn-bps btn-bps-primary px-4" style="border-radius: 8px !important; height: 40px;">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('barangs.index', ['kategori_id' => request('kategori_id')]) }}" 
                       class="btn-bps btn-bps-outline d-flex align-items-center justify-content-center ms-2" 
                       style="border-radius: 8px !important; width: 40px; height: 40px; padding: 0;">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Barang Grid -->
    <div class="row g-3">
        @forelse($barangs as $barang)
        <div class="col-xl-4 col-lg-6">
            <div class="asset-card">
                <div class="asset-header">
                    <div class="asset-icon">
                        <i class="bi bi-box"></i>
                    </div>
                    <div class="asset-title-area">
                        <h5 class="asset-name">{{ $barang->nama_barang }}</h5>
                        <span class="badge-nup">NUP: {{ $barang->nup_bmn ?? '-' }}</span>
                    </div>
                </div>

                <div class="asset-details">
                    <div class="detail-row">
                        <span class="detail-label">Merk/Type</span>
                        <span class="detail-value">{{ $barang->merk_type ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Lokasi</span>
                        <span class="detail-value">{{ $barang->lokasi ?? 'Bontang' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Intensitas</span>
                        <span class="detail-value">{{ $barang->pemeliharaans_count ?? 0 }} Riwayat</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Pagu</span>
                        <span class="detail-value text-primary">Rp {{ number_format($barang->pagu_anggaran, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="asset-divider"></div>

                <div class="asset-actions">
                    <a href="{{ route('pemeliharaans.index', ['barang_id' => $barang->id]) }}" class="btn-bps btn-bps-primary px-4 py-2">
                        <i class="bi bi-bar-chart-line"></i> Kelola Riwayat
                    </a>
                    
                    @if(auth()->user()->isAdmin())
                    <div class="dropdown">
                        <button class="btn-more" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="font-size: 0.85rem;">
                            <li>
                                <a class="dropdown-item py-1" href="{{ route('barangs.edit', $barang->id) }}">
                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dropdown-item py-1 text-danger" 
                                            onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                        <i class="bi bi-trash me-2"></i> Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-4">
            <i class="bi bi-inbox fs-2 text-muted opacity-25"></i>
            <h6 class="mt-2 text-muted">Data barang tidak ditemukan</h6>
        </div>
        @endforelse
    </div>

    @if($barangs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $barangs->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</x-app-layout>
