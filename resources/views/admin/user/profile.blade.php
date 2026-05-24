<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil & Koleksi | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-[#F4F9F4] text-slate-700 min-h-screen">

    <nav class="w-full bg-[#F4F9F4] border-b border-[#C8DAC8]/50">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex justify-between items-center h-20">
            <div class="font-black text-2xl text-[#4A6B4A] leading-tight tracking-tighter">
                Perpus<br><span class="font-semibold text-[#7DA07D]">Digital</span>
            </div>
            <div class="hidden md:flex space-x-8 text-sm font-semibold text-[#7DA07D]">
                <a href="{{ route('home') }}" class="hover:text-[#4A6B4A] transition">Beranda</a>
                <a href="{{ route('home') }}#koleksi" class="hover:text-[#4A6B4A] transition">Koleksi</a>
                <a href="{{ route('riwayat.index') }}" class="hover:text-[#4A6B4A] transition">Riwayat</a>
                <a href="{{ route('home') }}#about" class="hover:text-[#4A6B4A] transition">Tentang kami</a>
                <a href="#" class="text-[#4A6B4A] border-b-2 border-[#4A6B4A] pb-1">Profile</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="bg-[#85A385] rounded-[2rem] p-8 md:p-12 shadow-xl shadow-[#85A385]/20 flex flex-col md:flex-row items-center md:items-start gap-10 mb-16 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            
            <div class="w-36 h-36 bg-[#F4F9F4] rounded-full shadow-lg border-4 border-white flex-shrink-0 flex items-center justify-center overflow-hidden">
                <div class="text-5xl">🐻</div>
            </div>

            <div class="flex-1 w-full space-y-5 text-white z-10">
                <div class="flex items-center justify-between border-b border-white/30 pb-2">
                    <p class="font-semibold tracking-wide">{{ auth()->user()->name }}</p>
                    <button class="hover:text-slate-200 transition">✏️</button>
                </div>
                <div class="flex items-center justify-between border-b border-white/30 pb-2">
                    <p class="font-medium opacity-90">{{ auth()->user()->email }}</p>
                    <button class="hover:text-slate-200 transition">✏️</button>
                </div>
                <div class="flex items-center justify-between border-b border-white/30 pb-2">
                    <p class="font-medium opacity-90 tracking-widest">••••••••••••</p>
                    <button class="hover:text-slate-200 transition">👁️ ✏️</button>
                </div>
                <div class="flex items-center justify-between border-b border-white/30 pb-2">
                    <p class="font-medium opacity-90">Jl. Cibubur (Contoh Alamat)</p>
                    <button class="hover:text-slate-200 transition">✏️</button>
                </div>
            </div>
        </div>

        <div class="text-center mb-10">
            <h2 class="text-4xl font-extrabold text-[#7DA07D]">Your Collections</h2>
            <p class="text-[#5C805C] font-medium border-b-2 border-[#C8DAC8] inline-block pb-2 px-6 mt-1">Your saved reading collection</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="text-[#7DA07D] border-b-2 border-[#C8DAC8]">
                    <tr>
                        <th class="py-4 px-4 font-bold">Cover</th>
                        <th class="py-4 px-4 font-bold">Judul</th>
                        <th class="py-4 px-4 font-bold">Penulis</th>
                        <th class="py-4 px-4 font-bold">Status</th>
                        <th class="py-4 px-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-semibold text-[#5C805C]">
                    @forelse($riwayat as $item)
                    <tr class="border-b border-[#E8F0E8] hover:bg-white/50 transition-colors">
                        <td class="py-4 px-4">
                            @if($item->buku && $item->buku->Cover)
                                <img src="{{ asset('covers/' . $item->buku->Cover) }}" alt="Cover" class="w-16 h-20 object-cover rounded shadow-sm">
                            @else
                                <div class="w-16 h-20 bg-[#E8F0E8] rounded flex items-center justify-center text-[10px] text-center p-1">No Cover</div>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-[#4A6B4A] text-base font-bold">{{ $item->buku ? $item->buku->Judul : 'Buku Dihapus' }}</td>
                        <td class="py-4 px-4">By {{ $item->buku ? $item->buku->Penulis : '-' }}</td>
                        <td class="py-4 px-4">
                            @if($item->StatusPeminjaman == 'menunggu')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs uppercase tracking-wider">Menunggu</span>
                            @elseif($item->StatusPeminjaman == 'dipinjam')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs uppercase tracking-wider">Dipinjam</span>
                            @else
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs uppercase tracking-wider">Selesai</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center space-y-2">
                            <button class="w-full bg-[#85A385] text-white py-1.5 rounded-lg text-xs hover:bg-[#5C805C] transition shadow">Detail</button>
                            <button class="w-full bg-[#85A385] text-white py-1.5 rounded-lg text-xs hover:bg-[#5C805C] transition shadow">Ulas Buku</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-[#7DA07D] italic">
                            Belum ada buku di koleksimu. Ayo pinjam sekarang!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>