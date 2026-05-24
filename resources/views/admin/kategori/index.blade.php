@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-[#E8F0E8] p-6 relative">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-[#E8F0E8] pb-4 gap-4">
        <div>
            <h2 class="text-2xl font-black text-[#4A6B4A]">Kelola Kategori Buku</h2>
            <p class="text-[#7DA07D] mt-1 text-sm font-medium">Atur klasifikasi dan jenis buku perpustakaan di sini.</p>
        </div>
        
        {{-- KUMPULAN TOMBOL AKSI (CETAK PDF & TAMBAH) --}}
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            
            {{-- TOMBOL CETAK PDF (Ditaruh di luar, sejajar sama Tambah Kategori) --}}
            <a href="{{ route('kategori.pdf') }}" class="flex-1 md:flex-none bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Cetak PDF
            </a>

            <button onclick="openModal('tambah')" class="flex-1 md:flex-none bg-[#85A385] hover:bg-[#5C805C] text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                + Tambah Kategori
            </button>
            
        </div>
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
                    <th class="py-4 px-5 font-black w-16 text-center">No</th>
                    <th class="py-4 px-5 font-black">Nama Kategori</th>
                    <th class="py-4 px-5 font-black text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E8F0E8]">
                @forelse ($kategori ?? $kategoris as $item)
                <tr class="hover:bg-[#F9FBF9] transition-colors duration-200">
                    <td class="py-4 px-5 text-center font-semibold text-slate-500">{{ $loop->iteration }}</td>
                    
                    <td class="py-4 px-5 font-extrabold text-slate-800 text-lg">
                        {{ $item->NamaKategori ?? $item->nama_kategori }}
                    </td>
                    
                    <td class="py-4 px-5 align-middle">
                        <div class="flex justify-center gap-2">
                            <button onclick="openEditModal('{{ $item->KategoriID ?? $item->id }}', '{{ addslashes($item->NamaKategori ?? $item->nama_kategori) }}')"
                                    class="bg-[#C8DAC8] hover:bg-[#85A385] text-[#4A6B4A] hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                Edit
                            </button>

                            <form action="{{ route('kategori.destroy', $item->KategoriID ?? $item->id) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                    <td colspan="3" class="py-12 text-center text-slate-400 font-medium bg-slate-50 border-dashed border-2 border-slate-200">
                        <div class="text-4xl mb-2">📁</div>
                        Belum ada kategori buku yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="tambahModal" class="fixed inset-0 bg-gray-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">
        <h3 class="text-2xl font-black mb-6 text-[#4A6B4A] border-b-2 border-[#E8F0E8] pb-3">Tambah Kategori Baru</h3>
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-black mb-2 text-[#5C805C]">Nama Kategori</label>
                <input type="text" name="NamaKategori" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required placeholder="Contoh: Fiksi, Sains, dll">
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('tambah')" class="px-6 py-2.5 bg-slate-100 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-[#85A385] text-white rounded-xl font-bold hover:bg-[#5C805C] transition-colors shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-gray-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">
        <h3 class="text-2xl font-black mb-6 text-[#4A6B4A] border-b-2 border-[#E8F0E8] pb-3">Edit Kategori</h3>
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label class="block text-sm font-black mb-2 text-[#5C805C]">Nama Kategori</label>
                <input type="text" name="NamaKategori" id="editNamaKategori" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit')" class="px-6 py-2.5 bg-slate-100 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-yellow-500 text-white rounded-xl font-bold hover:bg-yellow-600 transition-colors shadow-md">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(type) {
        document.getElementById(type + 'Modal').classList.remove('hidden');
    }

    function closeModal(type) {
        document.getElementById(type + 'Modal').classList.add('hidden');
    }

    function openEditModal(id, nama) {
        const form = document.getElementById('formEdit');
        form.action = `/admin/kategori/${id}`; 
        
        document.getElementById('editNamaKategori').value = nama;
        
        openModal('edit');
    }
</script>
@endsection