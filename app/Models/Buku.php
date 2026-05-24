<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'BukuID';

    // Kolom-kolom yang diizinkan untuk diisi datanya oleh Laravel
    protected $fillable = [
        'Judul', 
        'Penulis', 
        'Penerbit', 
        'TahunTerbit', 
        'Sinopsis', 
        'Stok', // <--- STOK UDAH AMAN DI SINI
        'Cover',
    ];

    // Relasi ke tabel Kategori
    public function kategori()
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategoribuku_relasi', 'BukuID', 'KategoriID');
    }
}