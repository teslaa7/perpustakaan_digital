<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Package PDF yang tadi lu install

class LaporanController extends Controller
{
    /**
     * 1. Menampilkan halaman form Generate Laporan
     */
    public function index()
    {
        // Sesuaikan nama folder dan file view lu. 
        // Biasanya kalau ikutin standar lu, ada di 'admin.laporan.index'
        return view('admin.laporan.index'); 
    }

    /**
     * 2. Mengeksekusi cetak PDF berdasarkan tanggal
     */
    public function cetak(Request $request)
    {
        // Ambil inputan tanggal
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        // Query data peminjaman di-join sama tabel user dan buku
        $query = DB::table('peminjaman')
                   ->join('user', 'peminjaman.UserID', '=', 'user.UserID')
                   ->join('buku', 'peminjaman.BukuID', '=', 'buku.BukuID')
                   ->select('peminjaman.*', 'user.NamaLengkap', 'user.Username', 'buku.Judul');

        // Kalau usernya ngisi dua tanggal itu, kita filter datanya
        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('TanggalPeminjaman', [$tgl_awal, $tgl_akhir]);
        }

        $peminjaman = $query->get();

        // Load view HTML untuk di-convert jadi PDF
        // PASTIKAN LU PUNYA FILE: resources/views/admin/laporan/laporan_pdf.blade.php
        $pdf = Pdf::loadView('admin.laporan.laporan_pdf', compact('peminjaman', 'tgl_awal', 'tgl_akhir'));

        // Download otomatis
        return $pdf->download('Laporan_Peminjaman_Perpus.pdf');
    }
}