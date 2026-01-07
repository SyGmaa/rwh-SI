@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pemasukan</h4>
                    </div>
                    <div class="card-body">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pemasukan Bulan Ini</h4>
                    </div>
                    <div class="card-body">
                        Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Transaksi (Bulan Ini)</h4>
                    </div>
                    <div class="card-body">
                        {{ $transaksiTerbaru->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>10 Transaksi Terakhir</h4>
                    <div class="card-header-action">
                        <a href="{{ route('laporan-keuangan.export-excel') }}" class="btn btn-success"><i
                                class="fas fa-file-excel"></i> Export Excel</a>
                        <a href="{{ route('laporan-keuangan.export-pdf') }}" class="btn btn-danger"><i
                                class="fas fa-file-pdf"></i> Export PDF</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Jemaah</th>
                                    <th>Nominal</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Metode</th>
                                    <th>Kode Cicilan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksiTerbaru as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaksi->jemaah->nama_jemaah ?? 'N/A' }}</td>
                                    <td>Rp {{ number_format($transaksi->nominal_cicilan, 0, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaksi->tgl_bayar)->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="badge badge-success">{{ $transaksi->metode_bayar }}</div>
                                    </td>
                                    <td>{{ $transaksi->kode_cicilan }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
