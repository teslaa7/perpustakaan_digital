<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // =========================================================
    // KONFIGURASI WAJIB UNTUK DATABASE CUSTOM
    // =========================================================
    
    // 1. Kasih tau Laravel kalau nama tabel kita 'user', bukan 'users'
    protected $table = 'user';

    // 2. Kasih tau Laravel kalau Primary Key kita 'UserID', bukan 'id'
    protected $primaryKey = 'UserID';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'Username',
        'Password',
        'Email',
        'NamaLengkap',
        'Alamat',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'Password', // Ubah 'password' jadi 'Password' (P kapital)
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'Password' => 'hashed', // Ubah 'password' jadi 'Password'
        ];
    }

    // =========================================================
    // CHEAT CODE: BIKIN LARAVEL NGENALIN KOLOM PASSWORD KITA
    // =========================================================
    public function getAuthPassword()
    {
        // Secara default fitur Login Laravel nyari kolom 'password' (kecil semua).
        // Fungsi ini maksa Laravel buat ngecek ke kolom 'Password' (P kapital) milik kita.
        return $this->Password;
    }
}