<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Petugas</title>
    <style>
        /* Reset & Font Dasar */
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #334155; line-height: 1.5; font-size: 12px; }
        
        /* Header Kop Surat */
        .kop-surat { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #4A6B4A; padding-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 24px; color: #4A6B4A; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; }
        
        /* Area Judul */
        .judul-laporan { text-align: center; font-size: 18px; font-weight: bold; color: #2f4f2f; text-transform: uppercase; margin-bottom: 5px; }
        .tanggal-cetak { text-align: center; font-size: 12px; color: #64748b; margin-bottom: 25px; }

        /* Tabel Elegan */
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { padding: 12px; text-align: left; vertical-align: middle; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #85A385; color: #ffffff; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        
        /* Efek Zebra Minimalis */
        tbody tr:nth-child(even) { background-color: #f8fafc; }

        /* Area Tanda Tangan */
        .tanda-tangan { float: right; width: 250px; text-align: center; color: #64748b; }
        .tanda-tangan p { margin: 0; }
        .nama-terang { margin-top: 80px; font-weight: bold; text-decoration: underline; color: #334155; }
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        /* Pewarnaan Khusus Role */
        .role-admin { color: #5b21b6; font-weight: 800; text-transform: uppercase; font-size: 10px; }
        .role-petugas { color: #15803d; font-weight: 800; text-transform: uppercase; font-size: 10px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PERPUS DIGITAL</h1>
    </div>

    <div class="judul-laporan">
        Laporan Data Petugas & Administrator
    </div>
    <div class="tanggal-cetak">
        Dicetak pada tanggal: {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 30%;">Nama Lengkap</th>
                <th style="width: 25%;">Username</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%; text-align: center;">Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petugas as $index => $item)
                <tr>
                    <td class="text-center" style="color: #64748b;">{{ $index + 1 }}</td>
                    
                    <td class="font-bold text-[#334155]">{{ $item->NamaLengkap ?? $item->nama_lengkap ?? '-' }}</td>
                    <td style="color: #475569;">{{ $item->Username ?? $item->username ?? '-' }}</td>
                    <td style="color: #475569;">{{ $item->Email ?? $item->email ?? '-' }}</td>
                    
                    {{-- Kondisi warna teks berdasarkan Role --}}
                    <td class="text-center">
                        @if(strtolower($item->role ?? '') == 'administrator' || strtolower($item->role ?? '') == 'admin')
                            <span class="role-admin">ADMIN</span>
                        @else
                            <span class="role-petugas">PETUGAS</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 30px; font-style: italic; color: #94a3b8;">
                        Belum ada data petugas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p style="margin-bottom: 5px;">Kepala Perpustakaan Perpus Digital</p>
        <div class="nama-terang">Administrator Utama</div>
    </div>

</body>
</html>