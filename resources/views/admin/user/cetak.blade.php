<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Anggota</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #4A6B4A; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4A6B4A; text-transform: uppercase; font-size: 20px; }
        .header p { margin: 5px 0 0 0; color: #777; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #85A385; color: white; padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #E8F0E8; color: #444; }
        tr:nth-child(even) { background-color: #F9FBF9; }
        .footer { text-align: right; margin-top: 40px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Perpus Digital</h2>
        <h2>Laporan Data Anggota (Peminjam)</h2>
        <p>Dicetak pada tanggal: {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 25%;">Nama Lengkap</th>
                <th style="width: 20%;">Username</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 25%;">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $item->NamaLengkap ?? '-' }}</td>
                    <td>{{ $item->Username ?? '-' }}</td>
                    <td>{{ $item->Email ?? '-' }}</td>
                    <td>{{ $item->Alamat ?? 'Tidak ada data alamat' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999; font-style: italic; padding: 20px;">
                        Belum ada data anggota yang terdaftar.
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