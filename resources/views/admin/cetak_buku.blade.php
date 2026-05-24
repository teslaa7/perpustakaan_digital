<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS ini buat ngilangin tombol-tombol pas lagi diprint ke kertas */
        @media print {
            @page { margin: 2cm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-white text-black p-10">

    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8 border-b-4 border-black pb-4">
            <h1 class="text-3xl font-bold uppercase">Perpustakaan Digital Jaya</h1>
            <p class="text-gray-600 mt-1">Jl. Pendidikan No. 123, Kota Pelajar | Telp: (021) 1234567</p>
            <h2 class="text-xl font-bold mt-4 uppercase">Laporan Data Master Buku</h2>
            <p class="text-sm">Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y - H:i') }}</p>
        </div>

        <table class="w-full text-left border-collapse border border-gray-800">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 border border-gray-800 text-center w-12">No</th>
                    <th class="p-3 border border-gray-800">Judul Buku</th>
                    <th class="p-3 border border-gray-800">Penulis</th>
                    <th class="p-3 border border-gray-800">Penerbit</th>
                    <th class="p-3 border border-gray-800 text-center">Tahun</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $index => $item)
                <tr>
                    <td class="p-3 border border-gray-800 text-center">{{ $index + 1 }}</td>
                    <td class="p-3 border border-gray-800 font-bold">{{ $item->Judul }}</td>
                    <td class="p-3 border border-gray-800">{{ $item->Penulis }}</td>
                    <td class="p-3 border border-gray-800">{{ $item->Penerbit }}</td>
                    <td class="p-3 border border-gray-800 text-center">{{ $item->TahunTerbit }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center italic">Tidak ada data buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex justify-end mt-12">
            <div class="text-center">
                <p>Mengetahui,</p>
                <p class="mt-1">Kepala Perpustakaan</p>
                <br><br><br>
                <p class="font-bold underline">{{ auth()->user()->name }}</p>
            </div>
        </div>

        <div class="mt-10 text-center no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded font-bold mr-2">Cetak Ulang</button>
            <a href="{{ url('/admin/buku') }}" class="bg-gray-600 text-white px-6 py-2 rounded font-bold">Kembali</a>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>