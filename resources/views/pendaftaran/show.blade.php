@extends('layouts.app1')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Detail Pendaftaran: {{ $pendaftaran->nama_pendaftar }}</h4>
          <div class="card-header-action">
            <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('pendaftaran.edit', $pendaftaran->id) }}" class="btn btn-primary">Edit</a>
          </div>
        </div>
        <div class="card-body">
          <!-- Informasi Pendaftaran -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5>Informasi Pendaftaran</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Nama Pendaftar</strong></td>
                          <td>{{ $pendaftaran->nama_pendaftar }}</td>
                        </tr>
                        <tr>
                          <td><strong>No. Telepon</strong></td>
                          <td>{{ $pendaftaran->no_tlp ?? '-' }}</td>
                        </tr>
                        <tr>
                          <td><strong>DP</strong></td>
                          <td>Rp {{ number_format($pendaftaran->dp, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                          <td><strong>Metode Bayar</strong></td>
                          <td>{{ $pendaftaran->metode_bayar }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-borderless">

                        <tr>
                          <td><strong>Total Biaya</strong></td>
                          <td>Rp {{ number_format($pendaftaran->total_biaya, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                          <td><strong>Total Bayar</strong></td>
                          <td>Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                          <td><strong>Sisa Tagihan</strong></td>
                          <td>Rp {{ number_format($pendaftaran->sisa_tagihan, 0, ',', '.') }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Informasi Jadwal Keberangkatan -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5>Informasi Jadwal Keberangkatan</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Jenis Paket</strong></td>
                          <td>{{ $pendaftaran->jadwalKeberangkatan->paket->jenisPaket->nama_jenis }}</td>
                        </tr>
                        <tr>
                          <td><strong>Nama Paket</strong></td>
                          <td>{{ $pendaftaran->jadwalKeberangkatan->paket->nama_paket }}</td>
                        </tr>
                        <tr>
                          <td><strong>Harga Paket</strong></td>
                          <td>Rp {{ number_format($pendaftaran->jadwalKeberangkatan->paket->harga, 0, ',', '.') }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Tanggal Berangkat</strong></td>
                          <td>{{ $pendaftaran->jadwalKeberangkatan->tgl_berangkat->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                          <td><strong>Total Kuota</strong></td>
                          <td>{{ $pendaftaran->jadwalKeberangkatan->total_kuota }}</td>
                        </tr>
                        <tr>
                          <td><strong>Sisa Kuota</strong></td>
                          <td>{{ $pendaftaran->jadwalKeberangkatan->kuota }}</td>
                        </tr>
                        <tr>
                          <td><strong>Status</strong></td>
                          <td>{{ $pendaftaran->jadwalKeberangkatan->status }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- List Jemaah -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5>List Jemaah</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-jemaah">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nama Jemaah</th>
                          <th>No. Telepon</th>
                          <th>Pax</th>
                          <th>Biaya Tambahan</th>
                          <th>Status Berkas</th>
                          <th>Total Cicilan</th>
                          <th>Sisa Tagihan</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($pendaftaran->jemaahs as $index => $jemaah)
                        <tr>
                          <td class="text-center">{{ $index + 1 }}</td>
                          <td>{{ $jemaah->nama_jemaah }}</td>
                          <td>{{ $jemaah->no_tlp ?? '-' }}</td>
                          <td>{{ $jemaah->pax }} Pax</td>
                          <td>Rp {{ number_format($jemaah->biaya_tambahan, 0, ',', '.') }}</td>
                          <td>
                            @if($jemaah->status_berkas == 'Lengkap')
                              <div class="badge badge-success">Lengkap</div>
                            @else
                              <div class="badge badge-warning">Belum Lengkap</div>
                            @endif
                          </td>
                          <td>Rp {{ number_format($jemaah->total_cicilan, 0, ',', '.') }}</td>
                          <td>Rp {{ number_format($jemaah->sisa_tagihan, 0, ',', '.') }}</td>
                          <td>
                            <a href="{{ route('jemaah.show', $jemaah->id) }}" class="btn btn-info btn-sm">View</a>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="9" class="text-center">Tidak ada data jemaah.</td>
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
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('admin/assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$("#table-jemaah").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0, 8] }
  ]
});
</script>
@endsection
