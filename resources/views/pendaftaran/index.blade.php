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
                    <h4>Pendaftaran @if($jenisId) - {{ $jenisPakets->where('id', $jenisId)->first()->nama_jenis ?? '' }} @endif</h4>
                    <div class="card-header-action">
                      <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">Tambah Pendaftaran</a>
                      @foreach($jenisPakets as $jenis)
                        <a href="{{ route('pendaftaran.create', ['jenis_id' => $jenis->id]) }}" class="btn btn-outline-primary">{{ $jenis->nama_jenis }}</a>
                      @endforeach
                    </div>
                  </div>
                  <div class="card-body">
                    @if(session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif
                    <div class="mb-3">
                      <label for="jenis_filter" class="form-label">Filter berdasarkan Jenis Paket:</label>
                      <select id="jenis_filter" class="form-control" onchange="filterByJenis(this.value)">
                        <option value="">Semua Jenis Paket</option>
                        @foreach($jenisPakets as $jenis)
                          <option value="{{ $jenis->id }}" {{ $jenisId == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>Nama Pendaftar</th>
                            <th>No. Telepon</th>
                            <th>Jadwal Keberangkatan</th>
                            <th>Jenis Paket</th>
                            <th>DP</th>
                            <th>Metode Bayar</th>
                            {{-- <th>Status</th> --}}
                            <th>Tanggal Daftar</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($pendaftarans as $index => $pendaftaran)
                          <tr>
                            <td class="text-center">
                              {{ $index + 1 }}
                            </td>
                            <td>{{ $pendaftaran->nama_pendaftar }}</td>
                            <td>{{ $pendaftaran->no_tlp ?? '-' }}</td>
                            <td>{{ $pendaftaran->jadwalKeberangkatan->paket->nama_paket }} - {{ $pendaftaran->jadwalKeberangkatan->tgl_berangkat->format('d/m/Y') }}</td>
                            <td>{{ $pendaftaran->jadwalKeberangkatan->paket->jenisPaket->nama_jenis }}</td>
                            <td>Rp {{ number_format($pendaftaran->dp, 0, ',', '.') }}</td>
                            <td>{{ $pendaftaran->metode_bayar }}</td>
                            {{-- <td>
                              <div class="badge badge-info badge-shadow">Aktif</div>
                            </td> --}}
                            <td>{{ $pendaftaran->tgl_daftar->format('d/m/Y H:i') }}</td>
                            <td>
                              <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Options</a>
                                <div class="dropdown-menu">
                                  <a href="{{ route('pendaftaran.show', $pendaftaran->id) }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                  <a href="{{ route('pendaftaran.edit', $pendaftaran->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                  <div class="dropdown-divider"></div>
                                  <form id="delete-form-{{ $pendaftaran->id }}" action="{{ route('pendaftaran.destroy', $pendaftaran->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    {{-- <a href="#"><button type="submit" class="dropdown-item has-icon text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus Pendaftaran jemaah ini?')" style="border: none; background: none;"><i class="far fa-trash-alt"></i> Delete</button></a> --}}
                                    <a href="#" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus Pendaftaran jemaah ini?')) { document.getElementById('delete-form-{{ $pendaftaran->id }}').submit(); }"><i class="far fa-trash-alt"></i> Delete</a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="10" class="text-center">Tidak ada data pendaftaran.</td>
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

@section('js')
<script src="{{ asset('admin/assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
$("#table-1").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0, 9] }
  ]
});
function filterByJenis(jenisId) {
    const url = jenisId ? '{{ route("pendaftaran.index") }}?jenis_id=' + jenisId : '{{ route("pendaftaran.index") }}';
    window.location.href = url;
}
</script>
@endsection
