<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Peminjaman</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; line-height: 1.5; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #4A6B4A; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4A6B4A; text-transform: uppercase; font-size: 20px; }
        .header p { margin: 5px 0 0 0; color: #777; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #85A385; color: white; padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #E8F0E8; color: #444; }
        tr:nth-child(even) { background-color: #F9FBF9; }
        .denda { color: #DC3545; font-weight: bold; }
        .status-badge { padding: 3px 6px; border-radius: 4px; font-weight: bold; font-size: 9px; text-transform: uppercase; }
        .footer { text-align: right; margin-top: 40px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Perpus Digital</h2>
        <h2>Laporan Rekapitulasi Transaksi Peminjaman</h2>
        <p>Dicetak pada tanggal: {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 15%;">Nama Peminjam</th>
                <th style="width: 25%;">Judul Buku</th>
                <th style="width: 12%;">Tgl Pinjam</th>
                <th style="width: 12%;">Batas Waktu</th>
                <th style="width: 12%;">Tgl Kembali</th>
                <th style="width: 10%;">Denda</th>
                <th style="width: 9%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $item->user->NamaLengkap ?? $item->user->Username ?? 'User Dihapus' }}</td>
                    <td>{{ $item->buku->Judul ?? 'Buku Dihapus' }}</td>
                    <td>{{ $item->TanggalPeminjaman ? \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d M Y') : '-' }}</td>
                    <td>{{ $item->BatasWaktu ? \Carbon\Carbon::parse($item->BatasWaktu)->format('d M Y') : '-' }}</td>
                    <td>{{ $item->TanggalPengembalian ? \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d M Y') : '-' }}</td>
                    <td class="{{ $item->Denda > 0 ? 'denda' : '' }}">
                        Rp {{ number_format($item->Denda, 0, ',', '.') }}
                    </td>
                    <td style="text-align: center; font-weight: bold;">
                        {{ $item->StatusPeminjaman }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #999; font-style: italic; padding: 20px;">
                        Belum ada data transaksi peminjaman.
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