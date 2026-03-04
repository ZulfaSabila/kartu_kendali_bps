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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nup_bmn')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('merk_type')->nullable();
            $table->string('lokasi')->default('Bontang');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['kategori_id', 'user_id']);
            $table->index('nup_bmn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};