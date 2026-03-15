<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama_kategori', 'deskripsi', 'user_id'];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function pemeliharaans()
    {
        return $this->hasManyThrough(Pemeliharaan::class, Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalPaguAttribute()
    {
        return $this->pemeliharaans()->sum('pagu');
    }

    public function getTotalBiayaAttribute()
    {
        return $this->pemeliharaans()->sum('biaya');
    }

    public function getSisaAnggaranAttribute()
    {
        return $this->total_pagu - $this->total_biaya;
    }
}