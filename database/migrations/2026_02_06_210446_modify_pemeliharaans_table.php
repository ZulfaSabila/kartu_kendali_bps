<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Tambah kolom barang_id terlebih dahulu
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->foreignId('barang_id')->nullable()->after('id')->constrained('barangs')->onDelete('cascade');
        });
        
        // Step 2: Migrasi data - buat barang dari pemeliharaan yang ada
        $this->migrateDataToBarangs();
        
        // Step 3: Hapus kolom yang tidak diperlukan
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->dropColumn([
                'kategori_id',
                'nup_bmn',
                'nama_barang',
                'merk_type',
                'lokasi',
                'pagu'
            ]);
        });
        
        // Step 4: Set barang_id menjadi NOT NULL
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->foreignId('barang_id')->nullable(false)->change();
        });
    }

    /**
     * Migrasi data dari pemeliharaans ke barangs
     */
    private function migrateDataToBarangs(): void
    {
        // Ambil unique barang dari pemeliharaans
        $uniqueBarangs = DB::table('pemeliharaans')
            ->select('kategori_id', 'nup_bmn', 'nama_barang', 'merk_type', 'lokasi', 'pagu', 'user_id')
            ->distinct()
            ->get();

        foreach ($uniqueBarangs as $barang) {
            // Cek apakah barang sudah ada
            $existingBarang = DB::table('barangs')
                ->where('kategori_id', $barang->kategori_id)
                ->where('nup_bmn', $barang->nup_bmn)
                ->where('user_id', $barang->user_id)
                ->first();

            if (!$existingBarang) {
                // Insert barang baru
                $barangId = DB::table('barangs')->insertGetId([
                    'kategori_id' => $barang->kategori_id,
                    'nup_bmn' => $barang->nup_bmn,
                    'nama_barang' => $barang->nama_barang,
                    'merk_type' => $barang->merk_type,
                    'lokasi' => $barang->lokasi ?? 'Bontang',
                    'pagu' => $barang->pagu ?? 0,
                    'user_id' => $barang->user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $barangId = $existingBarang->id;
            }

            // Update pemeliharaan dengan barang_id
            DB::table('pemeliharaans')
                ->where('kategori_id', $barang->kategori_id)
                ->where('nup_bmn', $barang->nup_bmn)
                ->where('user_id', $barang->user_id)
                ->update(['barang_id' => $barangId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan struktur lama
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('id');
            $table->string('nup_bmn')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('merk_type')->nullable();
            $table->string('lokasi')->nullable();
            $table->decimal('pagu', 15, 2)->default(0);
        });
        
        // Copy data balik dari barangs ke pemeliharaans
        $pemeliharaans = DB::table('pemeliharaans')->get();
        foreach ($pemeliharaans as $p) {
            if ($p->barang_id) {
                $barang = DB::table('barangs')->find($p->barang_id);
                if ($barang) {
                    DB::table('pemeliharaans')
                        ->where('id', $p->id)
                        ->update([
                            'kategori_id' => $barang->kategori_id,
                            'nup_bmn' => $barang->nup_bmn,
                            'nama_barang' => $barang->nama_barang,
                            'merk_type' => $barang->merk_type,
                            'lokasi' => $barang->lokasi,
                            'pagu' => $barang->pagu,
                        ]);
                }
            }
        }
        
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->dropForeign(['barang_id']);
            $table->dropColumn('barang_id');
        });
    }
};