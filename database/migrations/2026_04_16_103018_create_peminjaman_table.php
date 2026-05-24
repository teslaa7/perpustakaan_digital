<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            // 1. Primary Key sesuai UKK
            $table->id('PeminjamanID');

            // 2. Foreign Keys (WAJIB unsignedBigInteger biar cocok sama PK asalnya)
            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('BukuID');

            // 3. Kolom Tanggal (Sesuai spesifikasi UKK)
            $table->date('TanggalPeminjaman');
            $table->date('TanggalPengembalian')->nullable(); // Kasih nullable karena pas baru minjem kan belum dibalikin

            // 4. Status Peminjaman (Pakai ENUM biar datanya aman)
            $table->enum('StatusPeminjaman', ['menunggu', 'dipinjam', 'dikembalikan', 'ditolak'])->default('menunggu');

            $table->timestamps();

            // 5. IKAT RELASINYA (Foreign Key Constraints)
            $table->foreign('UserID')->references('UserID')->on('user')->onDelete('cascade');
            $table->foreign('BukuID')->references('BukuID')->on('buku')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};