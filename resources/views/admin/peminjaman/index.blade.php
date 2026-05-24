@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-[#E8F0E8] p-6 relative">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-[#E8F0E8] pb-4 gap-4">
        <div>
            <h2 class="text-2xl font-black text-[#4A6B4A]">Kelola Peminjaman Buku</h2>
            <p class="text-[#7DA07D] mt-1 text-sm font-medium">Setujui peminjaman, tolak, dan pantau status buku di sini.</p>
        </div>
        
        <a href="{{ route('peminjaman.pdf') }}" class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Cetak Rekap PDF
        </a>
    </div>

    @if(session('success'))
        <div class="bg-[#F4F9F4] border-l-4 border-[#5C805C] text-[#4A6B4A] font-bold p-4 mb-6 rounded-r-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-600 font-bold p-4 mb-6 rounded-r-lg shadow-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-[#E8F0E8]">
        <table class="min-w-full bg-white text-left">
            <thead class="bg-[#F4F9F4] text-[#4A6B4A] text-sm uppercase tracking-wider">
                <tr>
                    <th class="py-4 px-5 font-black w-12 text-center">No</th>
                    <th class="py-4 px-5 font-black">Peminjam</th>
                    <th class="py-4 px-5 font-black">Buku</th>
                    <th class="py-4 px-5 font-black">Tgl Pinjam</th>
                    <th class="py-4 px-5 font-black text-orange-600">Batas Waktu</th>
                    <th class="py-4 px-5 font-black">Tgl Kembali</th>
                    <th class="py-4 px-5 font-black text-red-500">Denda</th>
                    <th class="py-4 px-5 font-black text-center">Status</th>
                    <th class="py-4 px-5 font-black text-center w-40">Aksi Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E8F0E8]">
                @forelse ($peminjaman as $index => $item)
                <tr class="hover:bg-[#F9FBF9] transition-colors duration-200">
                    <td class="py-4 px-5 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                    
                    <td class="py-4 px-5 font-extrabold text-slate-800">
                        {{ $item->user ? ($item->user->NamaLengkap ?? $item->user->Username) : 'User Dihapus' }}
                    </td>
                    
                    <td class="py-4 px-5 text-[#5C805C] font-bold">
                        📖 {{ $item->buku ? $item->buku->Judul : 'Buku Dihapus' }}
                    </td>
                    
                    <td class="py-4 px-5 text-slate-600 font-medium">
                        {{ $item->TanggalPeminjaman ? \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d M Y') : '-' }}
                    </td>

                    <td class="py-4 px-5 font-bold text-orange-600">
                        {{ $item->BatasWaktu ? \Carbon\Carbon::parse($item->BatasWaktu)->format('d M Y') : '-' }}
                    </td>
                    
                    <td class="py-4 px-5 text-slate-600 font-medium">
                        {{ $item->TanggalPengembalian ? \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d M Y') : '-' }}
                    </td>

                    <td class="py-4 px-5 font-black {{ $item->Denda > 0 ? 'text-red-500' : 'text-slate-400' }}">
                        Rp {{ number_format($item->Denda, 0, ',', '.') }}
                    </td>
                    
                    <td class="py-4 px-5 text-center">
                        @if($item->StatusPeminjaman == 'Pending')
                            <span class="bg-yellow-50 text-yellow-600 border border-yellow-200 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">Pending</span>
                        @elseif($item->StatusPeminjaman == 'Dipinjam')
                            <span class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">Dipinjam</span>
                        @elseif($item->StatusPeminjaman == 'Ditolak')
                            <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">Ditolak</span>
                        @else
                            <span class="bg-[#E8F0E8] text-[#4A6B4A] border border-[#C8DAC8] px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">Dikembalikan</span>
                        @endif
                    </td>
                    
                    <td class="py-4 px-5 align-middle text-center">
                        <div class="flex justify-center items-center space-x-2">
                            
                            @if($item->StatusPeminjaman == 'Pending')
                                <form action="{{ route('peminjaman.status', $item->PeminjamanID) }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <input type="hidden" name="status" value="Dipinjam">
                                    <button type="submit" class="bg-[#85A385] hover:bg-[#5C805C] text-white px-3 py-1.5 rounded-lg text-xs transition-all font-bold shadow-sm transform hover:-translate-y-0.5" onclick="return confirm('Setujui peminjaman ini?')">
                                        ACC
                                    </button>
                                </form>

                                <form action="{{ route('peminjaman.status', $item->PeminjamanID) }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs transition-all font-bold shadow-sm transform hover:-translate-y-0.5" onclick="return confirm('Tolak peminjaman ini?')">
                                        Tolak
                                    </button>
                                </form>
                            @endif

                            @if($item->StatusPeminjaman == 'Dipinjam')
                                <form action="{{ route('peminjaman.status', $item->PeminjamanID) }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <input type="hidden" name="status" value="Dikembalikan">
                                    <button type="submit" class="bg-slate-700 hover:bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs transition-all font-bold shadow-sm transform hover:-translate-y-0.5" onclick="return confirm('Selesaikan peminjaman ini secara manual?')">
                                        Selesaikan
                                    </button>
                                </form>
                            @endif

                            @if($item->StatusPeminjaman == 'Dikembalikan' || $item->StatusPeminjaman == 'Ditolak')
                                <span class="text-slate-400 font-bold text-xs italic bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">
                                    {{ $item->StatusPeminjaman == 'Ditolak' ? 'Ditolak' : 'Selesai' }}
                                </span>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-12 text-center text-slate-400 font-medium bg-slate-50 border-dashed border-2 border-slate-200">
                        <div class="text-4xl mb-2">📚</div>
                        Belum ada data transaksi peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection