<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('restrict');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('rincian_pekerjaan')->nullable();
            $table->decimal('biaya', 15, 2)->default(0);
            $table->decimal('biaya_kumulatif', 15, 2)->default(0);
            $table->decimal('pagu', 15, 2)->default(0);
            $table->timestamps();

            $table->index(['user_id', 'barang_id']);
            $table->index('tanggal_mulai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeliharaans');
    }
};