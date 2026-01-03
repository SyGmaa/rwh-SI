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
          <h4>Detail Jemaah: {{ $jemaah->nama_jemaah }}</h4>
          <div class="card-header-action">
            <a href="{{ route('jemaah.index') }}" class="btn btn-outline-primary">Kembali</a>
            <a href="{{ route('jemaah.edit', $jemaah->id) }}" class="btn btn-primary">Edit</a>
          </div>
        </div>
        <div class="card-body">
          <!-- Informasi Jemaah -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5>Informasi Jemaah</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Nama Jemaah</strong></td>
                          <td>{{ $jemaah->nama_jemaah }}</td>
                        </tr>
                        <tr>
                          <td><strong>No. Telepon</strong></td>
                          <td>{{ $jemaah->no_tlp ?? '-' }}</td>
                        </tr>
                        <tr>
                          <td><strong>Status Berkas</strong></td>
                          <td>
                            @if($jemaah->status_berkas == 'Lengkap')
                              <div class="badge badge-success">Lengkap</div>
                            @else
                              <div class="badge badge-warning">Belum Lengkap</div>
                            @endif
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Pax</strong></td>
                          <td>{{ $jemaah->pax }} Pax</td>
                        </tr>
                        <tr>
                          <td><strong>Biaya Tambahan</strong></td>
                          <td>Rp {{ number_format($jemaah->biaya_tambahan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                          <td><strong>Sisa Tagihan</strong></td>
                          <td>Rp {{ number_format($jemaah->sisa_tagihan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                          <td><strong>Status Pembayaran</strong></td>
                          <td>
                            @if($jemaah->status_pembayaran == 'Lunas')
                              <div class="badge badge-success">Lunas</div>
                            @elseif($jemaah->status_pembayaran == 'Dibatalkan')
                              <div class="badge badge-danger">Dibatalkan</div>
                            @else
                              <div class="badge badge-warning">Belum Lunas</div>
                            @endif
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

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
                          <td><strong>Rombongan Pendaftar</strong></td>
                          <td>{{ $jemaah->pendaftaran->nama_pendaftar }}</td>
                        </tr>
                        <tr>
                          <td><strong>No. Telepon Pendaftar</strong></td>
                          <td>{{ $jemaah->pendaftaran->no_tlp }}</td>
                        </tr>
                        <tr>
                          <td><strong>DP</strong></td>
                          <td>Rp {{ number_format($jemaah->pendaftaran->dp, 0, ',', '.') }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Metode Bayar</strong></td>
                          <td>{{ $jemaah->pendaftaran->metode_bayar }}</td>
                        </tr>

                        <tr>
                          <td><strong>Tanggal Daftar</strong></td>
                          <td>{{ $jemaah->pendaftaran->tgl_daftar->format('d/m/Y H:i') }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="row">
          <!-- Informasi Paket -->
            <div class="col-md-6 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h5>Informasi Paket</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Jenis Paket</strong></td>
                          <td>{{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->jenisPaket->nama_jenis }}</td>
                        </tr>
                        <tr>
                          <td><strong>Nama Paket</strong></td>
                          <td>{{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->nama_paket }}</td>
                        </tr>
                        <tr>
                          <td><strong>Harga Paket</strong></td>
                          <td>Rp {{ number_format($jemaah->pendaftaran->jadwalKeberangkatan->paket->harga, 0, ',', '.') }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-borderless">

                        <tr>
                          <td><strong>Jumlah Hari</strong></td>
                          <td>{{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->jml_hari }} hari</td>
                        </tr>
                        <tr>
                          <td><strong>Keterangan</strong></td>
                          <td>{{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->keterangan ?? '-' }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Informasi Jadwal Keberangkatan -->
            <div class="col-md-6 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h5>Informasi Jadwal Keberangkatan</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 col-sm-12">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Tanggal Berangkat</strong></td>
                          <td>{{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->tgl_berangkat->format('d/m/Y') : $jemaah->pendaftaran->jadwalKeberangkatan->tgl_berangkat->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                          <td><strong>Total Kuota</strong></td>
                          <td>{{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->total_kuota : $jemaah->pendaftaran->jadwalKeberangkatan->total_kuota }}</td>
                        </tr>
                        <tr>
                          <td><strong>Sisa Kuota</strong></td>
                          <td>{{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->kuota : $jemaah->pendaftaran->jadwalKeberangkatan->kuota }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <table class="table table-borderless">
                        <tr>
                          <td><strong>Status</strong></td>
                          <td>{{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->status : $jemaah->pendaftaran->jadwalKeberangkatan->status }}</td>
                        </tr>
                        <tr>
                          <td><strong>Keterangan</strong></td>
                          <td>{{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->keterangan : $jemaah->pendaftaran->jadwalKeberangkatan->keterangan }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- Cicilan Jemaah -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5>Cicilan Jemaah</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-cicilan">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Kode Cicilan</th>
                          <th>Nominal Cicilan</th>
                          <th>Tanggal Bayar</th>
                          <th>Metode Bayar</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($jemaah->cicilans as $index => $cicilan)
                        <tr>
                          <td class="text-center">{{ $index + 1 }}</td>
                          <td>{{ $cicilan->kode_cicilan }}</td>
                          <td>Rp {{ number_format($cicilan->nominal_cicilan, 0, ',', '.') }}</td>
                          <td>{{ $cicilan->tgl_bayar->format('d/m/Y') }}</td>
                          <td>{{ $cicilan->metode_bayar }}</td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="5" class="text-center">Tidak ada data cicilan.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Dokumen Jemaah -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5>Dokumen Jemaah</h5>
                </div>
                {{-- <div class="card-header-action">
                  <a href="{{ route('dokumen-jemaah.create', ['jemaah_id' => $jemaah->id]) }}" class="btn btn-primary btn-sm">Tambah Dokumen</a>
                </div> --}}
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-dokumen">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Jenis Dokumen</th>
                          <th>File Path</th>
                          <th>Tanggal Upload</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($jemaah->dokumenJemaah as $index => $dokumen)
                        <tr>
                          <td class="text-center">{{ $index + 1 }}</td>
                          <td>{{ $dokumen->jenisDokumen->nama_jenis }}</td>
                          <td><a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank">{{ $dokumen->file_path }}</a></td>
                          <td>{{ $dokumen->tanggal_upload->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4" class="text-center">Tidak ada data dokumen.</td>
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
$("#table-cicilan").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0] }
  ]
});
$("#table-dokumen").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0] }
  ]
});
</script>
@endsection
