<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6b7280;">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Kelola Kategori</li>
                    </ol>
                </nav>
                <h1 class="page-title" style="color: #003366;">Daftar Kategori BMN</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                @if(auth()->user()->isAdmin())
                <button type="button" class="btn-bps btn-bps-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
                    <i class="bi bi-plus-lg"></i> Tambah Kategori
                </button>
                @endif
                <a href="{{ route('dashboard') }}" class="btn-bps btn-bps-outline ms-2" style="color: #003366; border-color: #003366;">
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
                        @if(auth()->user()->isAdmin())
                        <th class="text-center" style="width: 100px;">Aksi</th>
                        @endif
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
                        @if(auth()->user()->isAdmin())
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-warning rounded-2 px-2 py-0" title="Edit" data-bs-toggle="modal" data-bs-target="#editKategoriModal-{{ $kategori->id }}">
                                    <i class="bi bi-pencil" style="font-size: 0.75rem;"></i>
                                </button>
                                <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 px-2 py-0" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua barang di dalamnya akan ikut terhapus.')">
                                        <i class="bi bi-trash" style="font-size: 0.75rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 5 : 4 }}" class="text-center py-4">
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

    <!-- Modals Section -->
    @if(auth()->user()->isAdmin())
        <!-- Add Kategori Modal -->
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

        <!-- Edit Kategori Modals -->
        @foreach($kategoris as $kategori)
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
                                    <input type="text" name="nama_kategori" class="form-control rounded-2 shadow-none border-light-subtle" value="{{ $kategori->nama_kategori }}" placeholder="Contoh: Alat Angkutan Darat Bermotor" required>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small fw-bold" style="color: #003366;">DESKRIPSI KATEGORI (OPSIONAL)</label>
                                    <textarea name="deskripsi" class="form-control rounded-2 shadow-none border-light-subtle" rows="3" placeholder="Masukkan deskripsi singkat kategori ini...">{{ $kategori->deskripsi }}</textarea>
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
        @endforeach
    @endif
</x-app-layout>
