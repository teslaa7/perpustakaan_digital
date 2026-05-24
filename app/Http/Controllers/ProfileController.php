<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KoleksiPribadi;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage; // Wajib dipanggil buat ngatur file foto

class ProfileController extends Controller
{
    public function index()
    {
        // 1. Ambil data user yang lagi login
        $user = auth()->user();

        // 2. Ambil data koleksi pribadi milik user ini, sekalian bawa data bukunya
        $koleksi = KoleksiPribadi::where('UserID', $user->UserID ?? auth()->id())
                    ->with('buku')
                    ->latest()
                    ->get();

        // 3. Lempar ke tampilan profil
        return view('peminjam.profile', compact('user', 'koleksi'));
    }

    public function update(Request $request)
    {
        // Ambil info user yang lagi login saat ini
        $user = auth()->user();

        // 1. Validasi Inputan (Tambah validasi khusus buat file Foto)
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:user,Username,' . $user->UserID . ',UserID',
            'Email' => 'required|email|max:255|unique:user,Email,' . $user->UserID . ',UserID',
            'Alamat' => 'nullable|string',
            'Password' => 'nullable|min:6|confirmed', 
            'FotoProfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB aja biar server aman
        ]);

        // 2. Cari wujud asli data user ini di Database berdasarkan UserID
        $userData = User::where('UserID', $user->UserID)->first();

        // 3. LOGIKA UPLOAD FOTO PROFIL (JURUS BYPASS XAMPP)
        if ($request->hasFile('FotoProfil')) {
            $file = $request->file('FotoProfil');
            
            // Bikin nama file unik
            $filename = time() . '_' . preg_replace('/\s+/', '_', $userData->Username) . '.' . $file->getClientOriginalExtension();
            
            // BYPASS: Langsung pindahin foto ke folder public/avatars (Bukan ke storage lagi)
            $file->move(public_path('avatars'), $filename);
            
            // Hapus foto yang lama biar memori laptop lu nggak kepenuhan
            if ($userData->FotoProfil && file_exists(public_path('avatars/' . $userData->FotoProfil))) {
                unlink(public_path('avatars/' . $userData->FotoProfil));
            }

            // Simpan nama file barunya ke database
            $userData->FotoProfil = $filename;
        }

        // 4. Timpa data teks lama dengan data baru dari Form
        $userData->NamaLengkap = $request->NamaLengkap;
        $userData->Username = $request->Username;
        $userData->Email = $request->Email;
        $userData->Alamat = $request->Alamat;

        // 5. Logika Keamanan Password
        if ($request->filled('Password')) {
            $userData->Password = Hash::make($request->Password);
        }

        // 6. Eksekusi simpan semua ke Database
        $userData->save();

        // 7. Lempar balik ke halaman profil dengan pesan sukses
        return redirect()->back()->with('success', 'Profil dan foto berhasil diperbarui, bro!');
    }
}