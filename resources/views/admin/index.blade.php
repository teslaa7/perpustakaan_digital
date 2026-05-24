@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 relative">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Kelola Peminjaman Buku</h2>
        <p class="text-gray-500 mt-1">Setujui peminjaman dan catat pengembalian buku di sini.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full bg-white">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left w-12">No</th>
                    <th class="py-3 px-4 text-left">Peminjam</th>
                    <th class="py-3 px-4 text-left">Buku</th>
                    <th class="py-3 px-4 text-left">Tgl Pinjam</th>
                    <th class="py-3 px-4 text-left">Tgl Kembali</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Aksi Admin</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse ($peminjaman as $index => $item)
                <tr class="hover:bg-gray-50 border-b text-gray-700">
                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 font-bold">{{ $item->user ? $item->user->name : 'User Dihapus' }}</td>
                    <td class="py-3 px-4 text-blue-700 font-semibold">{{ $item->buku ? $item->buku->Judul : 'Buku Dihapus' }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        {{ $item->TanggalPengembalian ? \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d M Y') : '-' }}
                    </td>
                    <td class="py-3 px-4 text-center">
                        @if($item->StatusPeminjaman == 'menunggu')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Menunggu</span>
                        @elseif($item->StatusPeminjaman == 'dipinjam')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Dipinjam</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 align-middle text-center">
                        <div class="flex justify-center items-center space-x-2">
                            @if($item->StatusPeminjaman == 'menunggu')
                            <form action="{{ route('peminjaman.status', $item->PeminjamanID) }}" method="POST" class="m-0 p-0">
                                @csrf
                                <input type="hidden" name="status" value="dipinjam">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs transition font-bold" onclick="return confirm('Setujui peminjaman ini?')">
                                    Setujui Pinjam
                                </button>
                            </form>
                            @endif

                            @if($item->StatusPeminjaman == 'dipinjam')
                            <form action="{{ route('peminjaman.status', $item->PeminjamanID) }}" method="POST" class="m-0 p-0">
                                @csrf
                                <input type="hidden" name="status" value="dikembalikan">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded text-xs transition font-bold" onclick="return confirm('Buku sudah dikembalikan oleh siswa?')">
                                    Kembalikan Buku
                                </button>
                            </form>
                            @endif

                            @if($item->StatusPeminjaman == 'dikembalikan')
                                <span class="text-gray-400 font-bold text-xs italic">Selesai</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-8 text-center text-gray-500 italic">Belum ada data transaksi peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection