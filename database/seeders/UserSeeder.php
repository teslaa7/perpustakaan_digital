<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User dipanggil

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bikin Akun Admin
        User::create([
            'NamaLengkap' => 'Admin Utama',
            'Username'    => 'admin_utama',
            'Email'       => 'admin@perpus.com',
            'Password'    => Hash::make('admin123'), // Wajib di-hash
            'Alamat'      => 'Jl. Perpustakaan Pusat No. 1',
            'role'        => 'admin'
        ]);

        // 2. Bikin Akun Petugas
        User::create([
            'NamaLengkap' => 'Petugas',
            'Username'    => 'petugas_01',
            'Email'       => 'petugas_01@perpus.com',
            'Password'    => Hash::make('petugas123'),
            'Alamat'      => 'Jl. Rak Buku No. 2',
            'role'        => 'petugas'
        ]);

    }
}