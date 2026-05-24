<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-[#F4F9F4] p-6 md:p-12 min-h-screen">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8 border-b border-[#C8DAC8] pb-4">
            <h1 class="text-3xl font-extrabold text-[#4A6B4A]">Riwayat Peminjaman Saya</h1>
            <a href="{{ route('home') }}" class="text-[#5C805C] font-bold hover:text-[#385238] transition flex items-center gap-2">
                ← Kembali ke Beranda
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-[#E8F0E8] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#E8F0E8] text-[#4A6B4A] uppercase text-xs font-extrabold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Judul Buku</th>
                            <th class="px-6 py-4 text-center">Tanggal Pinjam</th>
                            <th class="px-6 py-4 text-center">Tenggat / Kembali</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($riwayat as $item)
                        <tr class="hover:bg-[#F4F9F4] transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-700">
                                {{ $item->buku ? $item->buku->Judul : 'Buku Dihapus' }}
                            </td>
                            <td class="px-6 py-4 text-center font-medium text-slate-600">
                                {{ \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center font-medium text-slate-600">
                                {{ $item->TanggalPengembalian ? \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->StatusPeminjaman == 'menunggu')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">⏳ Menunggu</span>
                                @elseif($item->StatusPeminjaman == 'dipinjam')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">📖 Dipinjam</span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">✅ Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-[#7DA07D]">
                                <div class="text-4xl mb-3">😶</div>
                                <p class="font-bold">Belum ada riwayat peminjaman.</p>
                                <p class="text-xs mt-1">Ayo pinjam buku pertamamu di beranda!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>