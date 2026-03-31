# 📋 Kartu Kendali BMN
### Sistem Informasi Kartu Kendali Barang Milik Negara
Badan Pusat Statistik — Kota Bontang

---

### 📖 Tentang Aplikasi
**Kartu Kendali BMN** adalah sistem informasi internal yang dirancang khusus untuk Badan Pusat Statistik (BPS) Kota Bontang guna mempermudah pengelolaan, pelacakan, dan pemeliharaan Barang Milik Negara (BMN). Aplikasi ini menggantikan pencatatan manual dengan sistem digital yang terintegrasi, memastikan setiap aset memiliki riwayat pemeliharaan yang terdokumentasi dengan baik.

**Fitur Utama:**
- ✅ **Dashboard Statistik**: Visualisasi ringkasan total aset, kategori, dan riwayat pemeliharaan terbaru.
- ✅ **Manajemen Kategori**: Pengelompokan aset BMN berdasarkan kategori tertentu (misal: Alat Angkutan, Peralatan Mesin, dll).
- ✅ **Inventaris Barang**: Pencatatan detail aset BMN termasuk Nama Barang, NUP (Nomor Urut Pendaftaran), Merk/Tipe, dan Lokasi.
- ✅ **Riwayat Pemeliharaan**: Pencatatan setiap tindakan perbaikan atau pemeliharaan aset beserta biaya yang dikeluarkan.
- ✅ **Manajemen Anggaran (Pagu)**: Pemantauan sisa anggaran pemeliharaan secara otomatis berdasarkan biaya kumulatif yang digunakan.
- ✅ **Export Laporan**: Cetak riwayat pemeliharaan dalam format **PDF** dan **Excel** untuk kebutuhan pelaporan.
- ✅ **Manajemen Pegawai**: Pengelolaan akun pengguna (Admin & User) dengan kontrol akses yang ketat.
- ✅ **Sistem Arsip (Soft Deletes)**: Fitur untuk memulihkan data barang atau kategori yang tidak sengaja terhapus.

---

### 💻 Persyaratan Sistem
| Komponen | Persyaratan |
| :--- | :--- |
| **PHP** | Versi 8.2 atau lebih tinggi |
| **Database** | MySQL 5.7+ atau MariaDB 10.3+ |
| **Composer** | Versi 2.x |
| **Framework** | Laravel 12.x |
| **Web Server** | Apache / Nginx / LiteSpeed |

---

### 🚀 Cara Instalasi
Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal atau server:

1. **Clone Repositori**
   Dapatkan kode sumber aplikasi:
   ```bash
   git clone [url-repositori-anda]
   cd kartu-kendali-bps
   ```

2. **Konfigurasi Environment**
   Salin file contoh environment dan sesuaikan pengaturannya:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan bagian database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Instalasi Dependensi**
   Jalankan composer untuk mengunduh pustaka yang diperlukan:
   ```bash
   composer install
   ```

4. **Generate App Key**
   Buat kunci keamanan aplikasi:
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeding**
   Buat struktur tabel dan isi data awal:
   ```bash
   php artisan migrate --seed
   ```

6. **Build Aset Frontend**
   Instal dependensi node dan build file CSS/JS:
   ```bash
   npm install
   ```
   *Untuk development:* `npm run dev`  
   *Untuk production:* `npm run build`

7. **Menjalankan Server**
   Gunakan perintah berikut untuk menjalankan server lokal:
   ```bash
   php artisan serve
   ```
   Akses aplikasi di: `http://localhost:8000`

---

### 🔑 Akun Default
Setelah menjalankan perintah `php artisan migrate --seed`, Anda dapat masuk menggunakan akun berikut:

| Role | Email | Password |
| :--- | :--- | :--- |
| Admin | `[admin@bpsbontang.go.id]` | `[BPS@Bontang76]` |
| User | `user@bps.go.id` | `User12345` |

> ⚠️ **PENTING**: Segera ganti password Anda melalui menu **Profil** setelah berhasil login untuk pertama kali guna menjaga keamanan akun.

---

### 📂 Struktur Folder
Berikut adalah struktur folder utama dalam proyek ini:

```text
kartu-kendali-bps/
├── app/                # Logika utama aplikasi (Controllers, Models, Middleware)
│   ├── Http/           # Kontroler rute dan Middleware (AdminMiddleware)
│   ├── Models/         # Definisi struktur data (Barang, Kategori, Pemeliharaan)
│   └── Exports/        # Logika export Excel
├── bootstrap/          # Inisialisasi framework dan cache
├── config/             # Semua file konfigurasi aplikasi
├── database/           # Migrasi tabel, Seeders, dan Factories
├── public/             # DOCUMENT ROOT (Akses publik, file index.php, gambar, CSS/JS terkompilasi)
├── resources/          # File mentah frontend (Blade views, CSS, JS)
├── routes/             # Definisi rute web dan API
├── storage/            # File log, cache, dan unggahan file user
└── tests/              # File pengujian unit dan fitur
```

---

### 🔄 Panduan Update Aplikasi
Jika terdapat pembaruan kode dari repositori, lakukan langkah berikut:

1. **Backup Database**: Selalu lakukan backup database sebelum melakukan update.
2. **Tarik Kode Terbaru**:
   ```bash
   git pull origin main
   ```
3. **Update Dependensi**:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
4. **Migrasi Database (Jika ada perubahan tabel)**:
   ```bash
   php artisan migrate --force
   ```
5. **Bersihkan Cache**:
   ```bash
   php artisan optimize:clear
   ```

---

### 🛠️ Pemecahan Masalah Umum
| Masalah | Kemungkinan Penyebab | Solusi |
| :--- | :--- | :--- |
| **Error 500 (White Screen)** | Folder storage tidak memiliki izin tulis. | Jalankan `chmod -R 775 storage bootstrap/cache` di server Linux. |
| **Data CSS/JS tidak muncul** | Aset belum di-build untuk production. | Jalankan `npm run build` atau periksa rute file di `public/`. |
| **Database Connection Refused** | Konfigurasi `.env` tidak sesuai dengan server. | Periksa `DB_HOST`, `DB_PORT`, dan kredensial database Anda. |
| **The page has expired (419)** | Token CSRF tidak valid atau sesi berakhir. | Segarkan (refresh) halaman atau hapus cache browser. |
| **Class "Maatwebsite\Excel" not found** | Dependensi composer belum terinstal sempurna. | Jalankan ulang `composer install`. |

---

### 📞 Kontak & Lisensi
**Badan Pusat Statistik Kota Bontang**  
📍 Jl. Awang Long No 2, Bontang Baru, Kec. Bontang Utara, Kota Bontang  
📞 Telp: (0548) 26066  
🌐 Homepage: [https://bontangkota.bps.go.id/](https://bontangkota.bps.go.id/)  
📧 Email: bps6474@bps.go.id  

**Lisensi**:  
Aplikasi ini dikembangkan khusus untuk penggunaan internal Badan Pusat Statistik Kota Bontang. Seluruh hak cipta dilindungi. © 2026.
