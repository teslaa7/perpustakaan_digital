@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-[#E8F0E8] p-6 relative">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-[#E8F0E8] pb-4 gap-4">   
    <div>
        <h2 class="text-2xl font-black text-[#4A6B4A]">Manajemen Petugas</h2>
        <p class="text-[#7DA07D] mt-1 text-sm font-medium">Kelola hak akses untuk petugas perpustakaan.</p>
    </div>

    {{-- TOMBOL AKSI: CETAK PDF & TAMBAH PETUGAS --}}
    <div class="flex items-center gap-3 w-full md:w-auto justify-end">
        
        {{-- TOMBOL CETAK PDF --}}
        <a href="{{ route('petugas.pdf') }}"
           class="shrink-0 bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Cetak PDF
        </a>

        {{-- TOMBOL TAMBAH PETUGAS --}}
        <button onclick="openModal('tambah')"
                class="shrink-0 bg-[#85A385] hover:bg-[#5C805C] text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2 whitespace-nowrap">
            + Tambah Petugas
        </button>
    </div>
</div>

    @if(session('success'))
        <div class="bg-[#F4F9F4] border-l-4 border-[#5C805C] text-[#4A6B4A] font-bold p-4 mb-6 rounded-r-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-[#F8D7DA] border-l-4 border-[#DC3545] text-[#721C24] font-bold p-4 mb-6 rounded-r-lg shadow-sm">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-[#E8F0E8]">
        <table class="min-w-full bg-white text-left">
            <thead class="bg-[#F4F9F4] text-[#4A6B4A] text-sm uppercase tracking-wider">
                <tr>
                    <th class="py-4 px-5 font-black w-12 text-center">No</th>
                    <th class="py-4 px-5 font-black">Nama Lengkap</th>
                    <th class="py-4 px-5 font-black">Info Akun</th>
                    <th class="py-4 px-5 font-black text-center">Role</th>
                    <th class="py-4 px-5 font-black text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E8F0E8] text-sm">
                @forelse ($petugas as $item)
                <tr class="hover:bg-[#F9FBF9] transition-colors duration-200">
                    <td class="py-4 px-5 text-center font-semibold text-slate-500">{{ $loop->iteration }}</td>
                    
                    <td class="py-4 px-5 font-extrabold text-slate-800 text-base">
                        {{ $item->NamaLengkap }}
                    </td>
                    
                    <td class="py-4 px-5">
                        <span class="text-[#4A6B4A] font-black block">{{ '@' . $item->Username }}</span>
                        <span class="text-slate-500 font-medium text-xs">{{ $item->Email }}</span>
                    </td>
                    
                    <td class="py-4 px-5 text-center">
                        @if($item->role == 'admin')
                            <span class="bg-purple-50 text-purple-600 border border-purple-200 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">Admin</span>
                        @else
                            <span class="bg-[#E8F0E8] text-[#4A6B4A] border border-[#C8DAC8] px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">Petugas</span>
                        @endif
                    </td>
                    <td class="py-4 px-5 align-middle text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <button onclick="openEditModal('{{ $item->UserID }}', '{{ $item->Username }}', '{{ addslashes($item->NamaLengkap) }}', '{{ $item->Email }}')"
                                    class="bg-[#C8DAC8] hover:bg-[#85A385] text-[#4A6B4A] hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                Edit
                            </button>

                            <form action="{{ route('petugas.destroy', $item->UserID) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
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
                        <div class="text-4xl mb-2">👮‍♂️</div>
                        Belum ada data petugas yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="tambahModal" class="fixed inset-0 bg-gray-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">
        <h3 class="text-2xl font-black mb-6 text-[#4A6B4A] border-b-2 border-[#E8F0E8] pb-3">Tambah Petugas Baru</h3>
        <form action="{{ route('petugas.store') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Username</label>
                    <input type="text" name="username" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50 text-slate-700" required>
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Nama Lengkap</label>
                    <input type="text" name="nama" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50 text-slate-700" required>
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50 text-slate-700" required>
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl outline-none focus:ring-2 focus:ring-[#85A385] bg-slate-50 text-slate-700" required placeholder="Minimal 6 karakter">
                </div>
                
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Role / Akses</label>
                    <select name="role" class="w-full px-4 py-3 border border-[#E8F0E8] rounded-xl bg-slate-100 text-slate-500 font-bold focus:outline-none pointer-events-none cursor-not-allowed" required>
                        <option value="petugas" selected>Petugas</option>
                    </select>
                    <p class="text-[10px] text-slate-400 mt-1.5 font-medium italic">*Admin hanya dapat menambahkan level petugas</p>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('tambah')" class="px-6 py-2.5 bg-slate-100 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-[#85A385] text-white rounded-xl font-bold hover:bg-[#5C805C] transition-colors shadow-md">Simpan Petugas</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-gray-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-all">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">
        <h3 class="text-2xl font-black mb-6 text-[#4A6B4A] border-b-2 border-[#E8F0E8] pb-3">Edit Data Petugas</h3>
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-black mb-2 text-slate-400">Username <span class="text-[10px] font-normal">(Tidak bisa diubah)</span></label>
                    <input type="text" name="username" id="editUsername" class="w-full px-4 py-3 border border-[#E8F0E8] rounded-xl bg-slate-100 text-slate-500 font-bold outline-none cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Nama Lengkap</label>
                    <input type="text" name="nama" id="editNama" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl focus:ring-2 focus:ring-[#85A385] outline-none bg-slate-50 text-slate-700" required>
                </div>
                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Email</label>
                    <input type="email" name="email" id="editEmail" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl focus:ring-2 focus:ring-[#85A385] outline-none bg-slate-50 text-slate-700" required>
                </div>
                
                <div>
                    <label class="block text-sm font-black mb-2 text-slate-400">Role / Akses</label>
                    <select name="role" class="w-full px-4 py-3 border border-[#E8F0E8] rounded-xl bg-slate-100 text-slate-500 font-bold focus:outline-none pointer-events-none cursor-not-allowed" required>
                        <option value="petugas" selected>Petugas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-black mb-2 text-[#5C805C]">Ganti Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl focus:ring-2 focus:ring-[#85A385] outline-none bg-slate-50 text-slate-700" placeholder="Ketik password baru">
                    <p class="text-[10px] text-red-400 mt-1.5 font-medium italic">*Kosongkan kotak ini jika password tidak ingin diganti</p>
                </div>
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

    function openEditModal(id, username, nama, email) {
        const form = document.getElementById('formEdit');
        form.action = `/admin/petugas/${id}`; 
        
        document.getElementById('editUsername').value = username;
        document.getElementById('editNama').value = nama;
        document.getElementById('editEmail').value = email;
        
        openModal('edit');
    }
</script>
@endsection