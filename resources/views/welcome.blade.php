<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpus Digital | Grows Quietly Where Knowledge</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #EEF4EE; overflow-x: hidden; }
        .soft-shadow { box-shadow: 0 20px 40px -15px rgba(74, 107, 74, 0.15); }
        
        /* Animasi Melayang Kustom buat Buku di Laptop */
        @keyframes float-left {
            0%, 100% { transform: translateY(0px) rotate(-6deg); }
            50% { transform: translateY(-10px) rotate(-8deg); }
        }
        @keyframes float-center {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        @keyframes float-right {
            0%, 100% { transform: translateY(0px) rotate(6deg); }
            50% { transform: translateY(-10px) rotate(8deg); }
        }
        .float-1 { animation: float-left 3.5s ease-in-out infinite; }
        .float-2 { animation: float-center 3s ease-in-out infinite 1s; }
        .float-3 { animation: float-right 4s ease-in-out infinite 0.5s; }
    </style>
</head>
<body class="text-[#4A6B4A]">

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

    <main class="max-w-7xl mx-auto px-8 md:px-16 pt-12 md:pt-20 pb-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        
        <div class="z-10" data-aos="fade-right" data-aos-duration="1000">
            <h1 class="text-5xl md:text-6xl font-black text-[#5C805C] leading-[1.1] mb-6">
                Grows Quietly <br> Where Knowledge
            </h1>
            <p class="text-[#7DA07D] font-medium text-lg mb-10 max-w-md">
                Designed for readers, thinkers, and academic minds.
            </p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('koleksi') }}" class="bg-[#6B8E6B] hover:bg-[#4A6B4A] text-white px-8 py-3 rounded-lg font-bold transition-all shadow-md">
                    Lihat Koleksi
                </a>
                <a href="{{ route('riwayat.index') }}" class="bg-[#85A385] hover:bg-[#6B8E6B] text-white px-8 py-3 rounded-lg font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    Start Reading
                </a>
            </div>
        </div>

        <div class="relative flex flex-col items-center" data-aos="fade-left" data-aos-duration="1200">
            <div class="w-full max-w-[450px] relative mt-8">
                <div class="bg-slate-800 rounded-t-2xl p-3 shadow-2xl relative z-10 border-4 border-slate-700">
                    <div class="bg-[#EEF4EE] rounded-lg h-56 md:h-64 overflow-hidden relative p-4 flex gap-4 items-center justify-center">
                        
                        <div class="absolute top-3 w-[80%] h-6 bg-white rounded-full flex items-center px-4 shadow-sm z-20">
                            <div class="w-2 h-2 rounded-full bg-red-400 mr-2 animate-pulse"></div>
                            <div class="w-2 h-2 rounded-full bg-yellow-400 mr-2 animate-pulse" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse" style="animation-delay: 0.4s"></div>
                        </div>
                        
                        <div class="w-[28%] h-32 bg-[#85A385] rounded-r-md rounded-l-sm shadow-md mt-6 float-1 relative overflow-hidden border-l-[6px] border-[#6B8E6B] flex flex-col justify-center items-center">
                            <div class="w-8 h-10 border-2 border-white/40 rounded-sm mb-3"></div>
                            <div class="w-12 h-1 bg-white/60 rounded-full mb-1"></div>
                            <div class="w-8 h-1 bg-white/60 rounded-full"></div>
                            <div class="absolute top-0 right-3 w-2 h-8 bg-white/30"></div>
                        </div>

                        <div class="w-[35%] h-44 bg-[#4A6B4A] rounded-r-lg rounded-l-sm shadow-2xl z-10 mt-2 float-2 relative overflow-hidden border-l-[8px] border-[#2c402c] flex flex-col justify-center items-center">
                            <span class="text-3xl mb-3 drop-shadow-md">📖</span>
                            <div class="w-16 h-1.5 bg-white/80 rounded-full mb-2"></div>
                            <div class="w-10 h-1 bg-white/60 rounded-full mb-4"></div>
                            <div class="w-full flex justify-center gap-1">
                                <div class="w-2 h-2 rounded-full bg-white/30"></div>
                                <div class="w-2 h-2 rounded-full bg-white/30"></div>
                                <div class="w-2 h-2 rounded-full bg-white/30"></div>
                            </div>
                            <div class="absolute top-0 bottom-0 right-0 w-2 bg-gradient-to-l from-white/20 to-transparent"></div>
                        </div>

                        <div class="w-[28%] h-32 bg-[#6B8E6B] rounded-r-md rounded-l-sm shadow-md mt-6 float-3 relative overflow-hidden border-l-[6px] border-[#4A6B4A] flex flex-col justify-center items-center">
                            <span class="text-2xl mb-2 text-white/80 drop-shadow-sm">✦</span>
                            <div class="w-14 h-1.5 bg-white/60 rounded-full mb-1"></div>
                            <div class="w-8 h-1 bg-white/60 rounded-full"></div>
                        </div>

                    </div>
                </div>
                <div class="bg-slate-400 h-3 rounded-b-xl relative z-20 shadow-xl w-[110%] -ml-[5%]"></div>
            </div>

            <div class="flex justify-between w-full max-w-[400px] mt-10 px-4" data-aos="zoom-in" data-aos-delay="500">
                <div class="text-center">
                    <h3 class="text-2xl font-black text-[#4A6B4A]">25K+</h3>
                    <p class="text-xs font-semibold text-[#7DA07D] uppercase tracking-wider">Books</p>
                </div>
                <div class="text-center">
                    <h3 class="text-2xl font-black text-[#4A6B4A]">8K+</h3>
                    <p class="text-xs font-semibold text-[#7DA07D] uppercase tracking-wider">Users</p>
                </div>
                <div class="text-center">
                    <h3 class="text-2xl font-black text-[#4A6B4A]">50K+</h3>
                    <p class="text-xs font-semibold text-[#7DA07D] uppercase tracking-wider">Access</p>
                </div>
            </div>
        </div>
    </main>

    <section class="max-w-6xl mx-auto px-8 py-20 text-center">
        <h2 class="text-4xl font-black text-[#5C805C] mb-16" data-aos="fade-up">Our Features</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-[#F4F9F4] p-10 rounded-2xl soft-shadow border border-[#E8F0E8] transform hover:-translate-y-3 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-3xl">💡</span>
                </div>
                <h3 class="text-xl font-black mb-3">Smart Search</h3>
                <p class="text-[#7DA07D] text-sm font-medium leading-relaxed">Find what you need faster, smarter and always reliable.</p>
            </div>
            
            <div class="bg-[#F4F9F4] p-10 rounded-2xl soft-shadow border border-[#E8F0E8] transform hover:-translate-y-3 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-3xl">⚡</span>
                </div>
                <h3 class="text-xl font-black mb-3">Fast Access</h3>
                <p class="text-[#7DA07D] text-sm font-medium leading-relaxed">Intelligent result, instant access, guaranteed trust.</p>
            </div>
            
            <div class="bg-[#F4F9F4] p-10 rounded-2xl soft-shadow border border-[#E8F0E8] transform hover:-translate-y-3 transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-3xl">✅</span>
                </div>
                <h3 class="text-xl font-black mb-3">Trusted</h3>
                <p class="text-[#7DA07D] text-sm font-medium leading-relaxed">Your shortcut to trusted, instant answers.</p>
            </div>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-8 py-20 text-center" data-aos="zoom-in" data-aos-duration="1000">
        <h2 class="text-3xl font-black text-[#5C805C] mb-2">Need Some Help?</h2>
        <p class="text-[#7DA07D] font-medium mb-10">We're here when you need us.</p>
        
        <div class="bg-[#F4F9F4] p-8 md:p-12 rounded-3xl soft-shadow border border-[#E8F0E8] relative">
            <p class="text-left font-semibold text-[#5C805C] mb-4">Let's us guide you through it....</p>
            <form action="#" class="relative group">
                <input type="text" placeholder="Type your message..." class="w-full bg-white px-6 py-4 rounded-xl outline-none border border-[#C8DAC8] focus:border-[#85A385] focus:shadow-md transition-all pr-32">
                <button type="button" class="absolute right-2 top-2 bottom-2 bg-[#6B8E6B] hover:bg-[#4A6B4A] text-white px-6 rounded-lg font-bold transition-all transform group-focus-within:scale-105">
                    Submit
                </button>
            </form>
        </div>
    </section>

    <footer class="bg-[#85A385] text-white pt-16 pb-6 px-8 md:px-16 mt-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 items-center mb-10" data-aos="fade-up">
            <div class="font-black text-3xl leading-tight text-white">
                Perpus<br><span class="font-medium text-xl">Digital</span>
            </div>
            
            <div class="flex gap-10 text-sm font-semibold justify-center md:justify-start">
                <div class="flex flex-col gap-3">
                    <a href="{{ route('home') }}" class="hover:text-slate-200 hover:translate-x-1 transition-transform">Beranda</a>
                    <a href="{{ route('koleksi') }}" class="hover:text-[#4A6B4A] transition-colors">Koleksi</a>
                </div>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('profile') }}" class="hover:text-slate-200 hover:translate-x-1 transition-transform">Profile</a>
                    <a href="{{ route('riwayat.index') }}" class="hover:text-slate-200 hover:translate-x-1 transition-transform">Riwayat</a>
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

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 100,
        });
    </script>
</body>
</html>