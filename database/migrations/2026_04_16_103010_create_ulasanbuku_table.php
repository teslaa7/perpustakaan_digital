<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasanbuku', function (Blueprint $table) {
            // 1. Primary Key sesuai gambar kerja UKK
            $table->id('UlasanID'); 

            // 2. Siapkan kolom untuk Foreign Key (Tipe data WAJIB unsignedBigInteger)
            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('BukuID');

            // 3. Kolom isian ulasan
            $table->text('Ulasan');
            $table->integer('Rating'); // Bintang 1-5
            
            $table->timestamps();

            // 4. IKAT RELASINYA (Foreign Key Constraint)
            // Kasih tau Laravel secara manual kemana kolom ini harus nyambung
            $table->foreign('UserID')->references('UserID')->on('user')->onDelete('cascade');
            $table->foreign('BukuID')->references('BukuID')->on('buku')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasanbuku');
    }
};