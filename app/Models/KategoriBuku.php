<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    // Kunci mati nama tabel sesuai di database lu
    protected $table = 'kategoribuku'; 

    // Kunci Primary Key
    protected $primaryKey = 'KategoriID'; 

    // Matikan timestamps karena tabel lu gak punya created_at & updated_at
    public $timestamps = false; 

    // Izinkan semua kolom diisi
    protected $guarded = []; 

    // Jembatan relasi balik ke buku (biar bisa saling panggil)
    public function buku()
    {
        return $this->hasMany(Buku::class, 'KategoriID', 'KategoriID');
    }
}