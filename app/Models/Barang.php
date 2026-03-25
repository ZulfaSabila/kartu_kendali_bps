<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'nup_bmn',
        'nama_barang',
        'merk_type',
        'lokasi',
        'pagu_anggaran',
    ];

    protected $casts = [
        'pagu_anggaran' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke Pemeliharaan (hasMany)
    public function pemeliharaans()
    {
        return $this->hasMany(Pemeliharaan::class);
    }

    /** @deprecated Use withSum('pemeliharaans', 'biaya') in controller for list queries */
    public function getTotalBiayaAttribute()
    {
        return $this->pemeliharaans()->sum('biaya');
    }

    // Helper: Jumlah pemeliharaan
    public function getJumlahPemeliharaanAttribute()
    {
        return $this->pemeliharaans()->count();
    }
}