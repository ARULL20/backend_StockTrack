<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('barang_keluars', function (Blueprint $table) {
        $table->id();
        $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
        $table->integer('jumlah');
        $table->decimal('harga', 15, 2)->default(0);
        $table->string('keterangan')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
