<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Minuman extends Model
{
    use HasFactory;

    protected $table = 'minuman';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'kategori_minuman_id',
        'gambar',
    ];

    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public function kategoriMinuman()
    {
        return $this->belongsTo(KategoriMinuman::class);
    }
}
