<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\KategoribukuRelasi; // 🚨 MANTRA WAJIB BUAT TABEL RELASI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Barryvdh\DomPDF\Facade\Pdf;

class BukuController extends Controller
{
    public function index()
    {
        // Ambil data buku dengan relasinya biar enteng
        $buku = Buku::with('kategori')->latest('BukuID')->get();
        $kategori = KategoriBuku::all(); 
        
        return view('admin.buku.index', compact('buku', 'kategori'));
    }

    // ==========================================
    // FUNGSI BARU: Nampilin Detail Buku
    // ==========================================
    public function show($id)
    {
        // Ambil 1 buku spesifik beserta kategorinya
        $buku = Buku::with('kategori')->findOrFail($id);
        
        // Lempar datanya ke halaman detail pinjam
        return view('peminjam.pinjam_detail', compact('buku'));
    }
    
    // Ubah fungsi cetak lu jadi ini:
    public function unduhPdf()
    {
        $buku = Buku::with('kategori')->orderBy('Judul', 'ASC')->get();
        
        // 1. Siapin view-nya (pakai file cetak.blade.php yang udah kita buat kemaren)
        $pdf = Pdf::loadView('admin.buku.cetak', compact('buku'));
        
        // 2. Set ukuran kertas ke A4 (opsional tapi biar rapi)
        $pdf->setPaper('a4', 'portrait');

        // 3. Langsung unduh filenya
        return $pdf->download('katalog-buku-perpus.pdf');
    }

    // Fungsi untuk mencetak katalog buku
    public function cetak()
    {
        // Ambil semua buku beserta kategorinya
        $buku = Buku::with('kategori')->orderBy('Judul', 'ASC')->get();
        
        // Lempar ke halaman khusus cetak
        return view('admin.buku.cetak', compact('buku'));
    }

    // ==========================================
    // 2. CREATE (Simpan Buku + Stok + Relasi Otomatis)
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required',
            'Penulis' => 'required',
            'Penerbit' => 'required',
            'TahunTerbit' => 'required|numeric',
            'Stok' => 'required|numeric|min:0', // <-- WAJIB: Validasi Stok
            'Cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'KategoriID' => 'required'
        ]);

        // Upload Cover
        $file = $request->file('Cover');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('covers'), $nama_file);

        // Simpan Buku
        $buku = Buku::create([
            'Judul' => $request->Judul,
            'Penulis' => $request->Penulis,
            'Penerbit' => $request->Penerbit,
            'TahunTerbit' => $request->TahunTerbit,
            'Sinopsis' => $request->Sinopsis,
            'Stok' => $request->Stok, // <-- WAJIB: Simpan Stok ke Database
            'Cover' => $nama_file
        ]);

        // Simpan Relasi Kategori
        $buku->kategori()->attach($request->KategoriID);

        return redirect()->back()->with('success', 'Buku baru dan jumlah stok berhasil ditambahkan!');
    }

    // ==========================================
    // 3. UPDATE (Edit Buku + Update Stok)
    // ==========================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'Judul' => 'required',
            'Penulis' => 'required',
            'Penerbit' => 'required',
            'TahunTerbit' => 'required|numeric',
            'Stok' => 'required|numeric|min:0', // <-- WAJIB: Validasi Stok Update
            'KategoriID' => 'required'
        ]);

        $buku = Buku::findOrFail($id);

        if ($request->hasFile('Cover')) {
            // Hapus cover lama jika ada
            if(file_exists(public_path('covers/'.$buku->Cover))) {
                unlink(public_path('covers/'.$buku->Cover));
            }
            // Upload cover baru
            $file = $request->file('Cover');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('covers'), $nama_file);
            $buku->Cover = $nama_file;
        }

        // Update Data Lainnya
        $buku->update([
            'Judul' => $request->Judul,
            'Penulis' => $request->Penulis,
            'Penerbit' => $request->Penerbit,
            'TahunTerbit' => $request->TahunTerbit,
            'Sinopsis' => $request->Sinopsis, 
            'Stok' => $request->Stok, // <-- WAJIB: Update Stok Baru
        ]);

        // Update Kategori (Sync)
        $buku->kategori()->sync($request->KategoriID);

        return redirect()->back()->with('success', 'Data buku dan stok berhasil diperbarui!');
    }

    // ==========================================
    // 4. DELETE (Hapus Buku)
    // ==========================================
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        
        // Hapus gambar cover fisik
        if ($buku->Cover && file_exists(public_path('covers/' . $buku->Cover))) {
            unlink(public_path('covers/' . $buku->Cover));
        }

        // Putus relasi kategori biar gak error
        $buku->kategori()->detach();
        
        // Hapus buku
        $buku->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari katalog!');
    }
}