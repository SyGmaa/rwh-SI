<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - {{ $cicilan->kode_cicilan }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 12px;
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
        }

        .title h2 {
            margin: 0;
            text-decoration: underline;
        }

        .content table {
            width: 100%;
        }

        .content td {
            padding: 8px 0;
            vertical-align: top;
        }

        .label {
            width: 25%;
            font-weight: bold;
        }

        .separator {
            width: 2%;
        }

        .value {
            width: 73%;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #333;
        }

        .note {
            margin-top: 30px;
            font-size: 11px;
            font-style: italic;
            border: 1px dashed #ccc;
            padding: 10px;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        @if(isset($settings['company_logo']))
        @if(str_contains($settings['company_logo'], 'admin/assets'))
        <img src="{{ asset($settings['company_logo']) }}" alt="Logo">
        @else
        <img src="{{ asset('storage/' . $settings['company_logo']) }}" alt="Logo">
        @endif
        @else
        <img src="{{ asset('admin/assets/img/logorwh1.png') }}" alt="Default Logo">
        @endif

        <h1>{{ $settings['company_name'] ?? 'PT. RIAU WISATA HATI' }}</h1>
        <p>{{ $settings['company_address'] ?? 'Alamat Perusahaan' }}</p>
        <p>Telp: {{ $settings['company_phone'] ?? '-' }} | Email: {{ $settings['company_email'] ?? '-' }}</p>
    </div>

    <div class="title">
        <h2>KWITANSI PEMBAYARAN</h2>
        <p>No: {{ $cicilan->kode_cicilan }}</p>
    </div>

    <div class="content">
        <table>
            <tr>
                <td class="label">Telah terima dari</td>
                <td class="separator">:</td>
                <td class="value"><strong>{{ $cicilan->jemaah->nama_jemaah }}</strong></td>
            </tr>
            <tr>
                <td class="label">Uang Sejumlah</td>
                <td class="separator">:</td>
                <td class="value">Rp {{ number_format($cicilan->nominal_cicilan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Terbilang</td>
                <td class="separator">:</td>
                <td class="value" style="font-style: italic; text-transform: capitalize;">
                    {{ \App\Helpers\Terbilang::make($cicilan->nominal_cicilan) }} Rupiah
                </td>
            </tr>
            <tr>
                <td class="label">Untuk Pembayaran</td>
                <td class="separator">:</td>
                <td class="value">
                    Cicilan Paket {{ $cicilan->jemaah->pendaftaran->jadwalKeberangkatan->paket->nama_paket ?? '-' }}
                    ({{
                    \Carbon\Carbon::parse($cicilan->jemaah->pendaftaran->jadwalKeberangkatan->tgl_keberangkatan)->format('d
                    M Y') }})
                </td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td class="separator">:</td>
                <td class="value">{{ $cicilan->metode_bayar }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Bayar</td>
                <td class="separator">:</td>
                <td class="value">{{ \Carbon\Carbon::parse($cicilan->tgl_bayar)->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Penyetor</p>
            <div class="signature-line"></div>
            <p>{{ $cicilan->jemaah->nama_jemaah }}</p>
        </div>
        <div class="signature">
            <p>Penerima</p>
            <div class="signature-line"></div>
            <p>Admin RWH</p>
        </div>
    </div>

    <div class="note">
        <strong>Catatan:</strong>
        <ul>
            <li>Simpan kwitansi ini sebagai bukti pembayaran yang sah.</li>
            <li>Pembayaran dianggap sah jika uang telah masuk ke rekening perusahaan.</li>
        </ul>
    </div>
</body>

</html>