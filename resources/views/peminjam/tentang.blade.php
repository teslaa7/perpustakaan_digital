<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #EEF4EE; overflow-x: hidden; }
        
        /* Wave Background Sesuai Desain */
        .wave-hero {
            background-color: #85A385;
            border-bottom-left-radius: 50% 15%;
            border-bottom-right-radius: 50% 15%;
        }
        
        .soft-shadow { box-shadow: 0 15px 30px -5px rgba(74, 107, 74, 0.15); }
    </style>
</head>
<body class="text-[#4A6B4A] flex flex-col min-h-screen">

    <!-- ================= NAVBAR ================= -->
    <!-- ================= NAVBAR UNIVERSAL ================= -->
    <nav class="w-full pt-6 pb-4 px-8 md:px-16 flex justify-between items-center bg-[#85A385] text-white relative z-50 shadow-sm">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="font-black text-2xl leading-tight text-white hover:text-slate-100 transition-colors">
            Perpus<br><span class="font-medium text-lg">Digital</span>
        </a>
        
        <!-- Menu Tengah (Logika Dinamis Aktif) -->
        <div class="hidden md:flex space-x-10 font-semibold text-sm">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Beranda</a>
            
            <a href="{{ route('koleksi') }}" class="{{ request()->routeIs('koleksi') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Koleksi</a>
            
            <a href="{{ auth()->check() ? route('riwayat.index') : route('login') }}" class="{{ request()->routeIs('riwayat.index') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Riwayat</a>
            
            <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Tentang Kami</a>
            
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Profile</a>
        </div>

       <!-- Tombol Kanan (Bersih, Fokus ke Profil) -->
        <div class="flex items-center gap-4">
            @auth
                <!-- Info Nama User -->
                <div class="hidden md:block text-right mr-2">
                    <p class="text-sm font-bold text-[#4A6B4A]">{{ auth()->user()->NamaLengkap ?? auth()->user()->Username ?? 'Member' }}</p>
                </div>
                
                <!-- Tombol Dinamis: Kalau Admin ke Dashboard, Kalau Peminjam ke Profil -->
                <a href="{{ auth()->user()->role === 'administrator' || auth()->user()->role === 'petugas' ? route('admin.dashboard') : route('profile') }}" 
                   class="bg-[#85A385] text-white hover:bg-[#6B8E6B] px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                    {{ auth()->user()->role === 'peminjam' ? 'Akun Saya' : 'Dashboard' }}
                </a>
            @else
                <!-- Kalau Belum Login -->
                <a href="{{ route('login') }}" class="bg-[#85A385] text-white hover:bg-[#6B8E6B] px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                    Login / Sign in
                </a>
            @endauth
        </div>
    </nav>

    <!-- ================= HERO SECTION DENGAN WAVE ================= -->
    <div class="wave-hero w-full pt-12 pb-24 px-8 md:px-16 text-center text-white relative z-0 shadow-sm" data-aos="fade-down" data-aos-duration="1000">
        <h1 class="text-4xl md:text-5xl font-black mb-4 tracking-wide">About Our Digital Library</h1>
        <p class="text-lg font-medium opacity-90 mb-8">Where knowledge meets convenience. Read anywhere, anytime.</p>
        
        <div class="flex justify-center gap-4">
            <a href="{{ route('koleksi') }}" class="bg-[#6B8E6B] hover:bg-[#4A6B4A] text-white px-8 py-3 rounded-lg font-bold transition-all shadow-md">Jelajahi Buku</a>
            <a href="#" class="bg-white hover:bg-slate-100 text-[#6B8E6B] px-8 py-3 rounded-lg font-bold transition-all shadow-md">Gabung Sekarang</a>
        </div>
    </div>

    <!-- ================= DESKRIPSI SINGKAT ================= -->
    <section class="max-w-3xl mx-auto px-6 py-16 text-center" data-aos="fade-up" data-aos-delay="200">
        <p class="text-[#7DA07D] font-medium leading-relaxed text-sm md:text-base">
            Perpus Digital hadir sebagai solusi modern untuk mempermudah akses literasi di era digital. Kami memahami bahwa kebutuhan membaca dan belajar kini menuntut kecepatan, kemudahan, serta fleksibilitas. Karena itu, Perpus Digital dirancang sebagai platform perpustakaan online yang dapat diakses kapan saja dan di mana saja.
        </p>
    </section>

    <!-- ================= WHY CHOOSE US ================= -->
    <section class="max-w-6xl mx-auto px-6 py-12 text-center w-full">
        <h2 class="text-4xl font-black text-[#6B8E6B] mb-2" data-aos="zoom-in">Why Choose Us?</h2>
        <p class="text-[#7DA07D] font-medium mb-16" data-aos="fade-in" data-aos-delay="200">Explore Millions of Stories, Research and Ideas.</p>
        
        <!-- Grid Fitur (Card Tengah Diangkat) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center px-4 md:px-12">
            
            <!-- Card Kiri -->
            <div class="bg-[#85A385] text-white p-8 rounded-xl soft-shadow transform hover:-translate-y-2 transition-all duration-300 h-64 flex flex-col justify-center items-center" data-aos="fade-right" data-aos-delay="300">
                <!-- SVG Icon Lightning -->
                <svg class="w-16 h-16 mb-4 text-[#EEF4EE]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <h3 class="font-bold text-lg mb-2">Easy & Fast Access</h3>
                <p class="text-xs opacity-90 font-medium">Buka buku kapan saja</p>
            </div>

            <!-- Card Tengah (Lebih besar/tinggi) -->
            <div class="bg-[#6B8E6B] text-white p-10 rounded-xl soft-shadow transform hover:-translate-y-2 transition-all duration-300 md:-translate-y-8 h-72 flex flex-col justify-center items-center z-10 relative" data-aos="fade-up" data-aos-delay="100">
                <!-- SVG Icon Book -->
                <svg class="w-20 h-20 mb-4 text-[#EEF4EE]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <h3 class="font-bold text-xl mb-2">Thousands of Books</h3>
                <p class="text-sm opacity-90 font-medium">Akses banyak koleksi digital</p>
            </div>

            <!-- Card Kanan -->
            <div class="bg-[#85A385] text-white p-8 rounded-xl soft-shadow transform hover:-translate-y-2 transition-all duration-300 h-64 flex flex-col justify-center items-center" data-aos="fade-left" data-aos-delay="300">
                <!-- SVG Icon Heart -->
                <svg class="w-16 h-16 mb-4 text-[#EEF4EE]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <h3 class="font-bold text-lg mb-2 text-center">Comfortable Reading Experience</h3>
                <p class="text-xs opacity-90 font-medium text-center">UI simple dan nyaman</p>
            </div>

        </div>
    </section>

    <!-- ================= VISION & MISSION ================= -->
    <section class="max-w-5xl mx-auto px-6 py-16 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Vision -->
            <div data-aos="fade-up-right" data-aos-duration="1000">
                <h2 class="text-4xl font-black text-[#6B8E6B] mb-6 text-center md:text-left pl-4">Vision</h2>
                <div class="bg-[#85A385] text-white p-10 rounded-2xl soft-shadow h-64 flex items-center justify-center">
                    <p class="font-medium text-center leading-relaxed">
                        Menjadi perpustakaan digital modern yang dekat dengan generasi sekarang.
                    </p>
                </div>
            </div>

            <!-- Mission -->
            <div data-aos="fade-up-left" data-aos-duration="1000">
                <h2 class="text-4xl font-black text-[#6B8E6B] mb-6 text-center md:text-left pl-4">Mision</h2>
                <div class="bg-[#85A385] text-white p-10 rounded-2xl soft-shadow h-64 flex flex-col justify-center space-y-4">
                    <p class="font-medium flex items-start gap-3">
                        <span class="font-black text-xl">1.</span> Mempermudah akses literasi.
                    </p>
                    <p class="font-medium flex items-start gap-3">
                        <span class="font-black text-xl">2.</span> Menyediakan pengalaman membaca terbaik.
                    </p>
                    <p class="font-medium flex items-start gap-3">
                        <span class="font-black text-xl">3.</span> Menumbuhkan budaya membaca.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- ================= STATISTIK TEKS ================= -->
    <section class="max-w-5xl mx-auto px-6 py-12 w-full flex justify-between items-center text-center flex-wrap gap-8" data-aos="zoom-in" data-aos-delay="200">
        <div class="flex-1 min-w-[120px]">
            <h3 class="text-4xl md:text-5xl font-black text-[#85A385] mb-2">25k+</h3>
            <p class="text-sm font-bold text-slate-500 tracking-widest uppercase">Books</p>
        </div>
        <div class="flex-1 min-w-[120px]">
            <h3 class="text-4xl md:text-5xl font-black text-[#85A385] mb-2">8k+</h3>
            <p class="text-sm font-bold text-slate-500 tracking-widest uppercase">Readers</p>
        </div>
        <div class="flex-1 min-w-[120px]">
            <h3 class="text-4xl md:text-5xl font-black text-[#85A385] mb-2">24/7</h3>
            <p class="text-sm font-bold text-slate-500 tracking-widest uppercase">Access</p>
        </div>
        <div class="flex-1 min-w-[120px]">
            <h3 class="text-4xl md:text-5xl font-black text-[#85A385] mb-2">100%</h3>
            <p class="text-sm font-bold text-slate-500 tracking-widest uppercase">Digital</p>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-[#85A385] text-white pt-16 pb-6 px-8 md:px-16 mt-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 items-center mb-10">
            <div class="font-black text-3xl leading-tight text-white">
                Perpus<br><span class="font-medium text-xl">Digital</span>
            </div>
            <div class="flex gap-10 text-sm font-semibold justify-center md:justify-start">
                <div class="flex flex-col gap-3">
                    <a href="{{ route('home') }}" class="hover:text-slate-200 hover:translate-x-1 transition-transform">Beranda</a>
                    <a href="{{ route('koleksi') }}" class="hover:text-slate-200 hover:translate-x-1 transition-transform">Koleksi</a>
                </div>
                <div class="flex flex-col gap-3">
                    <a href="#" class="hover:text-slate-200 hover:translate-x-1 transition-transform">Profile</a>
                    <a href="{{ auth()->check() ? route('riwayat.index') : route('login') }}" class="hover:text-slate-200 hover:translate-x-1 transition-transform">Riwayat</a>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-100 font-medium mb-4 max-w-xs ml-auto">
                    Empowering readers and academic minds in knowledge, body, and academic resource.
                </p>
                <div class="flex justify-end gap-3">
                    <div class="w-8 h-8 rounded bg-[#5C805C] flex items-center justify-center hover:bg-[#4A6B4A] hover:-translate-y-1 cursor-pointer transition-all">🎵</div>
                    <div class="w-8 h-8 rounded bg-[#5C805C] flex items-center justify-center hover:bg-[#4A6B4A] hover:-translate-y-1 cursor-pointer transition-all">💬</div>
                    <div class="w-8 h-8 rounded bg-[#5C805C] flex items-center justify-center hover:bg-[#4A6B4A] hover:-translate-y-1 cursor-pointer transition-all">📷</div>
                    <div class="w-8 h-8 rounded bg-[#5C805C] flex items-center justify-center hover:bg-[#4A6B4A] hover:-translate-y-1 cursor-pointer transition-all">✉️</div>
                </div>
            </div>
        </div>
        <div class="text-center text-xs font-medium text-[#5C805C] pt-6 border-t border-[#6B8E6B]">
            © {{ date('Y') }} PerpusDigital All rights reserved.
        </div>
    </footer>

    <!-- Script Animasi AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 80 });
    </script>
</body>
</html>