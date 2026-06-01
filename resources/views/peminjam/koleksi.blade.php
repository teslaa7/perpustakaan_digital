<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #EEF4EE; overflow-x: hidden; }
        .soft-shadow { box-shadow: 0 10px 25px -5px rgba(74, 107, 74, 0.1); }
        .wave-bg {
            background-color: #85A385;
            border-bottom-left-radius: 50% 20%;
            border-bottom-right-radius: 50% 20%;
        }
    </style>
</head>
<body class="text-[#4A6B4A] flex flex-col min-h-screen">

    {{-- NAVBAR --}}
    <nav class="w-full pt-6 pb-4 px-8 md:px-16 flex justify-between items-center bg-[#85A385] text-white relative z-50 shadow-sm">
        <a href="{{ route('home') }}" class="font-black text-2xl leading-tight text-white hover:text-slate-100 transition-colors">
            Perpus<br><span class="font-medium text-lg">Digital</span>
        </a>
        
        <div class="hidden md:flex space-x-10 font-semibold text-sm">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Beranda</a>
            <a href="{{ route('koleksi') }}" class="{{ request()->routeIs('koleksi') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Koleksi</a>
            <a href="{{ auth()->check() ? route('riwayat.index') : route('login') }}" class="{{ request()->routeIs('riwayat.index') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Riwayat</a>
            <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Tentang Kami</a>
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Profile</a>
        </div>

        <div class="flex items-center gap-4">
            @auth
                <div class="hidden md:block text-right mr-2">
                    <p class="text-sm font-bold text-[#4A6B4A]">{{ auth()->user()->NamaLengkap ?? auth()->user()->Username ?? 'Member' }}</p>
                </div>
                
                <a href="{{ auth()->user()->role === 'administrator' || auth()->user()->role === 'petugas' ? route('admin.dashboard') : route('profile') }}" 
                   class="bg-[#85A385] text-white hover:bg-[#6B8E6B] px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                    {{ auth()->user()->role === 'peminjam' ? 'Akun Saya' : 'Dashboard' }}
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-[#85A385] text-white hover:bg-[#6B8E6B] px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                    Login / Sign in
                </a>
            @endauth
        </div>
    </nav>

    {{-- ALERT PESAN --}}
    @if(session('success'))
        <div class="max-w-5xl mx-auto px-6 mt-6 w-full" data-aos="fade-down">
            <div class="bg-[#F4F9F4] border-l-4 border-[#5C805C] text-[#4A6B4A] font-bold p-4 rounded-r-xl shadow-sm">
                ✅ {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-5xl mx-auto px-6 mt-6 w-full" data-aos="fade-down">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 font-bold p-4 rounded-r-xl shadow-sm">
                ❌ {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- HERO TITLE --}}
    <div class="wave-bg w-full pt-12 pb-24 px-8 md:px-16 relative -mt-4 z-0 shadow-inner" data-aos="fade-down">
        <h1 class="text-4xl md:text-5xl font-black text-white max-w-7xl mx-auto text-center tracking-wide">
            Koleksi Umum
        </h1>
    </div>

    {{-- SEARCH BAR DINAMIS --}}
    <div class="max-w-3xl mx-auto w-full px-6 -mt-10 relative z-20" data-aos="fade-up" data-aos-delay="200">
        <form action="{{ route('koleksi') }}" method="GET" class="relative flex items-center">
            <span class="absolute left-4 text-slate-400 text-xl">🔍</span>
            
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku berdasarkan judul atau penulis..." class="w-full bg-[#E8F0E8] border-2 border-white text-slate-700 px-12 py-3 rounded-xl shadow-md outline-none focus:ring-2 focus:ring-[#6B8E6B] transition-all font-medium placeholder-slate-400">
            
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            
            <button type="submit" class="hidden"></button>
        </form>
    </div>

    {{-- MENU KATEGORI DINAMIS --}}
    <div class="max-w-5xl mx-auto px-6 py-10 w-full flex justify-center gap-6 md:gap-12 text-sm font-semibold text-[#7DA07D] flex-wrap" data-aos="fade-in" data-aos-delay="300">
        
        {{-- PERUBAHAN: Hapus array search, jadi kalau klik 'Semua', URL bener-bener bersih --}}
        <a href="{{ route('koleksi') }}" 
           class="{{ !request('kategori') ? 'text-[#4A6B4A] border-b-2 border-[#4A6B4A] pb-1' : 'hover:text-[#4A6B4A] transition-colors' }}">
            Semua
        </a>

        @if(isset($kategoriList) && $kategoriList->count() > 0)
            @foreach($kategoriList as $kat)
                {{-- PERUBAHAN: Hanya kirim parameter 'kategori' saja, tinggalkan 'search' --}}
                <a href="{{ route('koleksi', ['kategori' => $kat->NamaKategori]) }}" 
                   class="{{ request('kategori') == $kat->NamaKategori ? 'text-[#4A6B4A] border-b-2 border-[#4A6B4A] pb-1' : 'hover:text-[#4A6B4A] transition-colors' }}">
                    {{ $kat->NamaKategori }}
                </a>
            @endforeach
        @endif

    </div>

    {{-- KONTEN GRID BUKU --}}
    <main class="max-w-6xl mx-auto px-6 mb-20 w-full">
        <div class="bg-[#E8F0E8] p-8 md:p-12 rounded-3xl soft-shadow" data-aos="fade-up" data-aos-delay="400">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($buku as $item)
                    <div class="bg-[#EEF4EE] rounded-3xl p-5 border border-white shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col items-center group">
                        
                        {{-- GAMBAR COVER --}}
                        <div class="w-full h-64 bg-slate-200 rounded-2xl overflow-hidden mb-4 relative shadow-inner">
                            @if($item->Cover)
                                <img src="{{ asset('covers/' . $item->Cover) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl opacity-30">📚</div>
                            @endif
                        </div>
                        
                        {{-- JUDUL --}}
                        <h4 class="font-black text-center text-slate-800 text-sm leading-snug mb-4 line-clamp-2 min-h-[40px]">{{ $item->Judul }}</h4>
                        
                        {{-- INFO STOK & TOMBOL --}}
                        <div class="w-full flex flex-col gap-2 mt-auto">
                            @if($item->Stok > 0)
                                <div class="w-full h-9 flex items-center justify-center bg-[#F4F9F4] text-[#4A6B4A] font-black rounded-lg text-xs shadow-inner tracking-widest uppercase border border-[#C8DAC8]">
                                    📦 TERSISA : {{ $item->Stok }} BUKU
                                </div>
                            @else
                                <div class="w-full h-9 flex items-center justify-center bg-red-50 text-red-500 font-black rounded-lg text-xs shadow-inner tracking-widest uppercase border border-red-200">
                                    ❌ STOK HABIS
                                </div>
                            @endif

                            <div class="flex gap-2 mt-1 w-full">
                                <a href="{{ route('buku.detail', $item->BukuID) }}" class="flex-1 bg-[#85A385] hover:bg-[#6B8E6B] text-white font-semibold py-1.5 rounded-lg text-[10px] transition-all flex items-center justify-center">
                                    Detail
                                </a>
                                <form action="{{ route('koleksi.store', $item->BukuID) }}" method="POST" class="flex-1 flex m-0">
                                    @csrf
                                    <button type="submit" class="w-full bg-[#85A385] hover:bg-[#6B8E6B] text-white font-semibold py-1.5 rounded-lg text-[10px] transition-all flex items-center justify-center">
                                        Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <span class="text-5xl mb-3 block">😢</span>
                        <p class="text-[#7DA07D] font-bold">Maaf, buku tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    {{-- REVIEW PEMBACA --}}
    <section class="max-w-4xl mx-auto px-6 mb-24 w-full text-center" data-aos="fade-up">
        <h2 class="text-4xl font-black text-[#6B8E6B] mb-8">Review Pembaca</h2>
        
        <div class="bg-[#E8F0E8] rounded-3xl p-6 md:p-10 flex items-center justify-between soft-shadow border border-[#C8DAC8] relative">
            <button onclick="prevReview()" class="z-20 w-10 h-10 bg-black text-white rounded-full flex items-center justify-center hover:bg-slate-800 transition-transform hover:-translate-x-1 shrink-0">
                <span class="text-xl">←</span>
            </button>
            
            <div id="review-container" class="flex-1 overflow-hidden relative mx-4 min-h-[140px] flex items-center justify-center">
                @if(isset($ulasan) && $ulasan->count() > 0)
                    @foreach($ulasan as $index => $rev)
                        <div class="review-slide absolute inset-0 transition-opacity duration-500 flex flex-col md:flex-row items-center justify-center gap-6 text-left px-4 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md flex-shrink-0 bg-slate-200">
                                <img src="https://api.dicebear.com/7.x/notionists/svg?seed={{ $rev->Username }}" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-black text-lg text-slate-800">{{ $rev->NamaLengkap ?? $rev->Username }}</h4>
                                <p class="text-xs text-slate-400 mb-2">{{ $rev->Email }}</p>
                                <p class="text-[#5C805C] font-semibold text-sm mb-2 italic">"{{ $rev->Ulasan }}"</p>
                                <div class="text-yellow-400 text-sm tracking-widest">
                                    {{ str_repeat('⭐', $rev->Rating) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center w-full text-[#7DA07D] font-bold">
                        Belum ada ulasan. Jadilah yang pertama memberikan review!
                    </div>
                @endif
            </div>
            
            <button onclick="nextReview()" class="z-20 w-10 h-10 bg-black text-white rounded-full flex items-center justify-center hover:bg-slate-800 transition-transform hover:translate-x-1 shrink-0">
                <span class="text-xl">→</span>
            </button>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-[#85A385] text-white pt-16 pb-6 px-8 md:px-16 mt-auto border-t border-[#6B8E6B]">
        <div class="text-center text-xs font-medium text-white">
            © {{ date('Y') }} PerpusDigital All rights reserved.
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50 });

        let currentReview = 0;
        const reviews = document.querySelectorAll('.review-slide');

        function showReview(index) {
            if(reviews.length === 0) return;
            reviews.forEach((rev, i) => {
                rev.classList.remove('opacity-100', 'z-10');
                rev.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                if(i === index) {
                    rev.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                    rev.classList.add('opacity-100', 'z-10');
                }
            });
        }

        function nextReview() {
            if(reviews.length <= 1) return;
            currentReview = (currentReview + 1) % reviews.length;
            showReview(currentReview);
        }

        function prevReview() {
            if(reviews.length <= 1) return;
            currentReview = (currentReview - 1 + reviews.length) % reviews.length;
            showReview(currentReview);
        }
    </script>
</body>
</html>