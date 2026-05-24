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
        Schema::create('kategoribuku_relasi', function (Blueprint $table) {
            // PK Sesuai spesifikasi: KategoriBukuID int(11)
            $table->integer('KategoriBukuID')->autoIncrement(); 
            
            // Kolom FK (Foreign Key) yang diminta di gambar kerja
            $table->integer('BukuID');
            $table->integer('KategoriID');
            
            // Bawaan Laravel, biarin aja buat tracking kapan relasi ini dibuat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoribuku_relasi');
    }
};
