<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoribukuRelasi extends Model
{
    // Kunci nama tabel ke tabel relasi
    protected $table = 'kategoribuku_relasi'; 
    
    // Primary key tabel ini
    protected $primaryKey = 'KategoriBukuID'; 
    
    // Matikan timestamps biar gak error
    public $timestamps = false; 

    protected $guarded = []; 
}