<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pemeliharaans.index') }}" class="text-decoration-none">Riwayat</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Riwayat</li>
            </ol>
        </nav>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-primary">Ubah Informasi Pemeliharaan</h6>
                        <a href="{{ route('pemeliharaans.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pemeliharaans.update', $pemeliharaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Asset Info (Read Only) -->
                        <div class="card bg-light border-0 rounded-2 p-2 mb-3">
                            <div class="row g-2 text-center">
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem;">NUP BMN</div>
                                    <div class="fw-bold text-primary" style="font-size: 0.75rem;">{{ $pemeliharaan->barang->nup_bmn }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem;">Nama Aset</div>
                                    <div class="fw-bold text-primary" style="font-size: 0.75rem;">{{ $pemeliharaan->barang->nama_barang }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem;">Merk/Type</div>
                                    <div class="fw-bold text-primary" style="font-size: 0.75rem;">{{ $pemeliharaan->barang->merk_type ?? '-' }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem;">Lokasi</div>
                                    <div class="fw-bold text-primary" style="font-size: 0.75rem;">{{ $pemeliharaan->barang->lokasi ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Detail & Budget Section -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $pemeliharaan->tanggal_mulai?->format('Y-m-d')) }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $pemeliharaan->tanggal_selesai?->format('Y-m-d')) }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Rincian Perbaikan / Pemeliharaan</label>
                                <textarea name="rincian_pekerjaan" class="form-control @error('rincian_pekerjaan') is-invalid @enderror" rows="3" required>{{ old('rincian_pekerjaan', $pemeliharaan->rincian_pekerjaan) }}</textarea>
                                @error('rincian_pekerjaan')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Biaya (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="biaya_display" class="form-control" placeholder="0" value="{{ number_format($pemeliharaan->biaya, 0, ',', '.') }}">
                                </div>
                                <input type="hidden" id="biaya" name="biaya" value="{{ $pemeliharaan->biaya }}">
                                @error('biaya')
                                    <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('pemeliharaans.index') }}" class="btn btn-outline-secondary px-3">
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

    <script>
        function setupCurrencyMask(displayId, hiddenId) {
            const display = document.getElementById(displayId);
            const hidden = document.getElementById(hiddenId);
            display.addEventListener('input', function () {
                const raw = this.value.replace(/\D/g, '');
                display.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                hidden.value = raw || 0;
            });
        }
        setupCurrencyMask('biaya_display', 'biaya');
    </script>
</x-app-layout>
