<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 


class PeminjamanController extends Controller
{
    /**
     * KELOLA ADMIN & PETUGAS: Menampilkan daftar semua transaksi peminjaman
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
                                ->latest('TanggalPeminjaman')
                                ->paginate(10);

        return view('admin.peminjaman.index', compact('peminjaman')); 
    }

    /**
     * KELOLA USER: Mengajukan Peminjaman Buku + Pilih Tanggal + Wajib Isi Alamat
     */
    public function store(Request $request, $id)
    {
        // 1. CEK ALAMAT USER (LOGIKA PANTUL)
        $user = Auth::user();
        $alamat = trim($user->Alamat);
        
        // Kalau alamat kosong, kita pantulin lagi ke halaman detail dengan membawa sinyal 'alamat_kosong'
        if (empty($alamat) || $alamat == '-' || $alamat == '') {
            return redirect()->back()->with('alamat_kosong', 'Y');
        }

        // 2. VALIDASI INPUT KALENDER DARI FORM
        $request->validate([
            'BatasWaktu' => 'required|date|after_or_equal:tomorrow'
        ], [
            'BatasWaktu.required' => 'Lu wajib milih tanggal pengembalian bro!',
            'BatasWaktu.after_or_equal' => 'Masa balikin hari ini juga? Minimal besok dong!'
        ]);

        // 3. LOGIKA STOK: Cek stok buku terlebih dahulu. Jika habis, tolak!
        $buku = DB::table('buku')->where('BukuID', $id)->first();
        if (!$buku || $buku->Stok < 1) {
            return redirect()->back()->with('error', 'Maaf bro, stok buku ini lagi kosong/habis!');
        }

        // 4. VALIDASI: Cek apakah user sudah meminjam atau sedang mengajukan buku yang sama
        $cekPinjam = Peminjaman::where('UserID', $user->UserID)
                               ->where('BukuID', $id)
                               ->whereIn('StatusPeminjaman', ['Pending', 'Dipinjam'])
                               ->first();

        if ($cekPinjam) {
            return redirect()->back()->with('error', 'Lu udah mengajukan atau sedang meminjam buku ini bro!');
        }

        // 5. SIMPAN PEMINJAMAN DENGAN KOLOM DENDA & BATAS WAKTU
        $peminjaman = Peminjaman::create([
            'UserID' => $user->UserID,
            'BukuID' => $id,
            'TanggalPeminjaman' => Carbon::now()->toDateString(),
            'TanggalPengembalian' => null, 
            'StatusPeminjaman' => 'Pending',
            'BatasWaktu' => $request->BatasWaktu, 
            'Denda' => 0,
            'StatusDenda' => 'Bebas'
        ]);

        return redirect()->route('peminjaman.detail', $peminjaman->PeminjamanID)
                         ->with('success', 'Permintaan pinjam berhasil dikirim! Tunggu ACC Admin ya.');
    }

    /**
     * KELOLA USER: Nampilin halaman Detail Transaksi
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);
        
        if ($peminjaman->UserID != Auth::id()) {
            return redirect()->route('home')->with('error', 'Lu gak punya akses ke halaman ini!');
        }

        return view('peminjam.pinjam_detail', compact('peminjaman'));
    }

    /**
     * KELOLA ADMIN & PETUGAS: Menyetujui atau mengubah status dari Dashboard Admin
     */
    public function updateStatus(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        if ($request->status == 'Dipinjam') {
            if (!$peminjaman->buku || $peminjaman->buku->Stok < 1) {
                return redirect()->back()->with('error', 'Gagal ACC! Stok buku ini sudah habis dipinjam orang lain.');
            }

            $peminjaman->update([
                'StatusPeminjaman' => 'Dipinjam',
                'TanggalPeminjaman' => Carbon::now()->toDateString(), 
            ]);

            $peminjaman->buku->decrement('Stok');
            return redirect()->back()->with('success', 'Peminjaman berhasil di-ACC! Stok buku otomatis berkurang.');
        }

        if ($request->status == 'Ditolak') {
            $peminjaman->update(['StatusPeminjaman' => 'Ditolak']);
            return redirect()->back()->with('success', 'Permintaan peminjaman telah ditolak.');
        }

        if ($request->status == 'Dikembalikan') {
            $sekarang = Carbon::now()->startOfDay();
            $batas = Carbon::parse($peminjaman->BatasWaktu)->startOfDay();
            $totalDenda = 0;
            $statusDenda = 'Bebas';

            if ($sekarang->gt($batas)) {
                $telatHari = $sekarang->diffInDays($batas);
                $totalDenda = $telatHari * 1000;
                $statusDenda = 'Belum Lunas';
            }

            $peminjaman->update([
                'StatusPeminjaman' => 'Dikembalikan',
                'TanggalPengembalian' => Carbon::now()->toDateString(),
                'Denda' => $totalDenda,
                'StatusDenda' => $statusDenda
            ]);

            if ($peminjaman->buku) {
                $peminjaman->buku->increment('Stok');
            }

            $pesan = 'Buku dikembalikan ke rak perpustakaan. Stok bertambah.';
            if ($totalDenda > 0) {
                $pesan = 'Buku dikembalikan, namun User TELAT ' . $telatHari . ' hari! Denda: Rp ' . number_format($totalDenda, 0, ',', '.');
            }
            return redirect()->back()->with('success', $pesan);
        }

        return redirect()->back();
    }

    /**
     * KELOLA USER: Menampilkan halaman riwayat peminjaman
     */
    public function riwayat()
    {
        $userId = Auth::id();
        $riwayat = Peminjaman::with('buku')
                             ->where('UserID', $userId)
                             ->latest('TanggalPeminjaman')
                             ->get();

        return view('peminjam.riwayat', compact('riwayat'));
    }

    /**
     * KELOLA USER: Mengembalikan buku secara langsung + Hitung Denda Otomatis
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        if ($peminjaman->UserID != Auth::id()) {
            return redirect()->back()->with('error', 'Woi, ini bukan buku pinjaman lu!');
        }

        $sekarang = Carbon::now()->startOfDay();
        $batas = Carbon::parse($peminjaman->BatasWaktu)->startOfDay();
        $totalDenda = 0;
        $statusDenda = 'Bebas';

        if ($sekarang->gt($batas)) {
            $telatHari = $sekarang->diffInDays($batas);
            $totalDenda = $telatHari * 1000;
            $statusDenda = 'Belum Lunas';
        }

        $peminjaman->update([
            'StatusPeminjaman' => 'Dikembalikan',
            'TanggalPengembalian' => Carbon::now()->toDateString(),
            'Denda' => $totalDenda,
            'StatusDenda' => $statusDenda
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('Stok');
        }

        $pesan = 'Buku berhasil dikembalikan! Terima kasih udah membaca.';
        if ($totalDenda > 0) {
            $pesan = 'Buku dikembalikan, tapi lu telat ' . $telatHari . ' hari bro! Cek riwayat untuk tagihan denda Rp ' . number_format($totalDenda, 0, ',', '.');
        }

        return redirect()->back()->with('success', $pesan);
    }

    /**
     * KELOLA USER: Menyimpan ulasan
     */
    public function storeUlasan(Request $request, $bukuId)
    {
        $request->validate(['Rating' => 'required|integer|between:1,5', 'Ulasan' => 'required|string|max:1000']);

        DB::table('ulasanbuku')->insert([
            'UserID'     => Auth::id(),
            'BukuID'     => $bukuId,
            'Ulasan'     => $request->Ulasan,
            'Rating'     => $request->Rating,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('koleksi')->with('success', 'Mantap! Ulasan dan rating lu berhasil disimpan.');    
    }

    /**
     * KELOLA USER: Mencetak Struk
     */
    public function cetakStruk($id)
    {
        $peminjaman = DB::table('peminjaman')
                   ->join('user', 'peminjaman.UserID', '=', 'user.UserID')
                   ->join('buku', 'peminjaman.BukuID', '=', 'buku.BukuID')
                   ->select('peminjaman.*', 'user.NamaLengkap', 'user.Username', 'buku.Judul')
                   ->where('peminjaman.PeminjamanID', $id)
                   ->where('peminjaman.UserID', Auth::id()) 
                   ->first();

        if (!$peminjaman) return redirect()->back()->with('error', 'Data tidak ditemukan!');

        $pdf = Pdf::loadView('peminjam.struk_pdf', compact('peminjaman'))
                  ->setPaper([0, 0, 280, 450], 'portrait');

        return $pdf->download('Struk_Perpus_TRX-00' . $peminjaman->PeminjamanID . '.pdf');
    }

    /**
     * KELOLA ADMIN & PETUGAS: Cetak PDF Seluruh Data Peminjaman
     */
    public function unduhPdf()
    {
        // 1. Ambil semua data peminjaman beserta relasi user & bukunya
        $peminjaman = Peminjaman::with(['user', 'buku'])->latest('TanggalPeminjaman')->get();
        
        // 2. Load ke view cetak khusus admin
        $pdf = Pdf::loadView('admin.peminjaman.cetak', compact('peminjaman'));
        
        // 3. Set kertas jadi A4 Landscape (Mendatar) karena kolomnya banyak
        $pdf->setPaper('a4', 'landscape');
        
        // 4. Download!
        return $pdf->download('laporan-transaksi-peminjaman-' . date('Y-m-d') . '.pdf');
    }
}