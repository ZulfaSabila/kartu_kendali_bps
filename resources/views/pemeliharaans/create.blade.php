<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pemeliharaans.index') }}" class="text-decoration-none">Riwayat</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Riwayat</li>
                    </ol>
                </nav>
                <h1 class="page-title">Tambah Data Pemeliharaan</h1>
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
                <div class="bg-primary bg-opacity-10 p-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-tools me-2"></i>Form Input Pemeliharaan</h6>
                </div>
                <div class="p-3 p-md-4">
                    <form action="{{ route('pemeliharaans.store') }}" method="POST">
                        @csrf

                        <!-- Asset Selection Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kategori Aset</label>
                                <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategoris as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Barang / NUP</label>
                                <select name="barang_id" id="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required disabled>
                                    <option value="">Pilih kategori dahulu</option>
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div id="asset_info_display" class="card bg-light border-0 rounded-2 p-3" style="display: none;">
                                    <div class="row g-2">
                                        <div class="col-6 col-md-3">
                                            <div class="text-muted small fw-bold uppercase" style="font-size: 0.65rem;">NUP BMN</div>
                                            <div id="info_nup" class="fw-bold text-bps-blue" style="font-size: 0.8rem;">-</div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="text-muted small fw-bold uppercase" style="font-size: 0.65rem;">Nama Aset</div>
                                            <div id="info_nama" class="fw-bold text-bps-blue" style="font-size: 0.8rem;">-</div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="text-muted small fw-bold uppercase" style="font-size: 0.65rem;">Merk/Type</div>
                                            <div id="info_merk" class="fw-bold text-bps-blue" style="font-size: 0.8rem;">-</div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="text-muted small fw-bold uppercase" style="font-size: 0.65rem;">Lokasi</div>
                                            <div id="info_lokasi" class="fw-bold text-bps-blue" style="font-size: 0.8rem;">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Detail Section -->
                        <div class="row g-3 mb-4 pt-3 border-top">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', date('Y-m-d')) }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Rincian Perbaikan / Pemeliharaan</label>
                                <textarea name="rincian_pekerjaan" class="form-control @error('rincian_pekerjaan') is-invalid @enderror" rows="3" placeholder="Jelaskan detail perbaikan yang dilakukan..." required>{{ old('rincian_pekerjaan') }}</textarea>
                                @error('rincian_pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Budget Section -->
                        <div class="row g-3 pt-3 border-top">
                            <div class="col-md-4">
                                <label class="form-label">Biaya (Rp)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="biaya_display" class="form-control" placeholder="0" value="{{ old('biaya') ? number_format(old('biaya'), 0, ',', '.') : '' }}">
                                </div>
                                <input type="hidden" id="biaya" name="biaya" value="{{ old('biaya') }}">
                                @error('biaya')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Biaya Kumulatif (Rp)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="kumulatif_display" class="form-control" placeholder="0" value="{{ old('biaya_kumulatif') ? number_format(old('biaya_kumulatif'), 0, ',', '.') : '' }}">
                                </div>
                                <input type="hidden" id="biaya_kumulatif" name="biaya_kumulatif" value="{{ old('biaya_kumulatif') }}">
                                @error('biaya_kumulatif')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Pagu Anggaran (Rp)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="pagu_display" class="form-control" placeholder="0" value="{{ old('pagu') ? number_format(old('pagu'), 0, ',', '.') : '' }}">
                                </div>
                                <input type="hidden" id="pagu" name="pagu" value="{{ old('pagu') }}">
                                @error('pagu')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('pemeliharaans.index') }}" class="btn-bps btn-bps-outline px-3">
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

    <script>
        const kategoriSelect = document.getElementById('kategori_id');
        const barangSelect = document.getElementById('barang_id');
        const infoDisplay = document.getElementById('asset_info_display');

        kategoriSelect.addEventListener('change', function () {
            const kategoriId = this.value;
            barangSelect.innerHTML = '<option>Loading...</option>';
            barangSelect.disabled = true;
            infoDisplay.style.display = 'none';
            if (!kategoriId) return;

            fetch(`/api/barangs-by-kategori/${kategoriId}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                barangSelect.innerHTML = '<option value="">-- Pilih Barang --</option>';
                data.forEach(barang => {
                    const opt = document.createElement('option');
                    opt.value = barang.id;
                    opt.textContent = `${barang.nup_bmn} - ${barang.nama_barang}`;
                    opt.dataset.nup = barang.nup_bmn || '-';
                    opt.dataset.nama = barang.nama_barang || '-';
                    opt.dataset.merk = barang.merk_type || '-';
                    opt.dataset.lokasi = barang.lokasi || '-';
                    barangSelect.appendChild(opt);
                });
                barangSelect.disabled = false;
            });
        });

        barangSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            if (!selected.value) { infoDisplay.style.display = 'none'; return; }
            document.getElementById('info_nup').innerText = selected.dataset.nup;
            document.getElementById('info_nama').innerText = selected.dataset.nama;
            document.getElementById('info_merk').innerText = selected.dataset.merk;
            document.getElementById('info_lokasi').innerText = selected.dataset.lokasi;
            infoDisplay.style.display = 'block';
        });

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
