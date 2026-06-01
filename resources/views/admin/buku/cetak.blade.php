<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Buku</title>
    <style>
        /* CSS SAMA PERSIS KAYA DI ATAS */
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #334155; line-height: 1.5; font-size: 11px; }
        .kop-surat { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #4A6B4A; padding-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 26px; color: #4A6B4A; font-weight: bold; letter-spacing: 1px; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 13px; color: #64748b; }
        .judul-laporan { text-align: center; font-size: 16px; font-weight: bold; color: #1e293b; text-transform: uppercase; margin-bottom: 5px; }
        .tanggal-cetak { text-align: center; font-size: 11px; color: #94a3b8; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { padding: 8px 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #4A6B4A; color: #ffffff; text-transform: uppercase; font-size: 10px; }
        tbody tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .tanda-tangan { float: right; width: 250px; text-align: center; }
        .nama-terang { margin-top: 80px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h1>PERPUSTAKAAN DIGITAL</h1>
        <p>Jl. Literasi Bangsa No. 123, Kota Cerdas, Kode Pos 12345</p>
    </div>
    <div class="judul-laporan">Laporan Data Buku</div>
    <div class="tanggal-cetak">Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y - H:i') }} WIB</div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 30%;">Judul Buku</th>
                <th style="width: 20%;">Penulis</th>
                <th style="width: 20%;">Penerbit</th>
                <th style="width: 10%; text-align: center;">Tahun</th>
                <th style="width: 15%; text-align: center;">Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buku as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: #4A6B4A;">{{ $item->Judul ?? '-' }}</td>
                    <td>{{ $item->Penulis ?? '-' }}</td>
                    <td>{{ $item->Penerbit ?? '-' }}</td>
                    <td class="text-center">{{ $item->TahunTerbit ?? '-' }}</td>
                    <td class="text-center font-bold">{{ $item->Stok ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Belum ada data buku.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p>Mengetahui,</p>
        <p>Kepala Perpustakaan</p>
        <div class="nama-terang">Administrator Utama</div>
    </div>
</body>
</html>