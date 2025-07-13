<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('makanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2)->default(0);
            $table->unsignedBigInteger('kategori_makanan_id'); 
            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->foreign('kategori_makanan_id')->references('id')->on('kategori_makanan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('makanans');
    }
};
