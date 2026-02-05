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
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nup_bmn')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('merk_type')->nullable();
            $table->string('lokasi')->default('Bontang');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('rincian_pekerjaan')->nullable();
            $table->decimal('biaya', 15, 2)->default(0);
            $table->decimal('pagu', 15, 2)->default(0);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeliharaans');
    }
};