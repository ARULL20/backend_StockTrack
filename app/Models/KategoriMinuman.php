<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMinuman extends Model
{
    protected $table = 'kategori_minuman';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
