<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\UlasanBuku;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung semua data dari database
        $total_buku = Buku::count();
        $total_kategori = Kategori::count();
        $total_petugas = User::where('role', 'petugas')->count();
        $total_peminjam = User::where('role', 'peminjam')->count();
        
        // Hitung transaksi yang butuh perhatian admin (Status: Menunggu)
        $peminjaman_menunggu = Peminjaman::where('StatusPeminjaman', 'menunggu')->count();
        
        // Hitung total ulasan masuk
        $total_ulasan = UlasanBuku::count();

        return view('admin.dashboard', compact(
            'total_buku', 
            'total_kategori', 
            'total_petugas', 
            'total_peminjam',
            'peminjaman_menunggu',
            'total_ulasan'
        ));
    }
}