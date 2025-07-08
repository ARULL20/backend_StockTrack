<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama',
        'deskripsi',
        'stok',
        'harga',
        'kategori_barang_id',
        'gudang_id',
    ];

    public function kategoriBarang()
    {
        return $this->belongsTo(KategoriBarang::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}
