<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Ulasan</title>
    <style>
        /* Reset & Font Dasar (Modern Clean) */
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            color: #334155; 
            line-height: 1.5; 
            font-size: 12px; 
        }
        
        /* Header Kop Surat */
        .kop-surat { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 3px solid #4A6B4A; 
            padding-bottom: 20px; 
        }
        .kop-surat h1 { 
            margin: 0; 
            font-size: 26px; 
            color: #4A6B4A; 
            font-weight: bold; 
            letter-spacing: 1px; 
        }
        .kop-surat p { 
            margin: 5px 0 0 0; 
            font-size: 13px; 
            color: #64748b; 
        }

        /* Area Judul */
        .judul-laporan { 
            text-align: center; 
            font-size: 16px; 
            font-weight: bold; 
            color: #1e293b; 
            text-transform: uppercase; 
            margin-bottom: 5px; 
        }
        .tanggal-cetak { 
            text-align: center; 
            font-size: 11px; 
            color: #94a3b8; 
            margin-bottom: 25px; 
        }

        /* Tabel Elegan */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 40px; 
        }
        th, td { 
            padding: 10px 12px; 
            text-align: left; 
            vertical-align: middle; 
            border-bottom: 1px solid #e2e8f0; 
        }
        th { 
            background-color: #4A6B4A; 
            color: #ffffff; 
            text-transform: uppercase; 
            font-size: 11px; 
            letter-spacing: 0.5px; 
        }
        /* Efek Zebra (Belang-belang tipis di baris tabel) */
        tbody tr:nth-child(even) { 
            background-color: #f8fafc; 
        }
        
        /* Badge untuk Rating */
        .badge {
            background-color: #EEF4EE;
            color: #4A6B4A;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
        }

        /* Area Tanda Tangan */
        .tanda-tangan { 
            float: right; 
            width: 250px; 
            text-align: center; 
        }
        .tanda-tangan p { 
            margin: 0; 
            color: #334155; 
        }
        .nama-terang { 
            margin-top: 80px; 
            font-weight: bold; 
            text-decoration: underline; 
        }
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .text-green { color: #4A6B4A; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PERPUSTAKAAN DIGITAL</h1>
        <p>Jl. Literasi Bangsa No. 123, Kota Cerdas, Kode Pos 12345</p>
        <p>Email: info@perpusdigital.com &nbsp;|&nbsp; Telp: (021) 1234-5678</p>
    </div>

    <div class="judul-laporan">
        Laporan Data Ulasan & Rating Buku
    </div>
    <div class="tanggal-cetak">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y - H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 20%;">Peminjam</th>
                <th style="width: 25%;">Judul Buku</th>
                <th style="width: 40%;">Isi Ulasan</th>
                <th style="width: 10%; text-align: center;">Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ulasan as $index => $item)
                <tr>
                    <td class="text-center font-bold" style="color: #64748b;">{{ $index + 1 }}</td>
                    
                    <td class="font-bold">{{ $item->NamaLengkap ?? $item->Username ?? $item->username ?? '-' }}</td>
                    <td class="text-green font-bold">{{ $item->Judul ?? $item->judul ?? '-' }}</td>
                    <td style="font-style: italic; color: #64748b;">"{{ $item->Ulasan ?? $item->ulasan ?? '-' }}"</td>
                    <td class="text-center">
                        <span class="badge">⭐ {{ $item->Rating ?? $item->rating ?? 0 }}/5</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 30px; font-style: italic; color: #94a3b8;">
                        Belum ada data ulasan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p>Mengetahui,</p>
        <p style="margin-bottom: 5px;">Kepala Perpustakaan</p>
        <div class="nama-terang">Administrator Utama</div>
        <p>NIP. 19800101 200501 1 001</p>
    </div>

</body>
</html>