<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Sesuaikan nama tabel database lo
    protected $table = 'peminjaman';
    
    // Primary key custom
    protected $primaryKey = 'PeminjamanID';

    // Kolom yang boleh diisi data
    protected $fillable = [
    'UserID',
    'BukuID',
    'TanggalPeminjaman',
    'TanggalPengembalian',
    'StatusPeminjaman',
    'BatasWaktu',  // <--- TAMBAHIN INI
    'Denda',       // <--- TAMBAHIN INI
    'StatusDenda'  // <--- TAMBAHIN INI
];

    // Relasi: 1 Peminjaman ini milik 1 User
    public function user() {
        // PARAMETER KETIGA UDAH GW GANTI JADI 'UserID' BIAR NGGAK NYASAR!
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    // Relasi: 1 Peminjaman ini minjam 1 Buku
    public function buku() {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }
}