<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom.
     */
    public function up(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            // Menambah kolom kategori_id setelah id
            $table->unsignedBigInteger('kategori_id')->nullable()->after('id');
            
            // Menambah kolom pagu setelah kolom biaya
            $table->decimal('pagu', 15, 2)->default(0)->after('biaya');
            
            // Menambah kolom biaya_kumulatif setelah kolom pagu
            $table->decimal('biaya_kumulatif', 15, 2)->default(0)->after('pagu');
            
            // Menambah foreign key constraint
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Batalkan migrasi (rollback).
     */
    public function down(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            // Menghapus foreign key terlebih dahulu
            $table->dropForeign(['kategori_id']);
            
            // Menghapus kembali kolom jika migrasi di-rollback
            $table->dropColumn(['kategori_id', 'pagu', 'biaya_kumulatif']);
        });
    }
};