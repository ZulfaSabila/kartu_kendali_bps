<x-app-layout>
    <x-slot name="header">
        <style>
            .table-bps thead th {
                background-color: #003366 !important;
                color: white !important;
                text-transform: uppercase;
                font-size: 0.7rem !important;
                letter-spacing: 0.05em;
                padding: 12px 10px !important;
                border: none !important;
                text-align: center;
            }
            .table-bps tbody td {
                vertical-align: middle !important;
                font-size: 0.8rem !important;
                padding: 10px !important;
                border-bottom: 1px solid #edf2f7 !important;
            }
            .btn-action-group {
                display: inline-flex;
                border: 1px solid #e2e8f0;
                border-radius: 6px;
                overflow: hidden;
                background: white;
            }
            .btn-act {
                padding: 6px 10px;
                border: none;
                background: transparent;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s;
                text-decoration: none;
            }
            .btn-act:not(:last-child) {
                border-right: 1px solid #e2e8f0;
            }
            .btn-act-view { color: #3182ce; }
            .btn-act-view:hover { background-color: #ebf8ff; }
            .btn-act-edit { color: #d69e2e; }
            .btn-act-edit:hover { background-color: #fefcbf; }
            .btn-act-del { color: #e53e3e; }
            .btn-act-del:hover { background-color: #fff5f5; }
            
            .badge-budget {
                padding: 4px 12px;
                border-radius: 50px;
                font-weight: 700;
                font-size: 0.7rem;
                display: inline-block;
                text-align: center;
                min-width: 100px;
            }
            .badge-budget-success { background-color: #c6f6d5; color: #22543d; }
            .badge-budget-danger { background-color: #fed7d7; color: #822727; }

            /* Currency Alignment */
            .currency-cell {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 4px;
                min-width: 100px;
                font-family: 'Inter', sans-serif; /* Consistent font with body */
            }
            .currency-symbol {
                color: #94a3b8;
                font-weight: 500;
                font-size: 0.75rem;
            }
            .currency-value {
                text-align: right;
                flex-grow: 1;
            }
        </style>
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}" class="text-decoration-none">Inventaris</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Riwayat Pemeliharaan</li>
                    </ol>
                </nav>
                <h1 class="page-title">Manajemen Pemeliharaan Barang</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0 d-flex justify-content-md-end gap-2">
                <a href="{{ route('pemeliharaans.create', ['barang_id' => request('barang_id')]) }}" class="btn-bps btn-bps-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
                <a href="{{ route('pemeliharaans.export.pdf', ['barang_id' => request('barang_id')]) }}" class="btn-bps btn-bps-outline">
                    Cetak PDF
                </a>
            </div>
        </div>
    </x-slot>

    @if($selectedBarang)
    <!-- Asset Info Horizontal Strip -->
    <div class="card-bps p-3 mb-3">
        <div class="row g-0">
            <div class="col-md-2 border-end">
                <div class="px-2">
                    <div class="text-muted uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.05em;">NUP BMN</div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $selectedBarang->nup_bmn ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-3 border-end">
                <div class="px-3">
                    <div class="text-muted uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.05em;">NAMA ASET</div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $selectedBarang->nama_barang }}</div>
                </div>
            </div>
            <div class="col-md-4 border-end">
                <div class="px-3">
                    <div class="text-muted uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.05em;">MERK / TIPE</div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $selectedBarang->merk_type ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="px-3">
                    <div class="text-muted uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.05em;">LOKASI UNIT</div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $selectedBarang->lokasi ?? 'Bontang' }}</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Search Section -->
    <div class="card-bps p-2 mb-3">
        <form action="{{ route('pemeliharaans.index') }}" method="GET">
            <input type="hidden" name="barang_id" value="{{ request('barang_id') }}">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control border-0 shadow-none"
                       placeholder="Cari berdasarkan uraian atau kode pemeliharaan...">
                <button type="submit" class="btn-bps btn-bps-primary px-3 rounded-2">
                    Cari Riwayat
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('pemeliharaans.index', ['barang_id' => request('barang_id')]) }}" class="btn btn-outline-secondary d-flex align-items-center px-2 ms-2 rounded-2">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card-bps">
        <div class="table-responsive">
            <table class="table table-bps table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">NO</th>
                        <th>TANGGAL PEKERJAAN</th>
                        <th>RINCIAN PEKERJAAN</th>
                        <th class="text-end">BIAYA (RP)</th>
                        <th class="text-end">BIAYA KUMULATIF</th>
                        <th class="text-end">PAGU</th>
                        <th class="text-end">SISA ANGGARAN</th>
                        <th class="text-center" style="width: 120px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemeliharaans as $index => $item)
                    @php
                        $sisaAnggaran = $item->pagu - $item->biaya_kumulatif;
                    @endphp
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $pemeliharaans->firstItem() + $index }}</td>
                        <td class="text-center">
                            <div class="fw-bold">{{ $item->tanggal_mulai?->format('d/m/Y') ?? '-' }}</div>
                            <div class="small text-muted" style="font-size: 0.7rem;">s/d {{ $item->tanggal_selesai?->format('d/m/Y') ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="text-dark small">{{ $item->rincian_pekerjaan }}</div>
                        </td>
                        <td class="text-end text-muted">
                            <div class="currency-cell">
                                <span class="currency-symbol">Rp</span>
                                <span class="currency-value">{{ number_format($item->biaya, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="text-end text-muted">
                            <div class="currency-cell">
                                <span class="currency-symbol">Rp</span>
                                <span class="currency-value">{{ number_format($item->biaya_kumulatif, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="text-end text-muted">
                            <div class="currency-cell">
                                <span class="currency-symbol">Rp</span>
                                <span class="currency-value">{{ number_format($item->pagu, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="badge-budget {{ $sisaAnggaran >= 0 ? 'badge-budget-success' : 'badge-budget-danger' }}" style="width: 100%;">
                                <div class="currency-cell" style="min-width: auto;">
                                    <span class="currency-symbol" style="color: inherit;">Rp</span>
                                    <span class="currency-value">{{ number_format($sisaAnggaran, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-action-group">
                                <a href="{{ route('pemeliharaans.edit', $item->id) }}" class="btn-act btn-act-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('pemeliharaans.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-del" title="Hapus" onclick="return confirm('Hapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-journal-x fs-2 text-muted opacity-25"></i>
                            <h6 class="mt-2 text-muted">Belum ada riwayat pemeliharaan</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pemeliharaans->hasPages())
        <div class="p-3 border-top bg-light">
            <div class="d-flex justify-content-center">
                {{ $pemeliharaans->appends(request()->all())->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
