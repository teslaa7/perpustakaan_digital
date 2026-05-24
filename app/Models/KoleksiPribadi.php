<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoleksiPribadi extends Model
{
    use HasFactory;

    protected $table = 'koleksipribadi';
    
    // Kasih tau Laravel kalau Primary Key kita namanya KoleksiID
    protected $primaryKey = 'KoleksiID';

    // Kolom yang diizinkan untuk diisi datanya
    protected $fillable = ['UserID', 'BukuID'];

    // Relasi ke tabel buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }
}