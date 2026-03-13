<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Kategori</li>
                    </ol>
                </nav>
                <h1 class="page-title">Daftar Kategori BMN</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('dashboard') }}" class="btn-bps btn-bps-outline">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Category Table Card -->
    <div class="card-bps">
        <div class="table-responsive table-responsive-bps">
            <table class="table table-bps table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Jumlah Barang</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $index => $kategori)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $kategoris->firstItem() + $index }}</td>
                        <td>
                            <a href="{{ route('barangs.index', ['kategori_id' => $kategori->id]) }}" class="text-decoration-none fw-bold text-bps-blue">
                                {{ $kategori->nama_kategori }}
                            </a>
                        </td>
                        <td>
                            <span class="text-muted small">{{ Str::limit($kategori->deskripsi ?? 'Tidak ada deskripsi.', 80) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge-bps badge-bps-blue">
                                {{ $kategori->barangs_count ?? $kategori->barangs->count() }} Item
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('kategoris.edit', $kategori->id) }}" class="btn btn-sm btn-outline-warning rounded-2 px-2 py-0" title="Edit">
                                    <i class="bi bi-pencil" style="font-size: 0.75rem;"></i>
                                </a>
                                <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 px-2 py-0" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua barang di dalamnya akan ikut terhapus.')">
                                        <i class="bi bi-trash" style="font-size: 0.75rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="bi bi-folder-x fs-2 text-muted opacity-25"></i>
                            <h6 class="mt-2 text-muted">Belum ada data kategori</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kategoris->hasPages())
        <div class="p-3 border-top bg-light text-center">
            <div class="d-flex justify-content-center">
                {{ $kategoris->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
