<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kategori Buku</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #334155; line-height: 1.5; font-size: 12px; }
        .kop-surat { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #4A6B4A; padding-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 26px; color: #4A6B4A; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;}
        .kop-surat p { margin: 5px 0 0 0; font-size: 13px; color: #64748b; }
        .judul-laporan { text-align: center; font-size: 16px; font-weight: bold; color: #1e293b; text-transform: uppercase; margin-bottom: 5px; }
        .tanggal-cetak { text-align: center; font-size: 11px; color: #94a3b8; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { padding: 10px 12px; text-align: left; vertical-align: middle; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #4A6B4A; color: #ffffff; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        tbody tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .tanda-tangan { float: right; width: 250px; text-align: center; }
        .tanda-tangan p { margin: 0; color: #334155; }
        .nama-terang { margin-top: 80px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h1>PERPUSTAKAAN DIGITAL</h1>
        <p>Jl. Literasi Bangsa No. 123, Kota Cerdas, Kode Pos 12345</p>
    </div>
    <div class="judul-laporan">Laporan Data Kategori Buku</div>
    <div class="tanggal-cetak">Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y - H:i') }} WIB</div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%; text-align: center;">No</th>
                <th style="width: 90%;">Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategori as $index => $item)
                <tr>
                    <td class="text-center font-bold">{{ $index + 1 }}</td>
                    <td class="font-bold text-[#4A6B4A]">{{ $item->NamaKategori ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">Belum ada data kategori.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p>Mengetahui,</p>
        <p style="margin-bottom: 5px;">Kepala Perpustakaan</p>
        <div class="nama-terang">Administrator Utama</div>
    </div>
</body>
</html>