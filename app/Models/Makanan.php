<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'kategori_makanan_id',
    ];

    public function kategoriMakanan()
    {
        return $this->belongsTo(KategoriMakanan::class);
    }
}
