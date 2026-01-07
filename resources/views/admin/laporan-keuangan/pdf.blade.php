<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Keuangan RWH-SI</h2>
        <p>Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Jemaah</th>
                <th>Nominal</th>
                <th>Tanggal Bayar</th>
                <th>Metode</th>
                <th>Kode Cicilan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $t)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $t->jemaah->nama_jemaah ?? 'N/A' }}</td>
                <td>Rp {{ number_format($t->nominal_cicilan, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tgl_bayar)->format('d-m-Y') }}</td>
                <td>{{ $t->metode_bayar }}</td>
                <td>{{ $t->kode_cicilan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
    </div>
</body>

</html>