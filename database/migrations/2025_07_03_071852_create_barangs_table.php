<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->decimal('harga', 15, 2)->default(0); // Bisa integer kalau mau
            $table->unsignedBigInteger('kategori_barang_id');
            $table->unsignedBigInteger('gudang_id');
            $table->timestamps();

            $table->foreign('kategori_barang_id')->references('id')->on('kategori_barang')->onDelete('cascade');
            $table->foreign('gudang_id')->references('id')->on('gudangs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
