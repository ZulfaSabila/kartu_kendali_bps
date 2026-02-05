<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
{
    use HasFactory;

    protected $table = 'pemeliharaans';

    protected $fillable = [
        'kategori_id',
        'nup_bmn',
        'nama_barang',
        'merk_type',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'rincian_pekerjaan',
        'biaya',
        'pagu',
        'user_id'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'biaya' => 'decimal:2',
        'pagu' => 'decimal:2'
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hitung biaya kumulatif (untuk satu kategori)
    public function getBiayaKumulatifAttribute()
    {
        return self::where('kategori_id', $this->kategori_id)
                   ->where('id', '<=', $this->id)
                   ->sum('biaya');
    }

    // Hitung sisa anggaran per item
    public function getSisaAnggaranAttribute()
    {
        return $this->pagu - $this->biaya;
    }
}