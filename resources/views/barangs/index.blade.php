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
            @media (max-width: 576px) {
                .asset-card { padding: 12px; }
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
            @media (max-width: 576px) {
                .detail-label { width: 75px; font-size: 0.8rem; }
                .detail-value { font-size: 0.8rem; }
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
                        @if($selectedKategori)
                            <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}" class="text-decoration-none" style="color: #6b7280;">Inventaris Barang</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: #003366; font-weight: 500;">{{ $selectedKategori->nama_kategori }}</li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Inventaris Barang</li>
                        @endif
                    </ol>
                </nav>
                <h1 class="page-title" style="color: #003366;">Inventaris Barang</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('barangs.trashed') }}" class="btn-bps btn-bps-outline px-4 py-2 me-2 text-decoration-none">
                    <i class="bi bi-archive"></i> Arsip Terhapus
                </a>
                <button type="button" class="btn-bps btn-bps-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#addBarangModal">
                    <i class="bi bi-plus-lg"></i> Tambah Barang
                </button>
                @endif
            </div>
        </div>
    </x-slot>

    <!-- Add Barang Modal -->
    <div class="modal fade" id="addBarangModal" tabindex="-1" aria-labelledby="addBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="addBarangModalLabel" style="color: #003366;">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('barangs.store') }}" method="POST">
                    @csrf
                    @if(request('kategori_id'))
                        <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                    @endif
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            @if(!request('kategori_id'))
                            <div class="col-12">
                                <label class="form-label small fw-bold" style="color: #003366;">KATEGORI BMN</label>
                                <select name="kategori_id" class="form-select rounded-2 shadow-none border-light-subtle" required>
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">NUP BMN</label>
                                <input type="text" name="nup_bmn" class="form-control rounded-2 shadow-none border-light-subtle" placeholder="Contoh: 2" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">NAMA BARANG</label>
                                <input type="text" name="nama_barang" class="form-control rounded-2 shadow-none border-light-subtle" placeholder="Contoh: STATION WAGON" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">MERK / TIPE</label>
                                <input type="text" name="merk_type" class="form-control rounded-2 shadow-none border-light-subtle" placeholder="Contoh: TOYOTA INNOVA KT 1338 Q">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">LOKASI PENEMPATAN</label>
                                <input type="text" name="lokasi" class="form-control rounded-2 shadow-none border-light-subtle" placeholder="Contoh: Bontang" value="Bontang">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold" style="color: #003366;">PAGU ANGGARAN (RP)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" style="color: #003366;">Rp</span>
                                    <input type="text" class="form-control rounded-end-2 shadow-none border-light-subtle pagu-mask" placeholder="0" required>
                                    <input type="hidden" name="pagu_anggaran" class="pagu-real" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-bps btn-bps-primary px-4 py-2">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Search Section -->
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
                                <button type="button" class="dropdown-item py-1" data-bs-toggle="modal" data-bs-target="#editBarangModal-{{ $barang->id }}">
                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                </button>
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

        <!-- Edit Barang Modal -->
        <div class="modal fade" id="editBarangModal-{{ $barang->id }}" tabindex="-1" aria-labelledby="editBarangModalLabel-{{ $barang->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="editBarangModalLabel-{{ $barang->id }}" style="color: #003366;">Edit Data Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('barangs.update', $barang->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="kategori_id" value="{{ $barang->kategori_id }}">
                        <div class="modal-body p-4 text-start">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold" style="color: #003366;">NUP BMN</label>
                                    <input type="text" name="nup_bmn" class="form-control rounded-2 shadow-none border-light-subtle" value="{{ $barang->nup_bmn }}" placeholder="Contoh: 2" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold" style="color: #003366;">NAMA BARANG</label>
                                    <input type="text" name="nama_barang" class="form-control rounded-2 shadow-none border-light-subtle" value="{{ $barang->nama_barang }}" placeholder="Contoh: STATION WAGON" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold" style="color: #003366;">MERK / TIPE</label>
                                    <input type="text" name="merk_type" class="form-control rounded-2 shadow-none border-light-subtle" value="{{ $barang->merk_type }}" placeholder="Contoh: TOYOTA INNOVA KT 1338 Q">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold" style="color: #003366;">LOKASI PENEMPATAN</label>
                                    <input type="text" name="lokasi" class="form-control rounded-2 shadow-none border-light-subtle" value="{{ $barang->lokasi }}" placeholder="Contoh: Bontang">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold" style="color: #003366;">PAGU ANGGARAN (RP)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold" style="color: #003366;">Rp</span>
                                        <input type="text" class="form-control rounded-end-2 shadow-none border-light-subtle pagu-mask" value="{{ number_format($barang->pagu_anggaran, 0, ',', '.') }}" placeholder="0" required>
                                        <input type="hidden" name="pagu_anggaran" class="pagu-real" value="{{ $barang->pagu_anggaran }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-bps btn-bps-primary px-4 py-2">Simpan Perubahan</button>
                        </div>
                    </form>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paguMasks = document.querySelectorAll('.pagu-mask');
            
            paguMasks.forEach(mask => {
                const realInput = mask.nextElementSibling;
                
                mask.addEventListener('input', function(e) {
                    let value = this.value.replace(/[^0-9]/g, '');
                    if (value === '') value = '0';
                    
                    realInput.value = value;
                    this.value = new Intl.NumberFormat('id-ID').format(value);
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
