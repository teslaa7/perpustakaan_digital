<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    use HasFactory;

    // 1. Kasih tau nama tabel aslinya
    protected $table = 'ulasanbuku';

    // 2. Kasih tau Primary Key-nya
    protected $primaryKey = 'UlasanID';

    protected $fillable = [
        'UserID', 
        'BukuID', 
        'Ulasan', 
        'Rating'
    ];

    // =========================================================
    // RELASI YANG UDAH DI-FIX BIAR GAK NYARI 'id'
    // =========================================================
    
    public function user()
    {
        // Format: (NamaModel, 'Foreign Key di ulasanbuku', 'Primary Key di user')
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }
}