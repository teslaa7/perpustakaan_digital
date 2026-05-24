@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-[#E8F0E8] p-6 relative w-full">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b border-[#E8F0E8] pb-4 gap-4">
        <div class="w-full">
            <h2 class="text-2xl font-black text-[#4A6B4A]">Kelola Peminjam (Member)</h2>
            <p class="text-[#7DA07D] mt-1 text-sm font-medium">Pantau dan kelola data akun siswa/anggota perpustakaan.</p>
        </div>
        
        {{-- TOMBOL CETAK PDF (Gantiin Tambah Member) --}}
        <a href="{{ route('user.pdf') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Cetak PDF
        </a>
    </div>

    @if(session('success'))
        <div class="bg-[#F4F9F4] border-l-4 border-[#5C805C] text-[#4A6B4A] font-bold p-4 mb-6 rounded-r-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-[#E8F0E8]">
        <table class="min-w-full bg-white text-left">
            <thead class="bg-[#F4F9F4] text-[#4A6B4A] text-sm uppercase tracking-wider">
                <tr>
                    <th class="py-4 px-5 font-black w-12 text-center">No</th>
                    <th class="py-4 px-5 font-black">Nama Lengkap</th>
                    <th class="py-4 px-5 font-black">Info Akun</th>
                    <th class="py-4 px-5 font-black text-center">Alamat</th>
                    <th class="py-4 px-5 font-black text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E8F0E8] text-sm">
                @forelse ($user ?? $users as $item)
                <tr class="hover:bg-[#F9FBF9] transition-colors duration-200">
                    <td class="py-4 px-5 text-center font-semibold text-slate-500">{{ $loop->iteration }}</td>
                    
                    <td class="py-4 px-5 font-extrabold text-slate-800 text-base">
                        {{ $item->NamaLengkap ?? $item->name }}
                    </td>
                    
                    <td class="py-4 px-5">
                        <span class="text-[#4A6B4A] font-black block">{{ '@' . ($item->Username ?? $item->username) }}</span>
                        <span class="text-slate-500 font-medium text-xs">{{ $item->Email ?? $item->email }}</span>
                    </td>
                    
                    <td class="py-4 px-5 text-center">
                        <span class="text-slate-600 italic text-xs">
                            {{ $item->Alamat ?? 'Tidak ada data alamat' }}
                        </span>
                    </td>
                    
                    <td class="py-4 px-5 align-middle text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <form action="{{ route('user.destroy', $item->UserID ?? $item->id) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Yakin ingin menghapus akun member ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#F8D7DA] hover:bg-[#DC3545] text-[#721C24] hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-slate-400 font-medium bg-slate-50 border-dashed border-2 border-slate-200">
                        <div class="text-4xl mb-2">👥</div>
                        Belum ada data peminjam yang mendaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection