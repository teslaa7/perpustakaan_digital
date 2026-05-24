<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Buku | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #EEF4EE; overflow-x: hidden; }
        
        /* Wave Background Sesuai Desain Lu (Melengkung asimetris) */
        .wave-header {
            background-color: #85A385;
            /* Trik border-radius buat bikin lengkungan ombak */
            border-bottom-left-radius: 10% 40%;
            border-bottom-right-radius: 50% 80%;
        }
        
        .soft-shadow { box-shadow: 0 10px 25px -5px rgba(74, 107, 74, 0.1); }
    </style>
</head>
<body class="text-[#4A6B4A] flex flex-col min-h-screen">

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

    <div class="wave-header w-full pt-16 pb-32 px-8 md:px-16 relative -mt-4 z-0 shadow-inner" data-aos="fade-down">
        <div class="max-w-7xl mx-auto text-right text-white pr-4">
            <h1 class="text-5xl font-black mb-2 tracking-wide">Riwayat Buku</h1>
            <p class="text-lg font-medium opacity-90">Track all your borrowed and returned books.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto w-full px-6 -mt-10 relative z-20" data-aos="fade-up" data-aos-delay="100">
        <div class="relative flex items-center">
            <span class="absolute left-4 text-slate-400 text-xl">🔍</span>
            <input type="text" placeholder="Cari buku..." class="w-full bg-[#E8F0E8] border border-[#C8DAC8] text-slate-700 px-12 py-3.5 rounded-xl shadow-md outline-none focus:ring-2 focus:ring-[#85A385] transition-all font-medium placeholder-slate-400">
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-5xl mx-auto px-6 mt-8 w-full" data-aos="fade-down">
            <div class="bg-[#F4F9F4] border-l-4 border-[#5C805C] text-[#4A6B4A] font-bold p-4 rounded-r-xl shadow-sm flex items-center justify-between">
                <div>✅ {{ session('success') }}</div>
                <button onclick="this.parentElement.parentElement.style.display='none'" class="text-[#5C805C] hover:text-[#4A6B4A] text-xl">&times;</button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-5xl mx-auto px-6 mt-8 w-full" data-aos="fade-down">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 font-bold p-4 rounded-r-xl shadow-sm">
                @foreach ($errors->all() as $error)
                    <p>❌ {{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif
    @php
        // Otak Laravel: Ngitung jumlah data riwayat secara otomatis (KEBAL HURUF BESAR KECIL)
        $totalBorrowed = $riwayat->count();
        $returnedCount = $riwayat->filter(fn($item) => strtolower($item->StatusPeminjaman) == 'dikembalikan')->count();
        $currentlyBorrowed = $riwayat->filter(fn($item) => in_array(strtolower($item->StatusPeminjaman), ['pending', 'dipinjam']))->count();
        $overdueCount = 0; // Set 0 dulu (Bisa dikembangin kalau ada logika denda waktu)
    @endphp

    <div class="max-w-5xl mx-auto px-6 mt-8 w-full grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6" data-aos="fade-up" data-aos-delay="200">
        <div class="bg-[#85A385] text-white rounded-2xl p-6 text-center soft-shadow transform hover:-translate-y-1 transition-all">
            <h3 class="text-4xl font-black mb-1">{{ $totalBorrowed }}</h3>
            <p class="text-xs font-semibold uppercase tracking-wider">Total Borrowed</p>
        </div>
        <div class="bg-[#85A385] text-white rounded-2xl p-6 text-center soft-shadow transform hover:-translate-y-1 transition-all">
            <h3 class="text-4xl font-black mb-1">{{ $returnedCount }}</h3>
            <p class="text-xs font-semibold uppercase tracking-wider">Returned</p>
        </div>
        <div class="bg-[#85A385] text-white rounded-2xl p-6 text-center soft-shadow transform hover:-translate-y-1 transition-all">
            <h3 class="text-4xl font-black mb-1">{{ $overdueCount }}</h3>
            <p class="text-xs font-semibold uppercase tracking-wider">Overdue</p>
        </div>
        <div class="bg-[#85A385] text-white rounded-2xl p-6 text-center soft-shadow transform hover:-translate-y-1 transition-all">
            <h3 class="text-4xl font-black mb-1">{{ $currentlyBorrowed }}</h3>
            <p class="text-xs font-semibold uppercase tracking-wider">Currently Borrowed</p>
        </div>
    </div>

    <main class="max-w-6xl mx-auto px-6 mt-16 mb-24 w-full" data-aos="fade-in" data-aos-delay="300">
        
        <div class="hidden md:grid grid-cols-12 gap-4 text-center border-b-2 border-[#C8DAC8] pb-4 mb-6 text-[#7DA07D] font-bold text-sm uppercase tracking-wider px-4">
            <div class="col-span-2">Cover</div>
            <div class="col-span-4 text-left">Judul</div>
            <div class="col-span-2">Tgl. Peminjaman</div>
            <div class="col-span-2">Tgl. Pengembalian</div>
            <div class="col-span-2">Status</div>
        </div>

        <div class="space-y-4">
            @forelse($riwayat as $item)
                @php 
                    $status = strtolower($item->StatusPeminjaman); 
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-[#EEF4EE] hover:bg-white p-4 rounded-2xl border border-transparent hover:border-[#C8DAC8] hover:shadow-md transition-all duration-300">
                    
                    <div class="col-span-2 flex justify-center md:justify-center">
                        @if($item->buku && $item->buku->Cover)
                            <img src="{{ asset('covers/' . $item->buku->Cover) }}" class="w-16 h-24 object-cover rounded-lg shadow-sm border border-[#E8F0E8]">
                        @else
                            <div class="w-16 h-24 bg-slate-200 rounded-lg flex items-center justify-center text-2xl opacity-50">📚</div>
                        @endif
                    </div>

                    <div class="col-span-4 text-center md:text-left mt-2 md:mt-0">
                        <h4 class="font-bold text-slate-800 text-base md:text-lg leading-tight">{{ $item->buku ? $item->buku->Judul : 'Buku Dihapus' }}</h4>
                        <p class="text-xs text-slate-500 font-medium mt-1">By {{ $item->buku ? $item->buku->Penulis : '-' }}</p>
                    </div>

                    <div class="col-span-2 text-center text-sm font-semibold text-slate-600">
                        <span class="md:hidden text-xs text-slate-400 block mb-1">Pinjam:</span>
                        {{ \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d-m-Y') }}
                    </div>

                    <div class="col-span-2 text-center text-sm font-semibold text-slate-600">
                        <span class="md:hidden text-xs text-slate-400 block mb-1">Kembali:</span>
                        {{ $item->TanggalPengembalian ? \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d-m-Y') : '-' }}
                    </div>

                    {{-- BAGIAN AKSI (STATUS & TOMBOL-TOMBOL) --}}
                    <div class="col-span-2 flex flex-col gap-2 px-4 md:px-0 mt-4 md:mt-0">
                        
                        @if($status == 'pending' || $status == 'menunggu')
                            <span class="bg-yellow-100 text-yellow-600 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase w-full text-center">Menunggu ACC</span>
                            <a href="{{ route('peminjaman.detail', $item->PeminjamanID) }}" class="bg-[#85A385] hover:bg-[#6B8E6B] text-white px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase text-center w-full transition-all block">See Detail</a>
                        
                        @elseif($status == 'dipinjam')
                            <span class="bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase w-full text-center">Borrowed</span>
                            
                            {{-- TAMPILIN TOMBOL STRUK KALAU UDAH DIPINJAM --}}
                            <a href="{{ route('peminjaman.struk', $item->PeminjamanID) }}" target="_blank" class="bg-slate-700 hover:bg-slate-900 text-white px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase w-full text-center transition-all shadow-sm">
                                📄 Cetak Struk
                            </a>
                            
                            <a href="{{ route('peminjaman.detail', $item->PeminjamanID) }}" class="bg-[#85A385] hover:bg-[#6B8E6B] text-white px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase text-center w-full transition-all block">See Detail</a>
                        
                        @elseif($status == 'ditolak')
                            <span class="bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase w-full text-center">Ditolak</span>
                            
                            {{-- TAMPILIN TOMBOL STRUK BUAT BUKTI PENOLAKAN --}}
                            <a href="{{ route('peminjaman.struk', $item->PeminjamanID) }}" target="_blank" class="bg-slate-700 hover:bg-slate-900 text-white px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase w-full text-center transition-all shadow-sm">
                                📄 Cetak Struk
                            </a>
                            
                        @else
                            <span class="bg-[#E8F0E8] text-[#4A6B4A] px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase w-full text-center">Returned</span>
                            
                            {{-- TAMPILIN TOMBOL STRUK BUKTI PENGEMBALIAN --}}
                            <a href="{{ route('peminjaman.struk', $item->PeminjamanID) }}" target="_blank" class="bg-slate-700 hover:bg-slate-900 text-white px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase w-full text-center transition-all shadow-sm">
                                📄 Cetak Struk
                            </a>
                            
                            <button onclick="openUlasanModal('{{ $item->BukuID }}', '{{ addslashes($item->buku->Judul) }}')" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase w-full transition-all shadow-sm">Review</button>
                        @endif

                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-3xl border border-[#C8DAC8]">
                    <span class="text-6xl mb-4 block">📭</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">No Records Found</h3>
                    <p class="text-[#7DA07D] font-medium">Kamu belum memiliki riwayat peminjaman.</p>
                </div>
            @endforelse
        </div>
    </main>

    <div id="ulasanModal" class="fixed inset-0 bg-gray-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-all px-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative">
            <button onclick="closeUlasanModal()" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 font-black text-xl transition-colors">&times;</button>
            <h3 class="text-2xl font-black mb-2 text-[#4A6B4A] text-center">Beri Ulasan</h3>
            <p id="judulBukuReview" class="text-center text-slate-500 font-semibold mb-6 text-sm border-b pb-4">-</p>
            <form id="formUlasan" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C] text-center">Rating Buku</label>
                        <select name="Rating" class="w-full text-center px-4 py-3 border-2 border-yellow-300 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400 bg-yellow-50 text-yellow-700 font-black text-lg cursor-pointer" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                            <option value="3">⭐⭐⭐ (3/5)</option>
                            <option value="2">⭐⭐ (2/5)</option>
                            <option value="1">⭐ (1/5)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Komentar</label>
                        <textarea name="Ulasan" rows="4" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50 text-sm font-medium resize-none" required placeholder="Gimana pendapatmu soal buku ini?"></textarea>
                    </div>
                </div>
                <button type="submit" class="w-full mt-8 bg-[#6B8E6B] text-white rounded-xl py-3 font-black text-sm hover:bg-[#4A6B4A] transition-colors shadow-lg">Kirim Ulasan</button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50 });
        function openUlasanModal(bukuId, judulBuku) {
            document.getElementById('formUlasan').action = `/ulasan/${bukuId}`;
            document.getElementById('judulBukuReview').innerText = judulBuku;
            document.getElementById('ulasanModal').classList.remove('hidden');
        }
        function closeUlasanModal() { document.getElementById('ulasanModal').classList.add('hidden'); }
    </script>
</body>
</html>