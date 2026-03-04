<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'barang_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'rincian_pekerjaan',
        'biaya',
        'biaya_kumulatif', // Diaktifkan untuk input manual
        'pagu',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'biaya' => 'decimal:2',
        'biaya_kumulatif' => 'decimal:2',
        'pagu' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}