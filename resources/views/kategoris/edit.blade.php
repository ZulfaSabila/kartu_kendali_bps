<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kategoris.index') }}" class="text-decoration-none">Kelola Kategori</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
                    </ol>
                </nav>
                <h1 class="page-title">Edit Kategori</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('kategoris.index') }}" class="btn-bps btn-bps-outline">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card-bps">
                <div class="bg-warning bg-opacity-10 p-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-warning text-dark"><i class="bi bi-pencil-square me-2"></i>Edit Informasi Kategori</h6>
                </div>
                <div class="p-3 p-md-4">
                    <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label text-bps-blue">Nama Kategori</label>
                            <input type="text" name="nama_kategori" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                   required>
                            @error('nama_kategori') 
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-bps-blue">Deskripsi Kategori <span class="text-muted fw-normal">(Opsional)</span></label>
                            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('kategoris.index') }}" class="btn-bps btn-bps-outline px-3">
                                Batal
                            </a>
                            <button type="submit" class="btn-bps btn-bps-primary px-4" style="background-color: var(--bps-orange); border-color: var(--bps-orange);">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
