<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kategori Buku</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #4A6B4A; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4A6B4A; text-transform: uppercase; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #777; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #85A385; color: white; padding: 12px; text-align: left; font-size: 13px; text-transform: uppercase; }
        td { padding: 10px 12px; border-bottom: 1px solid #E8F0E8; font-size: 13px; color: #444; }
        tr:nth-child(even) { background-color: #F9FBF9; }
        .footer { text-align: right; margin-top: 40px; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Perpus Digital</h2>
        <h2>Laporan Data Kategori Buku</h2>
        <p>Dicetak pada tanggal: {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%; text-align: center;">No</th>
                <th style="width: 25%; text-align: center;">ID Kategori</th>
                <th style="width: 65%;">Nama Kategori Buku</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategori as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center; font-weight: bold; color: #666;">
                        {{-- Logika aman untuk manggil ID --}}
                        REG-00{{ $item->KategoriID ?? $item->id }}
                    </td>
                    <td style="font-weight: bold; color: #222;">
                        {{-- Logika aman untuk manggil Nama --}}
                        {{ $item->NamaKategori ?? $item->nama_kategori }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #999; font-style: italic; padding: 20px;">
                        Belum ada data kategori buku yang tersimpan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Petugas Perpustakaan Perpus Digital</p>
        <br><br><br>
        <p style="font-weight: bold; text-decoration: underline;">_______________________</p>
    </div>

</body>
</html>