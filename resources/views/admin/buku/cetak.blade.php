<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpus Digital</title>
    <style>
        /* CSS Khusus Kertas Cetak (Hemat Tinta & Rapi) */
        body { 
            font-family: 'Times New Roman', Times, serif; 
            color: #000; 
            line-height: 1.5; 
            margin: 0 auto;
            max-width: 21cm; /* Ukuran kertas A4 */
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 3px double #000; 
            padding-bottom: 10px; 
        }
        .header h2 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 14px; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            font-size: 12px; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 8px 10px; 
            text-align: left; 
            vertical-align: top;
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold; 
            text-transform: uppercase; 
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        
        .footer {
            margin-top: 40px;
            width: 100%;
            text-align: right;
            font-size: 14px;
        }
        .ttd {
            display: inline-block;
            text-align: center;
            margin-right: 30px;
        }

        /* Hilangkan elemen yang nggak perlu pas di-print */
        @media print {
            @page { margin: 2cm; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Katalog Buku Perpustakaan</h2>
        <p>Laporan Ketersediaan Data Buku Digital</p>
        <p style="font-size: 12px; margin-top: 10px;">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Judul Buku</th>
                <th style="width: 20%;">Penulis</th>
                <th style="width: 20%;">Penerbit</th>
                <th style="width: 10%;">Tahun</th>
                <th style="width: 15%;">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buku as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-bold">{{ $item->Judul }}</td>
                    <td>{{ $item->Penulis }}</td>
                    <td>{{ $item->Penerbit }}</td>
                    <td class="text-center">{{ $item->TahunTerbit }}</td>
                    <td>
                        @forelse($item->kategori as $kat)
                            {{ $kat->NamaKategori }}{{ !$loop->last ? ', ' : '' }}
                        @empty
                            -
                        @endforelse
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Data buku belum tersedia di katalog.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Mengetahui,</p>
            <br><br><br><br>
            <p class="text-bold">Admin Perpustakaan</p>
        </div>
    </div>

</body>
</html>