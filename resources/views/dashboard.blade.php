<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">Dashboard Kategori</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('kategoris.create') }}" class="btn-bps btn-bps-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Kategori
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Kategori -->
        <div class="col-md-4">
            <div class="card card-bps shadow-sm rounded h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                            <i class="bi bi-grid-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Kategori</div>
                            <div class="h3 fw-bold mb-0 text-dark">{{ $totalKategori }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Kategori Terbanyak Item -->
        <div class="col-md-4">
            <div class="card card-bps shadow-sm rounded h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
                            <i class="bi bi-stars fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Kategori Terbanyak Item</div>
                            @php
                                $kategoriTerbanyak = $kategoris->sortByDesc('barangs_count')->first();
                            @endphp
                            @if($kategoriTerbanyak)
                                <div class="h5 fw-bold mb-0 text-dark text-truncate" style="max-width: 180px;">{{ $kategoriTerbanyak->nama_kategori }}</div>
                                <div class="small text-muted">{{ $kategoriTerbanyak->barangs_count ?? 0 }} item</div>
                            @else
                                <div class="h5 fw-bold mb-0 text-muted">-</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Kategori Terisi -->
        <div class="col-md-4">
            <div class="card card-bps shadow-sm rounded h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 text-info">
                            <i class="bi bi-pie-chart-fill fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Kategori Terisi</div>
                            @php
                                $kategoriTerisiCount = $kategoris->where('barangs_count', '>', 0)->count();
                                $persentaseTerisi = $totalKategori > 0 ? round(($kategoriTerisiCount / $totalKategori) * 100) : 0;
                            @endphp
                            <div class="h3 fw-bold mb-0 text-dark">{{ $persentaseTerisi }}%</div>
                        </div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $persentaseTerisi }}%" aria-valuenow="{{ $persentaseTerisi }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="small text-muted mt-2" style="font-size: 0.75rem;">
                        {{ $kategoriTerisiCount }} dari {{ $totalKategori }} kategori
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="card-bps p-3 mb-3">
        <form action="{{ route('dashboard') }}" method="GET">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-transparent border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control border-start-0 ps-0 shadow-none"
                       placeholder="Cari kategori (Laptop, Printer, Kendaraan)...">
                <button type="submit" class="btn-bps btn-bps-primary px-3">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center px-2 ms-2 rounded-2">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

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
                    
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-2 px-2 border" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical" style="font-size: 0.8rem;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="font-size: 0.85rem;">
                            <li>
                                <a class="dropdown-item py-1" href="{{ route('kategoris.edit', $kategori->id) }}">
                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                </a>
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
