<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // 🚨 INI WAJIB ADA!
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    // ==========================================
    // 1. ZONA READ (Menampilkan Data)
    // ==========================================

    // Tambahin ini di dalam UserController lu
    public function destroyUser($id)
    {
        // Cari user berdasarkan ID
        $user = \App\Models\User::findOrFail($id);
        
        // Hapus akunnya
        $user->delete();

        // Balikin ke halaman tadi dengan pesan sukses
        return back()->with('success', 'Akun member berhasil dihapus permanen!');
    }

    public function index()
    {
        $users = User::where('role', 'peminjam')->latest()->get();
        return view('admin.user.index', compact('users'));
    }

    public function indexPetugas()
    {
        $petugas = User::where('role', 'petugas')->latest()->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    public function indexAdmin()
    {
        $admin = User::where('role', 'admin')->latest()->get();
        return view('admin.admin.index', compact('admin'));
    }


    // ==========================================
    // 2. ZONA CREATE & UPDATE (Manipulasi Data Petugas)
    // ==========================================

    public function storePetugas(Request $request)
    {
        // Validasi ketat biar database gak masuk data sampah
        $request->validate([
            'username' => 'required|unique:user,Username',
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:user,Email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,petugas'
        ]);

        // Simpan ke database dengan mapping kolom custom UKK
        User::create([
            'Username'    => $request->username,
            'NamaLengkap' => $request->nama,
            'Email'       => $request->email,
            'Password'    => Hash::make($request->password), // Password WAJIB di-hash
            'role'        => $request->role,
        ]);

        return back()->with('success', 'Akun petugas baru berhasil dibuat!');
    }

    public function updatePetugas(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi saat update, kecualikan email milik dia sendiri
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:user,Email,'.$id.',UserID',
            'role'  => 'required|in:admin,petugas'
        ]);

        $dataUpdate = [
            'NamaLengkap' => $request->nama,
            'Email'       => $request->email,
            'role'        => $request->role,
        ];

        // Cek kalau input password diisi, berarti dia mau ganti password
        if ($request->filled('password')) {
            $dataUpdate['Password'] = Hash::make($request->password);
        }

        $user->update($dataUpdate);

        return back()->with('success', 'Data petugas berhasil diperbarui!');
    }


    // ==========================================
    // 3. ZONA LAIN-LAIN (Status & Delete)
    // ==========================================

    public function toggleStatus(Request $request, $id)
    {
        // Logika blokir user nanti ditaruh di sini
        return back()->with('success', 'Status berhasil diubah!');
    }
    
    public function destroyPetugas($id)
    {
        $user = User::where('UserID', $id)->firstOrFail();
        
        if($user->role == 'petugas' || $user->role == 'admin') {
            $user->delete();
            return back()->with('success', 'Akun berhasil diberhentikan dari sistem!');
        }

        return back()->with('error', 'Gagal menghapus akun!');
    }

    public function unduhPdf()
    {
        // Ambil data user yang khusus rolenya 'peminjam' (member)
        $users = User::where('role', 'peminjam')->orderBy('NamaLengkap', 'ASC')->get();
        
        // Load ke view cetak khusus user
        $pdf = Pdf::loadView('admin.user.cetak', compact('users'));
        
        // Kertas A4 Portrait cukup buat data member
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('laporan-data-anggota-' . date('Y-m-d') . '.pdf');
    }
}