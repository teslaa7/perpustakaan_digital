<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     * Tanda ...$roles (titik tiga) fungsinya buat nangkep semua role dari web.php jadi bentuk Array
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek dulu, user beneran udah login belum? Kalau belum, tendang ke form login.
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Login dulu bro!');
        }

        // 2. Ambil jabatan (role) dari user yang lagi login
        $userRole = Auth::user()->role;

        // 3. Cocokin! Apakah jabatan user ada di dalam daftar $roles yang diizinkan?
        if (in_array($userRole, $roles)) {
            // Kalau ada, bukakan pintu! Lanjut ke controller.
            return $next($request);
        }

        // 4. Kalau jabatan gak ada di daftar (misal Petugas nyoba masuk halaman Admin), kasih layar merah 403!
        abort(403, 'Akses Ditolak: Halaman ini khusus ' . implode(' atau ', $roles) . ' bro!');
    }
}