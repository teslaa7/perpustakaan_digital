<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KoleksiPribadi;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KoleksiController extends Controller
{
    /**
     * Menyimpan buku ke dalam koleksi pribadi user.
     */
    public function store($id)
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login

        // 1. Validasi: Cek apakah buku sudah ada di koleksi user ini
        $cek = KoleksiPribadi::where('UserID', $userId)
                             ->where('BukuID', $id)
                             ->first();

        if ($cek) {
            return redirect()->route('profile')->with('success', 'Buku ini sudah ada di koleksi lu, bro!');
        }

        // 2. Simpan data baru ke tabel koleksipribadi
        KoleksiPribadi::create([
            'UserID' => $userId,
            'BukuID' => $id
        ]);

        // 3. Redirect ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Mantap! Buku berhasil ditambahin ke koleksi lu.');
    }

    /**
     * Menghapus buku dari koleksi pribadi user (Tanpa menghapus data buku aslinya).
     */
    public function destroy($id)
    {
        $userId = Auth::id();

        // Cari baris data di tabel koleksipribadi yang sesuai dengan User dan Buku tersebut
        $koleksi = KoleksiPribadi::where('UserID', $userId)
                                 ->where('BukuID', $id)
                                 ->first();

        // Jika datanya ada, maka hapus
        if ($koleksi) {
            $koleksi->delete();
            return redirect()->route('profile')->with('success', 'Buku berhasil dihapus dari koleksi pribadi.');
        }

        return redirect()->route('profile')->with('error', 'Gagal menghapus: Buku tidak ditemukan di koleksi lu.');
    }

    /**
     * Menampilkan halaman Koleksi Umum dan Slider Ulasan
     */
    public function koleksi()
    {
        // 1. Ambil data buku
        $buku = Buku::all(); 

        // 2. KODINGAN ULASAN YANG UDAH DI-FIX
        // Kita join berdasarkan 'user.UserID' dan ngurutin berdasarkan 'UlasanID' yang paling baru
        $ulasan = DB::table('ulasanbuku')
                    ->join('user', 'ulasanbuku.UserID', '=', 'user.UserID')
                    ->select('ulasanbuku.*', 'user.NamaLengkap', 'user.Username', 'user.Email')
                    ->orderBy('ulasanbuku.UlasanID', 'desc')
                    ->get();

        // 3. Lempar ke tampilan
       return view('peminjam.koleksi', compact('buku', 'ulasan'));
    }
}