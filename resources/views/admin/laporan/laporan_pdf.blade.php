<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Perpus Digital</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        /* DESAIN KOP SURAT ASLI */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .kop-surat h1 {
            margin: 0;
            color: #4A6B4A;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: 900;
            letter-spacing: 1px;
        }
        .kop-surat h2 {
            margin: 2px 0;
            color: #333;
            font-size: 14px;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 2px 0 0 0;
            color: #666;
            font-size: 10px;
            font-style: italic;
        }
        .garis-kop {
            border: none;
            border-top: 2px solid #4A6B4A;
            border-bottom: 1px solid #4A6B4A;
            height: 3px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        /* TABEL STATISTIK RINGKASAN */
        .table-info {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .table-info td {
            border: none;
            padding: 2px 0;
        }
        /* TABEL UTAMA LAPORAN */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        table.main-table th, table.main-table td {
            border: 1px solid #B0C8B0;
            padding: 8px 6px;
            text-align: left;
        }
        table.main-table th {
            background-color: #85A385;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            text-align: center;
        }
        table.main-table tr:nth-child(even) {
            background-color: #F9FBF9;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        /* STRUKTUR TANDA TANGAN (MEMAKAI TABEL BIAR GA BERANTAKAN DI DOMPDF) */
        .ttd-container {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ttd-table td {
            border: none;
            text-align: center;
            width: 50%;
            font-size: 11px;
        }
        .space-ttd {
            height: 70px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PERPUSTAKAAN DIGITAL ASSOCIATION</h1>
        <h2>PANEL PENGELOLA PUSAT DATA LITERASI</h2>
        <p>Jl. Pendidikan Raya No. 45, Blok G, Jakarta Pusat | Telp: (021) 8892-1234 | Email: info@perpusdigital.com</p>
        <div class="garis-kop"></div>
    </div>

    <div style="text-align: center; margin-bottom: 25px;">
        <h3 style="margin: 0; font-size: 14px; text-transform: uppercase; text-decoration: underline; color: #1a1a1a;">
            LAPORAN REKAPITULASI PEMINJAMAN BUKU
        </h3>
        <p style="margin: 5px 0 0 0; color: #555; font-size: 11px;">
            @if($tgl_awal && $tgl_akhir)
                Periode Tanggal: <strong>{{ \Carbon\Carbon::parse($tgl_awal)->format('d M Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($tgl_akhir)->format('d M Y') }}</strong>
            @else
                Periode Tanggal: <strong>Seluruh Riwayat Transaksi (All Time)</strong>
            @endif
        </p>
    </div>

    <table class="table-info">
        <tr>
            <td style="width: 15%;">Tanggal Cetak</td>
            <td style="width: 2%;">:</td>
            <td style="width: 48%;">{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</td>
            <td style="width: 18%;">Total Transaksi</td>
            <td style="width: 2%;">:</td>
            <td style="width: 15%; font-weight: bold;">{{ $peminjaman->count() }} Data</td>
        </tr>
        <tr>
            <td>Dicetak Oleh</td>
            <td>:</td>
            <td>{{ auth()->user()->NamaLengkap ?? auth()->user()->Username ?? 'Administrator' }} (Admin)</td>
            <td>Status Dokumen</td>
            <td>:</td>
            <td style="color: #4A6B4A; font-weight: bold;">SAH / RESMI</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 23%;">Nama Peminjam</th>
                <th style="width: 27%;">Judul Buku</th>
                <th class="text-center" style="width: 15%;">Tanggal Pinjam</th>
                <th class="text-center" style="width: 15%;">Tanggal Kembali</th>
                <th class="text-center" style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $item->NamaLengkap ?? $item->Username ?? 'User Dihapus' }}</strong></td>
                    <td>{{ $item->Judul ?? 'Buku Dihapus' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        {{ $item->TanggalPengembalian ? \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center" style="font-weight: bold; font-size: 10px;">
                        {{ strtoupper($item->StatusPeminjaman) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 30px; color: #7DA07D; font-weight: bold;">
                        Tidak ditemukan data transaksi peminjaman pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td>
                    <br>
                    Keamanan & Data Pusat,<br>
                    <div class="space-ttd"></div>
                    <strong>Sistem PerpusDigital Core</strong><br>
                    <span style="font-size: 9px; color: #666;">Verified Automatical Server</span>
                </td>
                <td>
                    Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    Kepala Pengelola Perpustakaan,<br>
                    <div class="space-ttd"></div>
                    <strong style="text-decoration: underline;">{{ auth()->user()->NamaLengkap ?? 'H. Ahmad Syahroni, M.Kom.' }}</strong><br>
                    <span>NIP. 19890311 201504 1 002</span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>