<x-app-layout>
    <x-slot name="header">
        <style>
            @media (max-width: 576px) { 
                .stat-card .display-4, 
                .stat-card h2, 
                .stat-card .fs-1,
                .stat-card .h5,
                .stat-card .h6 { 
                    font-size: 1.8rem !important; 
                } 
                .stat-card .icon, 
                .stat-card i { 
                    font-size: 1.5rem !important; 
                } 
                .stat-card { 
                    padding: 16px !important; 
                } 
            }
        </style>
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Dashboard</li>
                    </ol>
                </nav>
                <h1 class="page-title">Dashboard Kategori</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0 d-flex justify-content-md-end gap-2">
                @if(auth()->user()->isAdmin())
                <button type="button" class="btn-bps btn-bps-primary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
                    <i class="bi bi-plus-lg"></i> Tambah Kategori
                </button>
                @endif
            </div>
        </div>
    </x-slot>

    <!-- Add Kategori Modal -->
    @if(auth()->user()->isAdmin())
    <div class="modal fade" id="addKategoriModal" tabindex="-1" aria-labelledby="addKategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="addKategoriModalLabel" style="color: #003366;">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kategoris.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold" style="color: #003366;">NAMA KATEGORI</label>
                            <input type="text" name="nama_kategori" class="form-control rounded-2 shadow-none border-light-subtle" placeholder="Contoh: Alat Angkutan Darat Bermotor" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold" style="color: #003366;">DESKRIPSI KATEGORI (OPSIONAL)</label>
                            <textarea name="deskripsi" class="form-control rounded-2 shadow-none border-light-subtle" rows="3" placeholder="Masukkan deskripsi singkat kategori ini..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-bps btn-bps-primary px-4 py-2">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mt-1">
        <!-- Card 1: Total Kategori -->
        <div class="col-md-4">
            <div class="card-bps stat-card p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                        <i class="bi bi-grid-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Kategori</div>
                        <div class="h5 fw-bold mb-0 text-dark">{{ $totalKategori }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Kategori Terbanyak Item -->
        <div class="col-md-4">
            <div class="card-bps stat-card p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success">
                        <i class="bi bi-stars fs-5"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Kategori Terbanyak</div>
                        @if($kategoriTerbanyak)
                            <div class="h6 fw-bold mb-0 text-dark text-truncate">{{ $kategoriTerbanyak->nama_kategori }}</div>
                            <div class="small text-muted" style="font-size: 0.7rem;">{{ $kategoriTerbanyak->barangs_count ?? 0 }} item</div>
                        @else
                            <div class="h6 fw-bold mb-0 text-muted">-</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Kategori Terisi -->
        <div class="col-md-4">
            <div class="card-bps stat-card p-3 h-100">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="rounded-circle bg-info bg-opacity-10 p-2 text-info">
                        <i class="bi bi-pie-chart-fill fs-5"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Kategori Terisi</div>
                        @php
                            $persentaseTerisi = $totalKategori > 0 ? round(($kategoriFilled / $totalKategori) * 100) : 0;
                        @endphp
                        <div class="h5 fw-bold mb-0 text-dark">{{ $persentaseTerisi }}%</div>
                    </div>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $persentaseTerisi }}%" aria-valuenow="{{ $persentaseTerisi }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="small text-muted mt-1" style="font-size: 0.65rem;">
                    {{ $kategoriFilled }} dari {{ $totalKategori }} kategori
                </div>
            </div>
        </div>
    </div>

    <h2 class="h5 fw-bold text-dark mb-2 mt-3">Kategori Barang</h2>

    <!-- Category Grid -->
    <div class="row g-3">
        @forelse($kategoris as $kategori)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card-bps h-100 p-3 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="rounded-2 bg-light p-1 text-primary">
                        <i class="bi bi-archive fs-6"></i>
                    </div>
                    <span class="badge-bps badge-bps-blue">
                        {{ $kategori->barangs_count ?? 0 }} Item
                    </span>
                </div>

                <h6 class="fw-bold text-dark mb-1">{{ $kategori->nama_kategori }}</h6>
                <p class="text-muted small flex-grow-1 mb-2" style="font-size: 0.75rem;">
                    {{ Str::limit($kategori->deskripsi ?? 'Tidak ada deskripsi.', 60) }}
                </p>

                <div class="d-flex gap-2 mt-2 pt-2 border-top">
                    <a href="{{ route('barangs.index', ['kategori_id' => $kategori->id]) }}" 
                       class="btn-bps btn-bps-outline flex-grow-1 justify-content-center py-1" style="font-size: 0.75rem;">
                        <i class="bi bi-folder2-open"></i> Buka
                    </a>
                    
                    @if(auth()->user()->isAdmin())
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-2 px-2 border" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical" style="font-size: 0.8rem;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="font-size: 0.85rem;">
                            <li>
                                <button type="button" class="dropdown-item py-1" data-bs-toggle="modal" data-bs-target="#editKategoriModal-{{ $kategori->id }}">
                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                </button>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dropdown-item py-1 text-danger" 
                                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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

        <!-- Edit Kategori Modal -->
        <div class="modal fade" id="editKategoriModal-{{ $kategori->id }}" tabindex="-1" aria-labelledby="editKategoriModalLabel-{{ $kategori->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="editKategoriModalLabel-{{ $kategori->id }}" style="color: #003366;">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4 text-start">
                            <div class="mb-3">
                                <label class="form-label small fw-bold" style="color: #003366;">NAMA KATEGORI</label>
                                <input type="text" name="nama_kategori" class="form-control rounded-2 shadow-none border-light-subtle" value="{{ $kategori->nama_kategori }}" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold" style="color: #003366;">DESKRIPSI KATEGORI (OPSIONAL)</label>
                                <textarea name="deskripsi" class="form-control rounded-2 shadow-none border-light-subtle" rows="3">{{ $kategori->deskripsi }}</textarea>
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
            <h6 class="mt-2 text-muted">Data kategori tidak ditemukan</h6>
        </div>
        @endforelse
    </div>

    @if($kategoris->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $kategoris->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</x-app-layout>
