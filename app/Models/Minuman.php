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
    ];

    public function kategoriMinuman()
    {
        return $this->belongsTo(KategoriMinuman::class);
    }
}
