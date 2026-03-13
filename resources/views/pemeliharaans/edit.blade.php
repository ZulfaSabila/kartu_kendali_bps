<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pemeliharaans.index') }}" class="text-decoration-none">Riwayat</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Riwayat</li>
                    </ol>
                </nav>
                <h1 class="page-title">Edit Data Pemeliharaan</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('pemeliharaans.index') }}" class="btn-bps btn-bps-outline">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-bps">
                <div class="bg-warning bg-opacity-10 p-3 border-bottom text-dark">
                    <h6 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2"></i>Ubah Informasi Pemeliharaan</h6>
                </div>
                <div class="p-3 p-md-4">
                    <form action="{{ route('pemeliharaans.update', $pemeliharaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Asset Info (Read Only) -->
                        <div class="card bg-light border-0 rounded-2 p-3 mb-4">
                            <div class="row g-2">
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.65rem;">NUP BMN</div>
                                    <div class="fw-bold text-bps-blue" style="font-size: 0.8rem;">{{ $pemeliharaan->barang->nup_bmn }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.65rem;">Nama Aset</div>
                                    <div class="fw-bold text-bps-blue" style="font-size: 0.8rem;">{{ $pemeliharaan->barang->nama_barang }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.65rem;">Merk/Type</div>
                                    <div class="fw-bold text-bps-blue" style="font-size: 0.8rem;">{{ $pemeliharaan->barang->merk_type ?? '-' }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.65rem;">Lokasi</div>
                                    <div class="fw-bold text-bps-blue" style="font-size: 0.8rem;">{{ $pemeliharaan->barang->lokasi ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Detail Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-bps-blue">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $pemeliharaan->tanggal_mulai?->format('Y-m-d')) }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-bps-blue">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $pemeliharaan->tanggal_selesai?->format('Y-m-d')) }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label text-bps-blue">Rincian Perbaikan / Pemeliharaan</label>
                                <textarea name="rincian_pekerjaan" class="form-control @error('rincian_pekerjaan') is-invalid @enderror" rows="3" required>{{ old('rincian_pekerjaan', $pemeliharaan->rincian_pekerjaan) }}</textarea>
                                @error('rincian_pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Budget Section -->
                        <div class="row g-3 pt-3 border-top">
                            <div class="col-md-4">
                                <label class="form-label text-bps-blue">Biaya (Rp)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="biaya_display" class="form-control" placeholder="0" value="{{ number_format($pemeliharaan->biaya, 0, ',', '.') }}">
                                </div>
                                <input type="hidden" id="biaya" name="biaya" value="{{ $pemeliharaan->biaya }}">
                                @error('biaya')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-bps-blue">Biaya Kumulatif (Rp)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="kumulatif_display" class="form-control" placeholder="0" value="{{ number_format($pemeliharaan->biaya_kumulatif, 0, ',', '.') }}">
                                </div>
                                <input type="hidden" id="biaya_kumulatif" name="biaya_kumulatif" value="{{ $pemeliharaan->biaya_kumulatif }}">
                                @error('biaya_kumulatif')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-bps-blue">Pagu Anggaran (Rp)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="pagu_display" class="form-control" placeholder="0" value="{{ number_format($pemeliharaan->pagu, 0, ',', '.') }}">
                                </div>
                                <input type="hidden" id="pagu" name="pagu" value="{{ $pemeliharaan->pagu }}">
                                @error('pagu')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('pemeliharaans.index') }}" class="btn-bps btn-bps-outline px-3">
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
        setupCurrencyMask('pagu_display', 'pagu');
        setupCurrencyMask('biaya_display', 'biaya');
        setupCurrencyMask('kumulatif_display', 'biaya_kumulatif');
    </script>
</x-app-layout>
