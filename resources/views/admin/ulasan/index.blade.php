@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-[#E8F0E8] p-6 relative">
    {{-- HEADER HALAMAN & TOMBOL CETAK --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-[#E8F0E8] pb-4 gap-4">
        <div>
            <h2 class="text-2xl font-black text-[#4A6B4A]">Kelola Ulasan & Rating</h2>
            <p class="text-[#7DA07D] mt-1 text-sm font-medium">Pantau semua komentar peminjam dan hapus ulasan yang tidak pantas.</p>
        </div>
        
        <a href="{{ route('ulasan.pdf') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Cetak PDF
        </a>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
        <div class="bg-[#F4F9F4] border-l-4 border-[#5C805C] text-[#4A6B4A] font-bold p-4 mb-6 rounded-r-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- TABEL DATA --}}
    <div class="overflow-x-auto rounded-xl border border-[#E8F0E8]">
        <table class="min-w-full bg-white text-left">
            <thead class="bg-[#F4F9F4] text-[#4A6B4A] text-sm uppercase tracking-wider">
                <tr>
                    <th class="py-4 px-5 font-bold w-12 text-center">No</th>
                    <th class="py-4 px-5 font-bold w-48">Peminjam</th>
                    <th class="py-4 px-5 font-bold w-48">Buku</th>
                    <th class="py-4 px-5 font-bold">Isi Ulasan</th>
                    <th class="py-4 px-5 font-bold text-center w-32">Rating</th>
                    <th class="py-4 px-5 font-bold text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E8F0E8]">
                @forelse ($ulasan as $index => $item)
                <tr class="hover:bg-[#F9FBF9] transition-colors duration-200">
                    <td class="py-4 px-5 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                    
                    <td class="py-4 px-5 font-extrabold text-slate-800">
                        {{ $item->NamaLengkap ?? $item->Username ?? 'User Dihapus' }}
                    </td>
                    
                    <td class="py-4 px-5 text-[#5C805C] font-bold">
                        📖 {{ $item->Judul ?? 'Buku Dihapus' }}
                    </td>
                    
                    <td class="py-4 px-5">
                        <div class="relative">
                            <p class="text-slate-600 font-medium text-sm leading-relaxed">"{{ $item->Ulasan }}"</p>
                            <span class="text-[10px] text-slate-400 mt-2 block font-medium">
                                📅 {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-' }}
                            </span>
                        </div>
                    </td>
                    
                    <td class="py-4 px-5 text-center">
                        <span class="bg-[#F4F9F4] text-[#4A6B4A] px-3 py-1 rounded-full text-[10px] font-bold uppercase">
                            ⭐ {{ $item->Rating }}/5
                        </span>
                    </td>
                    
                    <td class="py-4 px-5 align-middle text-center">
                        <form action="{{ route('ulasan.destroy', $item->UlasanID) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')" class="m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-100 hover:bg-red-600 text-red-500 hover:text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-400 font-medium bg-slate-50 border-dashed border-2 border-slate-200">
                        <div class="text-4xl mb-2">💬</div>
                        Belum ada ulasan yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection