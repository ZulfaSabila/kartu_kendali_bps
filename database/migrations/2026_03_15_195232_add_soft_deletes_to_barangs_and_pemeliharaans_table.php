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
            $table->softDeletes();
        });

        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->softDeletes();
            
            // Update foreign key to restrict deletion of barang if it has pemeliharaan
            $table->dropForeign(['barang_id']);
            $table->foreign('barang_id')
                  ->references('id')
                  ->on('barangs')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->dropSoftDeletes();
            
            // Revert foreign key to cascade
            $table->dropForeign(['barang_id']);
            $table->foreign('barang_id')
                  ->references('id')
                  ->on('barangs')
                  ->onDelete('cascade');
        });

        Schema::table('barangs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
