<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Proyek</title>
     <?php
    // Set locale ke Bahasa Indonesia
    \Carbon\Carbon::setLocale('id');
    $tanggal_sekarang = \Carbon\Carbon::now()->locale('id');
    ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 10pt;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 5px;
        }
        .table-proyek {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table-proyek th {
            background-color: #343a40;
            color: white;
            padding: 8px;
            text-align: center;
            border: 1px solid #333;
            font-size: 10pt;
        }
        .table-proyek td {
            padding: 6px 8px;
            border: 1px solid #333;
            font-size: 9pt;
        }
        .table-proyek tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .tanda-tangan {
            margin-top: 40px;
            text-align: right;
        }
        .tanda-tangan p {
            margin: 5px 0;
        }
        .nama {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN CATATAN PROYEK SISWA RPL</h2>
        <p>Sistem Informasi Manajemen Proyek Siswa</p>
    </div>

          <div class="info">
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td width="100" style="font-weight: bold;">Nama Siswa</td>
                <td width="10">:</td>
                <td>{{ $user->name }}</td>
                <td width="100" style="font-weight: bold; text-align: right;">Tanggal Cetak</td>
                <td width="10">:</td>
                <td>{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Email</td>
                <td>:</td>
                <td>{{ $user->email }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <table class="table-proyek">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Proyek</th>
                <th width="12%">Jenis</th>
                <th width="15%">Teknologi</th>
                <th width="12%">Status</th>
                <th width="13%">Tgl Mulai</th>
                <th width="13%">Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proyeks as $index => $proyek)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $proyek->nama_proyek }}</td>
                <td>{{ $proyek->jenis_proyek }}</td>
                <td>{{ $proyek->teknologi }}</td>
                <td align="center">{{ $proyek->status_proyek }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d/m/Y') }}</td>
                <td align="center">{{ $proyek->tanggal_selesai ? \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" align="center">Tidak ada data proyek</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p>Mengetahui,</p>
        <div class="nama">{{ $user->name }}</div>
        <p>Siswa RPL</p>
    </div>
</body>
</html>