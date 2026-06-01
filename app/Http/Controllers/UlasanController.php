<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class UlasanController extends Controller
{
    /**
     * Menampilkan semua ulasan di Dashboard Admin
     */
    public function index()
    {
        // Query builder andalan lu yang sudah pasti tembus
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
     * Fitur Cetak PDF Ulasan (Sudah disamakan query-nya dengan fungsi index agar bebas error)
     */
    public function unduhPdf()
    {
        // Sumpah ini query-nya gw samain persis ketukannya biar variabelnya kebaca sempurna di PDF!
        $ulasan = DB::table('ulasanbuku')
                    ->join('user', 'ulasanbuku.UserID', '=', 'user.UserID')
                    ->join('buku', 'ulasanbuku.BukuID', '=', 'buku.BukuID')
                    ->select('ulasanbuku.*', 'user.NamaLengkap', 'user.Username', 'user.Email', 'buku.Judul')
                    ->orderBy('ulasanbuku.UlasanID', 'desc')
                    ->get();

        // Ambil template surat cetak asli ulasan
        $pdf = Pdf::loadView('admin.ulasan.cetak', compact('ulasan'));
        
        // Atur ukuran kertas A4 Tegak
        $pdf->setPaper('a4', 'portrait');

        // Gaskeun download langsung
        return $pdf->download('laporan-data-ulasan-' . date('Y-m-d') . '.pdf');
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