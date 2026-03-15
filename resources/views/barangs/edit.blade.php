<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}" class="text-decoration-none">Inventaris</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Barang</li>
            </ol>
        </nav>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-primary">Ubah Informasi Barang / Aset</h6>
                        <a href="{{ route('barangs.index', ['kategori_id' => $barang->kategori_id]) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('barangs.update', $barang->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="kategori_id" value="{{ $barang->kategori_id }}">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nomor Urut Pendaftaran (NUP)</label>
                                <input type="text" name="nup_bmn" 
                                       class="form-control @error('nup_bmn') is-invalid @enderror" 
                                       value="{{ old('nup_bmn', $barang->nup_bmn) }}" 
                                       required>
                                @error('nup_bmn')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Barang</label>
                                <input type="text" name="nama_barang" 
                                       class="form-control @error('nama_barang') is-invalid @enderror" 
                                       value="{{ old('nama_barang', $barang->nama_barang) }}" 
                                       required>
                                @error('nama_barang')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Merk / Tipe</label>
                                <input type="text" name="merk_type" 
                                       class="form-control @error('merk_type') is-invalid @enderror" 
                                       value="{{ old('merk_type', $barang->merk_type) }}">
                                @error('merk_type')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Lokasi Penempatan</label>
                                <input type="text" name="lokasi" 
                                       class="form-control @error('lokasi') is-invalid @enderror" 
                                       value="{{ old('lokasi', $barang->lokasi) }}">
                                @error('lokasi')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Pagu Anggaran (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="number" name="pagu_anggaran" 
                                           class="form-control @error('pagu_anggaran') is-invalid @enderror" 
                                           value="{{ old('pagu_anggaran', $barang->pagu_anggaran) }}" required>
                                </div>
                                @error('pagu_anggaran')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('barangs.index', ['kategori_id' => $barang->kategori_id]) }}" class="btn btn-outline-secondary px-3">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
