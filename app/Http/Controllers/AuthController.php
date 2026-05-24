<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function index()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        // Catatan: Pastikan di form login.blade.php lu inputannya tetep name="email" dan name="password" huruf kecil
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Arahkan ke dashboard sesuai role
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'petugas') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }

        return back()->with('error', 'Email atau Password salah bro!');
    }

    // Tampilkan Halaman Register
    public function register()
    {
        return view('auth.register');
    }

    // Proses Register (Sign Up Baru)
    public function storeRegister(Request $request)
    {
        // 1. Validasi Inputan (Huruf udah disamain sama form HTML: NamaLengkap, Email, Username, Password)
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Email'       => 'required|email|unique:user,Email', // Pastikan ngecek ke tabel 'users'
            'Username'    => 'required|string|max:255|unique:user,Username',
            'Password'    => 'required|min:6|confirmed' // 'confirmed' otomatis ngecek input 'Password_confirmation'
        ], [
            // Bikin pesan error-nya asik pakai bahasa lu sendiri
            'Email.unique'       => 'Email ini udah dipakai bro, cari yang lain.',
            'Username.unique'    => 'Username ini udah ada yang punya.',
            'Password.confirmed' => 'Konfirmasi password lu beda bro, coba ketik ulang!'
        ]);

        // 2. Simpan ke Database
        // Bagian kiri = nama kolom di database, Bagian kanan = nama inputan dari form
        $user = User::create([
    'NamaLengkap' => $request->NamaLengkap,
    'Username' => $request->Username,
    'Email' => $request->Email,
    'Password' => bcrypt($request->Password),
    'Alamat' => $request->Alamat, // <--- WAJIB TAMBAHIN INI
    'role' => 'peminjam'
]);

        // 3. Lempar kembali ke halaman Login dengan membawa pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan Login.');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}