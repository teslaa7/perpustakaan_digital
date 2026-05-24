<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Merriweather:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #EEF4EE; }
        .font-serif { font-family: 'Merriweather', serif; }
        @media (min-width: 1024px) {
          .book-card { grid-template-columns: minmax(300px, 1fr) 2fr; }
          .book-image-container { margin-left: -5rem; } 
        }
    </style>
</head>
<body class="text-white flex flex-col min-h-screen">

    <nav class="w-full pt-6 pb-4 px-8 md:px-16 flex justify-between items-center bg-[#85A385] text-white relative z-50 shadow-sm">
        <a href="{{ route('home') }}" class="font-black text-2xl leading-tight text-white hover:text-slate-100 transition-colors">
            Perpus<br><span class="font-medium text-lg">Digital</span>
        </a>
        
        <div class="hidden md:flex space-x-10 font-semibold text-sm">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') || request()->routeIs('buku.detail') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Beranda</a>
            <a href="{{ route('koleksi') }}" class="{{ request()->routeIs('koleksi') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Koleksi</a>
            <a href="{{ auth()->check() ? route('riwayat.index') : route('login') }}" class="{{ request()->routeIs('riwayat.index') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Riwayat</a>
            <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Tentang Kami</a>
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Profile</a>
        </div>
        
       <div class="flex items-center gap-4">
            @auth
                <div class="hidden md:block text-right mr-2">
                    <p class="text-sm font-bold text-white">{{ auth()->user()->NamaLengkap ?? auth()->user()->Username ?? 'Member' }}</p>
                </div>
                
                <a href="{{ auth()->user()->role === 'administrator' || auth()->user()->role === 'petugas' ? route('admin.dashboard') : route('profile') }}" 
                   class="bg-white text-[#85A385] hover:bg-slate-100 px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                    {{ auth()->user()->role === 'peminjam' ? 'Akun Saya' : 'Dashboard' }}
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-white text-[#85A385] hover:bg-slate-100 px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                    Login / Sign in
                </a>
            @endauth
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center p-6 md:p-12 lg:p-24 max-w-7xl mx-auto w-full">

        @php
            // FIX: Cek dulu datanya biar Laravel gak ngambek kalau belum ada riwayat pinjam
            $buku = $buku ?? (isset($peminjaman) ? $peminjaman->buku : null);
        @endphp

        <div class="book-card grid lg:grid-cols-[1fr_2fr] gap-12 lg:gap-0 p-8 md:p-12 rounded-[2rem] w-full shadow-2xl relative" style="background-color: #85A385;">

            <div class="book-image-container lg:col-span-1 z-10">
                <div class="bg-white rounded-2xl p-6 shadow-2xl flex flex-col items-center text-center transform transition-transform hover:-translate-y-2 border border-slate-100">
                    
                    @if(isset($buku) && $buku->Cover)
                        <img src="{{ asset('covers/' . $buku->Cover) }}" alt="Cover {{ $buku->Judul }}" class="w-full h-auto mb-6 rounded-lg shadow-md object-cover border border-slate-100">
                    @else
                        <div class="w-full h-72 bg-slate-100 rounded-lg shadow-md flex items-center justify-center mb-6 border border-slate-200">
                            <span class="text-6xl opacity-30">📚</span>
                        </div>
                    @endif

                    <p class="text-[#85A385] text-xs font-bold uppercase tracking-widest mb-2">Book Cover</p>
                    <p class="text-2xl font-black text-[#85A385] font-serif mb-1 leading-tight line-clamp-2">{{ $buku->Judul ?? 'Buku Tidak Ditemukan' }}</p>
                    <p class="text-sm font-medium text-[#85A385] mb-6">By {{ $buku->Penulis ?? 'Unknown' }}</p>
                </div>
            </div>

            <div class="lg:pl-16 flex flex-col justify-center mt-8 lg:mt-0 z-0">
                
                {{-- BADGE SISA STOK --}}
                <div class="flex items-center gap-3 mb-3">
                    <p class="text-sm text-white/80 font-semibold uppercase tracking-widest">Book Details</p>
                    @if(isset($buku))
                        @if($buku->Stok > 0)
                            <span class="bg-white/20 text-white border border-white/30 px-3 py-1 rounded-full text-[10px] font-black tracking-wider uppercase shadow-sm">
                                Sisa Stok: {{ $buku->Stok }}
                            </span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-[10px] font-black tracking-wider uppercase shadow-sm">
                                Stok Habis
                            </span>
                        @endif
                    @endif
                </div>

                <h1 class="text-4xl lg:text-5xl font-serif font-black mb-3 leading-tight">{{ $buku->Judul ?? 'Judul Buku' }}</h1>
                <p class="text-xl text-white/90 mb-10 font-medium">By {{ $buku->Penulis ?? 'Unknown' }}</p>

                <div class="flex flex-wrap gap-3 mb-10">
                    @if(isset($buku) && is_iterable($buku->kategori))
                        @forelse($buku->kategori as $kat)
                            <span class="text-xs px-5 py-2.5 rounded-full font-bold bg-black/10 border border-white/10 shadow-sm backdrop-blur-sm">
                                {{ $kat->NamaKategori ?? 'Kategori' }}
                            </span>
                        @empty
                            <span class="text-xs px-5 py-2.5 rounded-full font-bold bg-black/10 border border-white/10 shadow-sm backdrop-blur-sm">Uncategorized</span>
                        @endforelse
                    @elseif(isset($buku) && $buku->kategori)
                        <span class="text-xs px-5 py-2.5 rounded-full font-bold bg-black/10 border border-white/10 shadow-sm backdrop-blur-sm">
                            {{ $buku->kategori->NamaKategori ?? 'Kategori' }}
                        </span>
                    @else
                        <span class="text-xs px-5 py-2.5 rounded-full font-bold bg-black/10 border border-white/10 shadow-sm backdrop-blur-sm">Uncategorized</span>
                    @endif
                </div>

                <p class="text-sm text-white/80 mb-3 font-semibold uppercase tracking-widest">Sinopsis</p>
                <p class="text-base text-white/90 leading-relaxed mb-12 text-justify">
                    {{ $buku->Sinopsis ?? 'Buku ini belum memiliki sinopsis. Buku ini menceritakan tentang perjuangan, serta ilmu pengetahuan yang bermanfaat.' }}
                </p>

                <div class="flex flex-col gap-4 mt-auto">
                    
                    @if(isset($peminjaman) && $peminjaman->StatusPeminjaman == 'Dipinjam')
                        <div class="flex gap-4">
                            <form action="{{ route('peminjaman.kembalikan', $peminjaman->PeminjamanID) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="bg-white text-[#85A385] hover:bg-slate-100 px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                                    Kembalikan Buku
                                </button>
                            </form>
                        </div>
                    @elseif(isset($peminjaman) && $peminjaman->StatusPeminjaman == 'Pending')
                        <div class="flex gap-4">
                            <button disabled class="bg-white/30 text-white border border-white/40 cursor-not-allowed px-6 py-2.5 rounded-lg font-bold text-sm shadow-sm opacity-80">
                                Menunggu ACC Admin
                            </button>
                        </div>
                    @else
                        {{-- LOGIKA TOMBOL PINJAM CEK STOK & PILIH TANGGAL KEMBALI --}}
                        @if(isset($buku) && $buku->Stok > 0)
                            <form action="{{ Route::has('peminjaman.store') ? route('peminjaman.store', $buku->BukuID ?? 0) : '#' }}" method="POST" class="m-0 bg-white/10 p-5 rounded-2xl border border-white/20">
                                @csrf
                                <p class="text-xs font-bold uppercase tracking-widest text-white/90 mb-3">Pilih Rencana Tanggal Kembali:</p>
                                
                                <div class="flex flex-col sm:flex-row gap-4">
                                    {{-- Input Rencana Tanggal Kembali (Min: Besok, Max: 14 Hari ke Depan) --}}
                                    <input type="date" name="BatasWaktu" required 
                                           min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" 
                                           max="{{ \Carbon\Carbon::now()->addDays(14)->format('Y-m-d') }}" 
                                           class="px-4 py-3 rounded-xl text-slate-800 text-sm font-bold border-2 border-transparent focus:border-[#85A385] outline-none flex-1 shadow-inner cursor-pointer w-full">
                                    
                                    <button type="submit" class="bg-[#6B8E6B] text-white border border-white/30 hover:bg-[#5C805C] px-8 py-3 rounded-xl font-bold text-sm transition-all shadow-md transform hover:-translate-y-1 whitespace-nowrap">
                                        Pinjam Buku
                                    </button>
                                </div>
                                <p class="text-[11px] text-yellow-300 mt-3 font-semibold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Telat mengembalikan akan dikenakan denda Rp 1.000 / hari.
                                </p>
                            </form>
                        @else
                            <div class="flex gap-4">
                                <button disabled class="bg-red-500/60 text-white cursor-not-allowed px-6 py-2.5 rounded-lg font-bold text-sm shadow-sm opacity-90 border border-red-400">
                                    Stok Habis
                                </button>
                            </div>
                        @endif
                    @endif

                    @if(isset($buku))
                        <div class="flex gap-4 mt-2">
                            <form action="{{ route('koleksi.store', $buku->BukuID) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="bg-[#85A385] border border-white/30 text-white hover:bg-[#6B8E6B] px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                                    Save ke Koleksi
                                </button>
                            </form>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </main>
</body>
</html>