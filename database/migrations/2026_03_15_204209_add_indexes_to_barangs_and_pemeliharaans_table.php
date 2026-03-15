<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->index('nama_barang');
            $table->index('deleted_at');
            $table->index('kategori_id');
        });

        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->index('kategori_id');
            $table->index('deleted_at');
            // 'tanggal_mulai' is already indexed in the initial migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->dropIndex(['kategori_id']);
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('barangs', function (Blueprint $table) {
            $table->dropIndex(['nama_barang']);
            $table->dropIndex(['deleted_at']);
            $table->dropIndex(['kategori_id']);
        });
    }
};
