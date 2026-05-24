<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Pengelola') | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Animasi transisi smooth buat sidebar */
        .sidebar-link { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-link:hover { background-color: #7DA07D; color: white; transform: translateX(6px); }
    </style>
</head>
<body class="flex min-h-screen bg-[#F4F9F4] text-slate-700">

    {{-- SIDEBAR COMPONENT --}}
    <aside class="w-64 bg-white shadow-xl border-r border-[#C8DAC8] flex flex-col z-20">
        
        {{-- Header Logo --}}
        <div class="h-20 flex items-center justify-center border-b border-[#E8F0E8]">
            <h1 class="text-2xl font-black text-[#4A6B4A]">Panel <span class="text-[#7DA07D]">Perpus</span></h1>
        </div>

        {{-- Navigasi Menu --}}
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            
            {{-- MENU BERSAMA (Admin & Petugas) --}}
            <p class="px-4 text-xs font-bold text-[#94B494] uppercase tracking-wider mb-2">Main Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-[#5C805C]">
                🏠 Dashboard
            </a>
            <a href="{{ route('kategori.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-[#5C805C]">
                📁 Kelola Kategori
            </a>
            <a href="{{ route('buku.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-[#5C805C]">
                📚 Kelola Buku
            </a>
            <a href="{{ route('peminjaman.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-[#5C805C]">
                🔄 Peminjaman
            </a>
            <a href="{{ route('laporan.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-[#5C805C]">
                🖨️ Laporan
            </a>

            {{-- MENU RAHASIA (Khusus Admin) --}}
            {{-- Menggunakan IF Blade untuk menyembunyikan menu dari Petugas --}}
            @if(auth()->user()->role === 'admin')
                <div class="pt-6 mt-6 border-t border-[#E8F0E8]"></div>
                <p class="px-4 text-xs font-bold text-red-400 uppercase tracking-wider mb-2">Area Admin</p>
                
                <a href="{{ route('user.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-[#5C805C]">
                    👥 Kelola Peminjam
                </a>
                <a href="{{ route('petugas.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-[#5C805C]">
                    👮 Kelola Petugas
                </a>
                <a href="{{ route('ulasan.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-[#5C805C]">
                    ⭐ Kelola Ulasan
                </a>
            @endif
        </nav>

        {{-- Profil User & Logout --}}
        <div class="p-4 border-t border-[#E8F0E8] bg-white">
            <div class="flex items-center gap-3 mb-4 px-2">
                <div class="w-10 h-10 rounded-full bg-[#E8F0E8] text-[#4A6B4A] flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-[#4A6B4A] truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-bold px-2 py-0.5 rounded bg-[#C8DAC8] text-[#385238] uppercase inline-block mt-0.5">
                        {{ auth()->user()->role }}
                    </p>
                </div>
            </div>
           <form action="{{ route('logout') }}" method="POST" class="inline-block m-0 p-0">
    @csrf <!-- Token keamanan wajib dari Laravel biar gak error 419 -->
    <button type="submit" class="bg-[#85A385] text-white hover:bg-[#6B8E6B] px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-sm transform hover:-translate-y-1">
        Logout
    </button>
</form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        {{-- Header Topbar --}}
        <header class="h-20 bg-white shadow-sm flex items-center px-8 border-b border-[#E8F0E8] sticky top-0 z-10">
            <h2 class="text-xl font-bold text-[#4A6B4A]">@yield('header_title', 'Dashboard')</h2>
        </header>
        
        {{-- Area Konten Dinamis --}}
        <div class="p-8">
            @yield('content')
        </div>
    </main>

</body>
</html>