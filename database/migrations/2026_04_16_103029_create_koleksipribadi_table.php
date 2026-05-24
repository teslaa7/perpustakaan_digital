<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    
    {
        Schema::create('koleksipribadi', function (Blueprint $table) {
            // PK Sesuai spesifikasi: KoleksiID int(11)
            $table->integer('KoleksiID')->autoIncrement(); 
            
            // FK Sesuai spesifikasi: UserID dan BukuID
            $table->integer('UserID');
            $table->integer('BukuID');
            
            // Biarin ini tetep ada, biar fitur ->latest() di UI kita bisa jalan!
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksipribadi');
    }
};
