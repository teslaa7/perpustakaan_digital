@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-[#E8F0E8] p-6 relative">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b border-[#E8F0E8] pb-4 gap-4">
        <div>
            <h2 class="text-2xl font-black text-[#4A6B4A]">Katalog Buku Digital</h2>
            <p class="text-[#7DA07D] text-sm font-medium mt-1">Kelola data buku, sampul, sinopsis, dan stok.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('buku.pdf') }}" class="bg-[#4A6B4A] hover:bg-[#385238] text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh PDF
            </a>
            
            <button onclick="openModal('tambah')" class="bg-[#85A385] hover:bg-[#5C805C] text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Buku
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <p class="text-red-700 font-bold mb-1">Upload Gagal! Perhatikan hal berikut:</p>
            <ul class="list-disc ml-5 text-sm text-red-600">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-[#F4F9F4] border-l-4 border-[#5C805C] text-[#4A6B4A] font-bold p-4 mb-6 rounded-r-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-[#E8F0E8]">
        <table class="min-w-full bg-white text-left">
            <thead class="bg-[#F4F9F4] text-[#4A6B4A] text-sm uppercase tracking-wider">
                <tr>
                    <th class="py-4 px-5 font-black w-20">Cover</th>
                    <th class="py-4 px-5 font-black">Informasi Buku</th>
                    <th class="py-4 px-5 font-black text-center w-24">Stok</th>
                    <th class="py-4 px-5 font-black text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E8F0E8]">
                @forelse ($buku as $item)
                <tr class="hover:bg-[#F9FBF9] transition-colors duration-200">
                    <td class="py-4 px-5">
                        @if($item->Cover)
                            <img src="{{ asset('covers/' . $item->Cover) }}" class="w-14 h-20 object-cover rounded-lg shadow-sm border border-[#C8DAC8]">
                        @else
                            <div class="w-14 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-[10px] font-bold text-gray-400 border border-dashed border-gray-300">Kosong</div>
                        @endif
                    </td>
                    <td class="py-4 px-5">
                        <div class="font-extrabold text-slate-800 text-lg mb-1">{{ $item->Judul }}</div>
                        <div class="text-[#5C805C] font-semibold text-xs mb-2">
                            ✍️ {{ $item->Penulis }} <span class="mx-1 text-gray-300">|</span> 🏢 {{ $item->Penerbit }} ({{ $item->TahunTerbit }})
                        </div>
                        
                        <div class="flex flex-wrap gap-1">
                            @forelse($item->kategori as $kat)
                                <span class="bg-[#E8F0E8] text-[#4A6B4A] px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider">
                                    {{ $kat->NamaKategori }}
                                </span>
                            @empty
                                <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider">
                                    Tanpa Kategori
                                </span>
                            @endforelse
                        </div>
                    </td>
                    
                    {{-- DESAIN STOK BARU: ANGKA POLOS TEBAL BIAR GAK KELIATAN KAYAK TOMBOL --}}
                    <td class="py-4 px-5 text-center align-middle">
                        @if($item->Stok > 0)
                            <div class="text-slate-700 font-black text-2xl leading-none">{{ $item->Stok }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Buku</div>
                        @else
                            <div class="text-red-500 font-black text-2xl leading-none">0</div>
                            <div class="text-[10px] font-bold text-red-500 uppercase tracking-widest mt-1">Habis</div>
                        @endif
                    </td>

                    <td class="py-4 px-5 align-middle">
                        <div class="flex justify-center gap-2">
                            <button onclick="openEditModal('{{ $item->BukuID }}', '{{ addslashes($item->Judul) }}', '{{ addslashes($item->Penulis) }}', '{{ addslashes($item->Penerbit) }}', '{{ $item->TahunTerbit }}', '{{ $item->kategori->first()->KategoriID ?? '' }}', '{{ $item->Stok }}', `{{ addslashes($item->Sinopsis) }}`)"
                                    class="bg-[#C8DAC8] hover:bg-[#85A385] text-[#4A6B4A] hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                Edit
                            </button>
                            <form action="{{ route('buku.destroy', $item->BukuID) }}" method="POST" onsubmit="return confirm('Yakin mau hapus buku ini? Gambar cover juga akan terhapus lho!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-[#F8D7DA] hover:bg-[#DC3545] text-[#721C24] hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-12 text-center text-slate-400 font-medium">Buku belum tersedia di katalog.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH BUKU --}}
<div id="tambahModal" class="fixed inset-0 bg-gray-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-8 max-h-[90vh] overflow-y-auto">
        <h3 class="text-2xl font-black mb-6 text-[#4A6B4A] border-b-2 border-[#E8F0E8] pb-3">Tambah Buku Baru</h3>
        
        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Upload Cover (WAJIB, JPG/PNG)</label>
                    <input type="file" name="Cover" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:font-bold file:bg-[#E8F0E8] file:text-[#4A6B4A] hover:file:bg-[#C8DAC8] transition-all cursor-pointer bg-slate-50 border border-slate-200 rounded-xl" required>
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Judul Buku</label>
                    <input type="text" name="Judul" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Penulis</label>
                        <input type="text" name="Penulis" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Penerbit</label>
                        <input type="text" name="Penerbit" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Tahun Terbit</label>
                        <input type="number" name="TahunTerbit" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
                    </div>
                    
                    {{-- INPUT STOK --}}
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Jumlah Stok</label>
                        <input type="number" name="Stok" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required min="0" value="0">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Kategori</label>
                        <select name="KategoriID" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50 font-semibold text-slate-700" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->KategoriID }}">{{ $k->NamaKategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Sinopsis Buku</label>
                    <textarea name="Sinopsis" rows="3" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" placeholder="Ceritakan singkat tentang buku ini..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('tambah')" class="px-6 py-2.5 bg-slate-100 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-[#85A385] text-white rounded-xl font-bold hover:bg-[#5C805C] transition-colors shadow-md">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT BUKU --}}
<div id="editModal" class="fixed inset-0 bg-gray-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-8 max-h-[90vh] overflow-y-auto">
        <h3 class="text-2xl font-black mb-6 text-[#4A6B4A] border-b-2 border-[#E8F0E8] pb-3">Edit Data Buku</h3>
        
        <form id="formEdit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Ganti Cover <span class="text-slate-400 font-normal text-xs">(Abaikan jika tidak diganti)</span></label>
                    <input type="file" name="Cover" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:font-bold file:bg-[#E8F0E8] file:text-[#4A6B4A] hover:file:bg-[#C8DAC8] transition-all cursor-pointer bg-slate-50 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Judul Buku</label>
                    <input type="text" name="Judul" id="editJudul" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Penulis</label>
                        <input type="text" name="Penulis" id="editPenulis" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Penerbit</label>
                        <input type="text" name="Penerbit" id="editPenerbit" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Tahun Terbit</label>
                        <input type="number" name="TahunTerbit" id="editTahun" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required>
                    </div>
                    
                    {{-- INPUT STOK DI EDIT --}}
                    <div>
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Jumlah Stok</label>
                        <input type="number" name="Stok" id="editStok" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" required min="0">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-black mb-2 text-[#5C805C]">Kategori</label>
                        <select name="KategoriID" id="editKategori" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50 font-semibold text-slate-700" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->KategoriID }}">{{ $k->NamaKategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Sinopsis Buku</label>
                    <textarea name="Sinopsis" id="editSinopsis" rows="3" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50" placeholder="Ceritakan singkat tentang buku ini..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit')" class="px-6 py-2.5 bg-slate-100 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-yellow-500 text-white rounded-xl font-bold hover:bg-yellow-600 transition-colors shadow-md">Update Buku</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(type) { document.getElementById(type + 'Modal').classList.remove('hidden'); }
    function closeModal(type) { document.getElementById(type + 'Modal').classList.add('hidden'); }

    // Logic kirim data ke Modal Edit
    function openEditModal(id, judul, penulis, penerbit, tahun, kategoriId, stok, sinopsis) {
        document.getElementById('formEdit').action = `/admin/buku/${id}`; 
        document.getElementById('editJudul').value = judul;
        document.getElementById('editPenulis').value = penulis;
        document.getElementById('editPenerbit').value = penerbit;
        document.getElementById('editTahun').value = tahun;
        document.getElementById('editKategori').value = kategoriId;
        
        // Masukin stok ke form
        document.getElementById('editStok').value = stok; 
        
        document.getElementById('editSinopsis').value = sinopsis;
        openModal('edit');
    }
</script>
@endsection