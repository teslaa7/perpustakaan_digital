<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{
    /**
     * Menampilkan semua ulasan di Dashboard Admin (Menggunakan Query Builder agar pasti tembus)
     */
    public function index()
    {
        // Kita paksa database gabungin tabel ulasanbuku, user, dan buku berdasarkan ID custom lu
        $ulasan = DB::table('ulasanbuku')
                    ->join('user', 'ulasanbuku.UserID', '=', 'user.UserID')
                    ->join('buku', 'ulasanbuku.BukuID', '=', 'buku.BukuID')
                    ->select('ulasanbuku.*', 'user.NamaLengkap', 'user.Username', 'user.Email', 'buku.Judul')
                    ->orderBy('ulasanbuku.UlasanID', 'desc')
                    ->get();

        // Lempar ke halaman admin ulasan
        return view('admin.ulasan.index', compact('ulasan'));
    }

    /**
     * Menghapus ulasan yang tidak pantas
     */
    public function destroy($id)
    {
        // Hapus ulasan berdasarkan UlasanID
        DB::table('ulasanbuku')->where('UlasanID', $id)->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus oleh admin.');
    }
}