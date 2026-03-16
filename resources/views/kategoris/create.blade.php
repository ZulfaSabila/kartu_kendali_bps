<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kategoris.index') }}" class="text-decoration-none">Kelola Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
            </ol>
        </nav>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0" style="color: #003366;">Informasi Kategori</h6>
                        <a href="{{ route('kategoris.index') }}" class="btn-bps btn-bps-outline px-3 py-1">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('kategoris.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold" style="color: #003366;">Nama Kategori</label>
                            <input type="text" name="nama_kategori" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   value="{{ old('nama_kategori') }}" 
                                   placeholder="Contoh: Peralatan IT, Kendaraan, Mesin" required>
                            @error('nama_kategori') 
                                <div class="invalid-feedback small">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold" style="color: #003366;">Deskripsi Kategori <span class="text-muted fw-normal">(Opsional)</span></label>
                            <textarea name="deskripsi" class="form-control" rows="3" 
                                      placeholder="Tuliskan keterangan singkat mengenai lingkup kategori ini">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('kategoris.index') }}" class="btn-bps btn-bps-outline px-4 py-2">
                                Batal
                            </a>
                            <button type="submit" class="btn-bps btn-bps-primary px-4 py-2">
                                <i class="bi bi-check-lg"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
