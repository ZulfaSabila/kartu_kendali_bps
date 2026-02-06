<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            // Menambahkan kolom biaya_kumulatif setelah kolom biaya
            // Menggunakan decimal agar mendukung nominal besar dan presisi (seperti kolom biaya Anda)
            $table->decimal('biaya_kumulatif', 15, 2)->default(0)->after('biaya');
        });
    }

    public function down(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->dropColumn('biaya_kumulatif');
        });
    }
};