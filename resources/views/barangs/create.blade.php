<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}" class="text-decoration-none">Inventaris</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Barang</li>
            </ol>
        </nav>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-primary">Informasi Barang / Aset</h6>
                        <a href="{{ route('barangs.index', ['kategori_id' => $selectedKategori]) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('barangs.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kategori_id" value="{{ $selectedKategori }}">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nomor Urut Pendaftaran (NUP)</label>
                                <input type="text" name="nup_bmn" 
                                       class="form-control @error('nup_bmn') is-invalid @enderror" 
                                       value="{{ old('nup_bmn') }}" 
                                       placeholder="Contoh: 0001" required>
                                @error('nup_bmn')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Barang</label>
                                <input type="text" name="nama_barang" 
                                       class="form-control @error('nama_barang') is-invalid @enderror" 
                                       value="{{ old('nama_barang') }}" 
                                       placeholder="Contoh: Laptop Acer Swift" required>
                                @error('nama_barang')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Merk / Tipe</label>
                                <input type="text" name="merk_type" 
                                       class="form-control @error('merk_type') is-invalid @enderror" 
                                       value="{{ old('merk_type') }}" 
                                       placeholder="Contoh: Core i7 / 16GB RAM">
                                @error('merk_type')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Lokasi Penempatan</label>
                                <input type="text" name="lokasi" 
                                       class="form-control @error('lokasi') is-invalid @enderror" 
                                       value="{{ old('lokasi', 'Bontang') }}">
                                @error('lokasi')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Pagu Anggaran (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="pagu_anggaran_display" 
                                           class="form-control @error('pagu_anggaran') is-invalid @enderror" 
                                           value="{{ old('pagu_anggaran') ? number_format(old('pagu_anggaran'), 0, ',', '.') : '' }}" 
                                           placeholder="0" required>
                                </div>
                                <input type="hidden" name="pagu_anggaran" id="pagu_anggaran" value="{{ old('pagu_anggaran', 0) }}">
                                @error('pagu_anggaran')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('barangs.index', ['kategori_id' => $selectedKategori]) }}" class="btn btn-outline-secondary px-3">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setupCurrencyMask(displayId, hiddenId) {
            const display = document.getElementById(displayId);
            const hidden = document.getElementById(hiddenId);
            
            display.addEventListener('input', function () {
                // Ambil angka saja
                let raw = this.value.replace(/\D/g, '');
                
                // Format ke Rupiah (titik ribuan)
                display.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                
                // Simpan nilai asli ke hidden input untuk dikirim ke database
                hidden.value = raw || 0;
            });
        }

        // Inisialisasi masker untuk pagu anggaran
        setupCurrencyMask('pagu_anggaran_display', 'pagu_anggaran');
    </script>
</x-app-layout>
