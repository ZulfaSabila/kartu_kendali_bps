<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'user_id'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Pemeliharaan
    public function pemeliharaans()
    {
        return $this->hasMany(Pemeliharaan::class);
    }

    // Hitung total biaya per kategori
    public function getTotalBiayaAttribute()
    {
        return $this->pemeliharaans()->sum('biaya');
    }

    // Hitung total pagu per kategori
    public function getTotalPaguAttribute()
    {
        return $this->pemeliharaans()->sum('pagu');
    }

    // Hitung sisa anggaran
    public function getSisaAnggaranAttribute()
    {
        return $this->total_pagu - $this->total_biaya;
    }
}