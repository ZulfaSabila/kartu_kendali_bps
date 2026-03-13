<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}" class="text-decoration-none">Inventaris</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Barang</li>
                    </ol>
                </nav>
                <h1 class="page-title">Tambah Data Barang</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('barangs.index', ['kategori_id' => $selectedKategori]) }}" class="btn-bps btn-bps-outline">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-bps">
                <div class="bg-primary bg-opacity-10 p-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-box-seam me-2"></i>Informasi Barang / Aset</h6>
                </div>
                <div class="p-3 p-md-4">
                    <form action="{{ route('barangs.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kategori_id" value="{{ $selectedKategori }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nomor Urut Pendaftaran (NUP)</label>
                                <input type="text" name="nup_bmn" 
                                       class="form-control @error('nup_bmn') is-invalid @enderror" 
                                       value="{{ old('nup_bmn') }}" 
                                       placeholder="Contoh: 0001" required>
                                @error('nup_bmn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" 
                                       class="form-control @error('nama_barang') is-invalid @enderror" 
                                       value="{{ old('nama_barang') }}" 
                                       placeholder="Contoh: Laptop Acer Swift" required>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Merk / Tipe</label>
                                <input type="text" name="merk_type" 
                                       class="form-control @error('merk_type') is-invalid @enderror" 
                                       value="{{ old('merk_type') }}" 
                                       placeholder="Contoh: Core i7 / 16GB RAM">
                                @error('merk_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Lokasi Penempatan</label>
                                <input type="text" name="lokasi" 
                                       class="form-control @error('lokasi') is-invalid @enderror" 
                                       value="{{ old('lokasi', 'Bontang') }}">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('barangs.index', ['kategori_id' => $selectedKategori]) }}" class="btn-bps btn-bps-outline px-3">
                                Batal
                            </a>
                            <button type="submit" class="btn-bps btn-bps-primary px-4">
                                <i class="bi bi-check-lg"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
