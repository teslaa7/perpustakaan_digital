<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KategoriController extends Controller
{
    // 1. Lihat Data
    public function index() {
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    // 2. Simpan Data Baru
    public function store(Request $request) {
        $request->validate([
            'NamaKategori' => 'required'
        ]);
        
        Kategori::create($request->all());
        
        return redirect()->back()->with('success', 'Kategori berhasil ditambah!');
    }

    // 3. Update Data Kategori
    public function update(Request $request, $id) {
        $request->validate([
            'NamaKategori' => 'required|max:255'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'NamaKategori' => $request->NamaKategori
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    // 4. Hapus Data Kategori
    public function destroy($id) {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function unduhPdf()
    {
        // Pake all() biar gak error kalau ternyata nama kolom di DB beda
        $kategori = Kategori::all();
        
        // PENTING: Pastikan lu udah bikin file cetak.blade.php 
        // tepat di dalam folder resources/views/admin/kategori/
        $pdf = Pdf::loadView('admin.kategori.cetak', compact('kategori'));
        
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('laporan-kategori-buku-' . date('Y-m-d') . '.pdf');
    }

}