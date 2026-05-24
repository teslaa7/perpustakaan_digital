<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Peminjaman</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 10px;
        }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .dashed-line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; padding: 2px 0; }
    </style>
</head>
<body>

    <div class="text-center">
        <h2 style="margin: 0; font-size: 16px;">PERPUS DIGITAL</h2>
        <p style="margin: 2px 0 10px 0; font-size: 10px;">Jl. Pendidikan Raya No. 45<br>Telp: (021) 8892-1234</p>
    </div>

    <div class="dashed-line"></div>

    <table>
        <tr>
            <td style="width: 35%;">No. TRX</td>
            <td style="width: 5%;">:</td>
            <td style="width: 60%;">TRX-00{{ $peminjaman->PeminjamanID }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Petugas</td>
            <td>:</td>
            <td>Sistem Otomatis</td>
        </tr>
    </table>

    <div class="dashed-line"></div>
    <div class="text-center bold" style="margin-bottom: 5px;">DETAIL PEMINJAMAN</div>
    
    <table>
        <tr>
            <td style="width: 35%;">Peminjam</td>
            <td style="width: 5%;">:</td>
            <td style="width: 60%; font-weight: bold;">{{ $peminjaman->NamaLengkap ?? $peminjaman->Username }}</td>
        </tr>
        <tr>
            <td>Judul</td>
            <td>:</td>
            <td>{{ $peminjaman->Judul }}</td>
        </tr>
        <tr>
            <td>Pinjam</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($peminjaman->TanggalPeminjaman)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td>:</td>
            <td>{{ $peminjaman->TanggalPengembalian ? \Carbon\Carbon::parse($peminjaman->TanggalPengembalian)->format('d M Y') : '-' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td class="bold">
                @if($peminjaman->StatusPeminjaman == 'Dikembalikan')
                    [ SELESAI ]
                @elseif($peminjaman->StatusPeminjaman == 'Ditolak')
                    [ DITOLAK ]
                @elseif($peminjaman->StatusPeminjaman == 'Pending')
                    [ WAIT ACC ]
                @else
                    [ DIPINJAM ]
                @endif
            </td>
        </tr>
    </table>

    <div class="dashed-line"></div>

    <div class="text-center" style="margin-top: 15px;">
        <p style="margin: 0; font-size: 10px;">Terima kasih telah menggunakan<br>layanan Perpus Digital.</p>
        <p style="margin: 5px 0 0 0; font-size: 9px;">Harap simpan struk ini sebagai<br>bukti transaksi yang sah.</p>
    </div>

</body>
</html>