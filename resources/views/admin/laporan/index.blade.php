@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-[#E8F0E8] p-6 relative w-full">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b border-[#E8F0E8] pb-4 gap-4">
        <div class="w-full">
            <h2 class="text-2xl font-black text-[#4A6B4A]">Generate Laporan Peminjaman</h2>
            <p class="text-[#7DA07D] mt-1 text-sm font-medium">Cetak laporan transaksi perpustakaan berdasarkan periode tanggal.</p>
        </div>
    </div>

    <form action="{{ route('laporan.cetak') }}" method="POST" class="space-y-6 w-full">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
            <div class="w-full">
                <label class="block text-sm font-black mb-2 text-[#5C805C]">Mulai Tanggal</label>
                <input type="date" name="tgl_awal" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl focus:ring-2 focus:ring-[#85A385] outline-none bg-slate-50 transition-all text-slate-700 cursor-pointer shadow-sm">
            </div>

            <div class="w-full">
                <label class="block text-sm font-black mb-2 text-[#5C805C]">Sampai Tanggal</label>
                <input type="date" name="tgl_akhir" class="w-full px-4 py-3 border border-[#C8DAC8] rounded-xl focus:ring-2 focus:ring-[#85A385] outline-none bg-slate-50 transition-all text-slate-700 cursor-pointer shadow-sm">
            </div>
        </div>

        <div class="bg-[#F4F9F4] border border-[#C8DAC8] text-[#5C805C] p-4 rounded-xl text-sm mb-6 flex items-start gap-3 shadow-sm w-full">
            <div class="mt-0.5">
                <svg class="w-5 h-5 text-[#85A385]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="font-black block mb-0.5 text-[#4A6B4A]">Informasi Penting:</span>
                Kosongkan kedua tanggal di atas jika Anda ingin mencetak <b class="text-[#4A6B4A]">seluruh</b> riwayat peminjaman dari awal aplikasi berjalan.
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-[#E8F0E8] w-full">
            <button type="submit" class="bg-[#85A385] hover:bg-[#5C805C] text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2 text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Laporan</span>
            </button>
        </div>
    </form>
</div>
@endsection