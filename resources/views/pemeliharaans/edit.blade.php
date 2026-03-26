<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6b7280;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pemeliharaans.index') }}" class="text-decoration-none" style="color: #6b7280;">Riwayat</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Edit Riwayat</li>
            </ol>
        </nav>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0" style="color: #003366;">Ubah Informasi Pemeliharaan</h6>
                        <a href="{{ route('pemeliharaans.index') }}" class="btn-bps btn-bps-outline px-3 py-1">
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
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem; color: #003366;">NUP BMN</div>
                                    <div class="fw-bold" style="font-size: 0.75rem; color: #003366;">{{ $pemeliharaan->barang->nup_bmn }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem; color: #003366;">Nama Aset</div>
                                    <div class="fw-bold" style="font-size: 0.75rem; color: #003366;">{{ $pemeliharaan->barang->nama_barang }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem; color: #003366;">Merk/Type</div>
                                    <div class="fw-bold" style="font-size: 0.75rem; color: #003366;">{{ $pemeliharaan->barang->merk_type ?? '-' }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem; color: #003366;">Lokasi</div>
                                    <div class="fw-bold" style="font-size: 0.75rem; color: #003366;">{{ $pemeliharaan->barang->lokasi ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Detail & Budget Section -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $pemeliharaan->tanggal_mulai?->format('Y-m-d')) }}" max="{{ now()->toDateString() }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $pemeliharaan->tanggal_selesai?->format('Y-m-d')) }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold" style="color: #003366;">Rincian Perbaikan / Pemeliharaan</label>
                                <textarea name="rincian_pekerjaan" class="form-control @error('rincian_pekerjaan') is-invalid @enderror" rows="3" required>{{ old('rincian_pekerjaan', $pemeliharaan->rincian_pekerjaan) }}</textarea>
                                @error('rincian_pekerjaan')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Biaya (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" style="color: #003366;">Rp</span>
                                    <input type="text" id="biaya_display" class="form-control" placeholder="0" value="{{ number_format($pemeliharaan->biaya, 0, ',', '.') }}">
                                </div>
                                <input type="hidden" id="biaya" name="biaya" value="{{ $pemeliharaan->biaya }}">
                                @error('biaya')
                                    <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Pagu (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" style="color: #003366;">Rp</span>
                                    <input type="text" id="pagu_display" class="form-control" placeholder="0" value="{{ number_format($pemeliharaan->pagu ?? $pemeliharaan->barang->pagu_anggaran, 0, ',', '.') }}">
                                </div>
                                <input type="hidden" id="pagu" name="pagu" value="{{ $pemeliharaan->pagu ?? $pemeliharaan->barang->pagu_anggaran }}">
                                <small class="text-muted">Pagu dapat disesuaikan per transaksi pemeliharaan.</small>
                                @error('pagu')
                                    <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('pemeliharaans.index') }}" class="btn-bps btn-bps-outline px-4 py-2">
                                Batal
                            </a>
                            <button type="submit" class="btn-bps btn-bps-primary px-4 py-2">
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
            if (!display || !hidden) return;
            display.addEventListener('input', function () {
                const raw = this.value.replace(/\D/g, '');
                display.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                hidden.value = raw || 0;
            });
        }
        setupCurrencyMask('biaya_display', 'biaya');
        setupCurrencyMask('pagu_display', 'pagu');
    </script>
</x-app-layout>
