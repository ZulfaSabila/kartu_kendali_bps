<x-app-layout>
    <x-slot name="header">
        <style>
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
                justify-content: flex-end;
                align-items: center;
                gap: 6px;
                font-family: 'Inter', sans-serif;
            }
            .currency-symbol {
                color: #94a3b8;
                font-weight: 500;
                font-size: 0.75rem;
            }
            .currency-value {
                text-align: right;
            }
        </style>
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6b7280;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}" class="text-decoration-none" style="color: #6b7280;">Inventaris</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Riwayat Pemeliharaan</li>
                    </ol>
                </nav>
                <h1 class="page-title" style="color: #003366;">Manajemen Pemeliharaan Barang</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0 d-flex justify-content-md-end gap-2">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('pemeliharaans.create', ['barang_id' => request('barang_id')]) }}" class="btn-bps btn-bps-primary px-4 py-2">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
                <a href="{{ route('pemeliharaans.export.excel', ['barang_id' => request('barang_id'), 'search' => request('search')]) }}" class="btn-bps btn-bps-outline px-4 py-2" style="color: #1d6f42; border-color: #1d6f42;">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('pemeliharaans.export.pdf', ['barang_id' => request('barang_id')]) }}" class="btn-bps btn-bps-outline px-4 py-2">
                    Cetak PDF
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    @if($selectedBarang)
    <!-- Asset Info Horizontal Strip -->
    <div class="card-bps p-3 mb-2 mt-2">
        <div class="row g-0">
            <div class="col-md-2">
                <div class="px-2">
                    <div class="text-muted uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.05em;">NUP BMN</div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $selectedBarang->nup_bmn ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="px-3">
                    <div class="text-muted uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.05em;">NAMA ASET</div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $selectedBarang->nama_barang }}</div>
                </div>
            </div>
            <div class="col-md-4">
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
    <div class="card-bps p-2 mb-2">
        <form action="{{ route('pemeliharaans.index') }}" method="GET">
            <input type="hidden" name="barang_id" value="{{ request('barang_id') }}">
            <div class="input-group" style="height: 40px;">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control border-0 shadow-none"
                       style="font-style: italic;"
                       placeholder="Cari berdasarkan uraian atau kode pemeliharaan...">
                <button type="submit" class="btn-bps btn-bps-primary px-4" style="border-radius: 8px !important; height: 40px;">
                    Cari Riwayat
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('pemeliharaans.index', ['barang_id' => request('barang_id')]) }}" 
                       class="btn-bps btn-bps-outline d-flex align-items-center justify-content-center ms-2" 
                       style="border-radius: 8px !important; width: 40px; height: 40px; padding: 0;">
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
                        <th style="width: 50px;">NO</th>
                        <th>TANGGAL PEKERJAAN</th>
                        <th>RINCIAN PEKERJAAN</th>
                        <th>BIAYA (RP)</th>
                        <th>BIAYA KUMULATIF</th>
                        <th>PAGU</th>
                        <th>SISA ANGGARAN</th>
                        @if(auth()->user()->isAdmin())
                        <th style="width: 120px;">AKSI</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemeliharaans as $index => $item)
                    @php
                        $pagu_anggaran = $item->pagu ?? $item->barang->pagu_anggaran;
                        $sisaAnggaran = $pagu_anggaran - $item->biaya_kumulatif_dinamis;
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
                                <span class="currency-value">{{ number_format($item->biaya_kumulatif_dinamis, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="text-end text-muted">
                            <div class="currency-cell">
                                <span class="currency-symbol">Rp</span>
                                <span class="currency-value">{{ number_format($pagu_anggaran, 0, ',', '.') }}</span>
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
                        @if(auth()->user()->isAdmin())
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
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" class="text-center py-4">
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
