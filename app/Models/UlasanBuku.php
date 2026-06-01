<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    use HasFactory;

    // 1. Kasih tau nama tabel aslinya
    protected $table = 'ulasanbuku';

    // 2. Kasih tau Primary Key-nya
    protected $primaryKey = 'UlasanID';

    protected $fillable = [
        'UserID', 
        'BukuID', 
        'Ulasan', 
        'Rating'
    ];

    // =========================================================
    // RELASI YANG UDAH DI-FIX BIAR GAK NYARI 'id'
    // =========================================================
    
    public function user()
    {
        // Format: (NamaModel, 'Foreign Key di ulasanbuku', 'Primary Key di user')
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }

    public function unduhPdf()
    {
        // Ambil data ulasan, join dengan tabel user dan buku kalau manual, 
        // atau pakai relasi ->with() kalau model UlasanBuku lu udah ada relasinya
        // *Asumsi dari view index lu, datanya manggil langsung kolom NamaLengkap, Username, Judul
        // Kalau pakai DB Query Builder (asumsi sesuai data di view index lu):
        $ulasan = \Illuminate\Support\Facades\DB::table('ulasanbuku')
            ->leftJoin('user', 'ulasanbuku.UserID', '=', 'user.UserID')
            ->leftJoin('buku', 'ulasanbuku.BukuID', '=', 'buku.BukuID')
            ->select('ulasanbuku.*', 'user.NamaLengkap', 'user.Username', 'buku.Judul')
            ->orderBy('ulasanbuku.created_at', 'DESC')
            ->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.ulasan.cetak', compact('ulasan'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('laporan-data-ulasan-' . date('Y-m-d') . '.pdf');
    }
}