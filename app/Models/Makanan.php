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
    'gambar', 
];

protected $appends = ['gambar_url'];

public function getGambarUrlAttribute()
{
    return $this->gambar ? asset('storage/' . $this->gambar) : null;
}


    public function kategoriMakanan()
    {
        return $this->belongsTo(KategoriMakanan::class);
    }
}
