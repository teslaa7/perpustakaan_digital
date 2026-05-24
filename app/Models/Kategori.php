<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Sesuai nama tabel di database lo
    protected $table = 'kategoribuku'; 

    // Primary Key-nya
    protected $primaryKey = 'KategoriID'; 

    // Kolom yang boleh diisi dari form
    protected $fillable = [
        'NamaKategori'
    ];
}