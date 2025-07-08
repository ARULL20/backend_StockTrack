<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMakanan extends Model
{
    protected $table = 'kategori_makanan';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
