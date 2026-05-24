@extends('layouts.admin')

@section('content')
<div class="space-y-6 relative z-0">
    
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl p-8 shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-48 h-48 bg-blue-500 opacity-20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-500 opacity-20 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold mb-2">Halo, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-slate-300 text-lg">Selamat datang di Pusat Kendali Perpustakaan Digital.</p>
                <div class="mt-4 inline-block bg-white/20 backdrop-blur-md px-4 py-2 rounded-lg border border-white/10 text-sm font-medium">
                    Role Anda: <span class="uppercase font-bold text-blue-300">{{ auth()->user()->role }}</span>
                </div>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-sm text-slate-400 font-medium uppercase tracking-wider mb-1">Tanggal Hari Ini</p>
                <p class="text-2xl font-bold text-blue-200">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    @if($peminjaman_menunggu > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
        <div class="flex items-center">
            <div class="text-yellow-500 mr-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-yellow-800 font-bold">Perhatian Admin!</h3>
                <p class="text-yellow-700 text-sm">Ada <span class="font-extrabold">{{ $peminjaman_menunggu }}</span> pengajuan peminjaman buku yang menunggu persetujuan Anda.</p>
            </div>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition">
            Cek Sekarang
        </a>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow group cursor-default">
            <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Buku</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $total_buku }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow group cursor-default">
            <div class="w-14 h-14 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Kategori</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $total_kategori }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow group cursor-default">
            <div class="w-14 h-14 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Peminjam</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $total_peminjam }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow group cursor-default">
            <div class="w-14 h-14 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Petugas Aktif</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $total_petugas }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow group cursor-default">
            <div class="w-14 h-14 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Ulasan Masuk</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $total_ulasan }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow group cursor-default">
            <div class="w-14 h-14 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Menunggu Acc</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $peminjaman_menunggu }}</h3>
            </div>
        </div>

    </div>

</div>
@endsection