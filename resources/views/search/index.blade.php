@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Search Results</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Search</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Search Results for "{{ $query }}"</h2>
        <p class="section-lead">
            Found {{ $jemaah->count() }} Jemaah, {{ $paket->count() }} Paket, and {{ $jadwal->count() }} Jadwal.
        </p>

        <div class="row">
            <div class="col-12">

                @if($jemaah->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h4>Jemaah ({{ $jemaah->count() }})</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Jemaah</th>
                                        <th>Status Pembayaran</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jemaah as $item)
                                    <tr>
                                        <td>{{ $item->nama_jemaah }}</td>
                                        <td>
                                            @if($item->status_pembayaran == 'Lunas')
                                            <div class="badge badge-success">Lunas</div>
                                            @else
                                            <div class="badge badge-warning">Belum Lunas</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('jemaah.show', $item->id) }}"
                                                class="btn btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                @if($paket->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h4>Paket ({{ $paket->count() }})</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Paket</th>
                                        <th>Harga</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paket as $item)
                                    <tr>
                                        <td>{{ $item->nama_paket }}</td>
                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('paket.edit', $item->id) }}"
                                                class="btn btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                @if($jadwal->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h4>Jadwal Keberangkatan ({{ $jadwal->count() }})</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Paket</th>
                                        <th>Tanggal Berangkat</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwal as $item)
                                    <tr>
                                        <td>{{ $item->paket->nama_paket ?? '-' }}</td>
                                        <td>{{ $item->tgl_berangkat->format('d M Y') }}</td>
                                        <td>
                                            @if($item->status == 'Buka')
                                            <div class="badge badge-success">Buka</div>
                                            @else
                                            <div class="badge badge-danger">Tutup</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('jadwal-keberangkatan.edit', $item->id) }}"
                                                class="btn btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                @if($jemaah->isEmpty() && $paket->isEmpty() && $jadwal->isEmpty())
                <div class="card">
                    <div class="card-body">
                        <div class="empty-state" data-height="400">
                            <div class="empty-state-icon">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>We couldn't find any data</h2>
                            <p class="lead">
                                Sorry we can't find any data, to get rid of this message, make at least 1 entry.
                            </p>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>
@endsection
