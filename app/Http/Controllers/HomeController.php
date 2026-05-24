<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Narik semua data buku beserta kategorinya
        $buku = Buku::with('kategori')->latest()->get();
        return view('welcome', compact('buku'));
    }

    public function koleksi()
    {
        // Narik semua data buku beserta kategorinya
        $buku = Buku::with('kategori')->latest()->get();
        return view('peminjam.koleksi', compact('buku'));
    }

    public function tentang()
    {
        return view('peminjam.tentang');
    }

    // =========================================================================
    // Halaman Detail Buku
    // =========================================================================
    public function detailBuku($id)
    {
        // KITA PAKAI NAMA RELASI YANG BENAR SESUAI MESIN LU: 'kategori'
        $buku = Buku::with('kategori')->findOrFail($id);
        
        return view('peminjam.detail', compact('buku'));
    }
}