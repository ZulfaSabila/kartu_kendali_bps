<x-app-layout>
    <x-slot name="header">
        <style>
            .stat-card-modern {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                border: none;
                padding: 14px 18px;
                transition: all 0.2s ease;
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 100%;
                text-decoration: none !important;
            }
            .stat-card-modern:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            }
            .stat-card-modern .card-label {
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: #6b7280;
                font-weight: 700;
            }
            .stat-card-modern .card-value {
                font-size: 22px;
                font-weight: 700;
                color: #1a1a2e;
                margin: 2px 0;
                line-height: 1.2;
            }
            .stat-card-modern .card-subtitle {
                font-size: 11px;
                color: #9ca3af;
            }
            .border-bps-blue { border-left: 4px solid #003366 !important; }
            .border-bps-green { border-left: 4px solid #00A651 !important; }
            .border-bps-orange { border-left: 4px solid #F5A623 !important; }

            @media (max-width: 576px) { 
                .stat-card-modern { 
                    padding: 16px !important; 
                } 
                .stat-card-modern .card-value {
                    font-size: 24px !important;
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
                <a href="{{ route('kategoris.trashed') }}" class="btn-bps btn-bps-outline px-4 py-2 text-decoration-none">
                    <i class="bi bi-archive"></i> Arsip Terhapus
                </a>
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
            <div class="stat-card-modern border-bps-blue">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-grid-fill" style="color: #003366; font-size: 15px;"></i>
                    <span class="card-label">TOTAL KATEGORI</span>
                </div>
                <div class="card-value">{{ $totalKategori }}</div>
                <div class="card-subtitle">Total kategori aktif</div>
            </div>
        </div>

        <!-- Card 2: Kategori Terbanyak -->
        <div class="col-md-4">
            <div class="stat-card-modern border-bps-green">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-stars" style="color: #00A651; font-size: 15px;"></i>
                    <span class="card-label">KATEGORI TERBANYAK</span>
                </div>
                <div class="card-value text-truncate">
                    @if($kategoriTerbanyak)
                        {{ $kategoriTerbanyak->nama_kategori }}
                    @else
                        -
                    @endif
                </div>
                <div class="card-subtitle">
                    @if($kategoriTerbanyak)
                        {{ $kategoriTerbanyak->barangs_count ?? 0 }} item
                    @else
                        Belum ada data
                    @endif
                </div>
            </div>
        </div>

        <!-- Card 3: Kategori Terisi -->
        <div class="col-md-4">
            <div class="stat-card-modern border-bps-orange">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-pie-chart-fill" style="color: #F5A623; font-size: 15px;"></i>
                    <span class="card-label">KATEGORI TERISI</span>
                </div>
                @php
                    $persentaseTerisi = $totalKategori > 0 ? round(($kategoriFilled / $totalKategori) * 100) : 0;
                @endphp
                <div class="card-value">{{ $persentaseTerisi }}%</div>
                <div class="progress mb-2" style="height: 4px; background-color: #f3f4f6;">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ $persentaseTerisi }}%; background-color: #F5A623;" 
                         aria-valuenow="{{ $persentaseTerisi }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-subtitle">
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
