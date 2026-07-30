<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Data Sertifikat</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 2px;
        }
        p.subtitle {
            text-align: center;
            color: #7f8c8d;
            margin: 0 0 20px 0;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #bdc3c7;
            padding: 8px 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #2c3e50;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            font-size: 8pt;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <h2>Rekap Data Sertifikat Ekstrakurikuler</h2>
    <p class="subtitle">Dicetak pada tanggal: {{ date('d-m-Y H:i') }} WIB</p>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode</th>
                <th width="20%">Nama Siswa</th>
                <th width="10%">NIS</th>
                <th width="15%">Ekskul</th>
                <th width="15%">Prestasi</th>
                <th width="12%">Tanggal</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($certificates as $cert)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>{{ $cert->code }}</strong></td>
                    <td>{{ $cert->nama_siswa }}</td>
                    <td class="text-center">{{ $cert->nis }}</td>
                    <td>{{ $cert->ekskul }}</td>
                    <td>{{ $cert->prestasi ?? '-' }}</td>
                    <td class="text-center">{{ $cert->tanggal->format('d-m-Y') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $cert->status == 'Aktif' ? 'badge-success' : 'badge-warning' }}">
                            {{ $cert->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman 1 dari 1 | Sistem Sertifikat Ekskul
    </div>

</body>
</html>
