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
                    <h4>Cicilan Jemaah @if($jenisId) - {{ $jenisPakets->where('id', $jenisId)->first()->nama_jenis ?? '' }} @endif</h4>
                    <div class="card-header-action">
                      <a href="{{ route('cicilan-jemaah.create') }}" class="btn btn-primary">Tambah Cicilan Jemaah</a>
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
                    <div class="mb-3">
                      <label for="jadwal_filter" class="form-label">Filter berdasarkan Jadwal Keberangkatan:</label>
                      <select id="jadwal_filter" class="form-control" onchange="filterByJadwal(this.value)">
                        <option value="">Semua Jadwal Keberangkatan</option>
                        @foreach($jadwalKeberangkatans as $jadwal)
                          <option value="{{ $jadwal->id }}" {{ $jadwalId == $jadwal->id ? 'selected' : '' }}>{{ $jadwal->paket->nama_paket }} - {{ $jadwal->tgl_berangkat->format('d/m/Y') }}</option>
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
                            <th>Nama Jemaah</th>
                            <th>Kode Cicilan</th>
                            <th>Nominal Cicilan</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode Bayar</th>
                            <th>Bukti Bayar</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($cicilanJemaahs as $index => $cicilan)
                          <tr>
                            <td class="text-center">
                              {{ $index + 1 }}
                            </td>
                            <td>{{ $cicilan->jemaah->nama_jemaah }}</td>
                            <td>{{ $cicilan->kode_cicilan }}</td>
                            <td>Rp {{ number_format($cicilan->nominal_cicilan, 0, ',', '.') }}</td>
                            <td>{{ $cicilan->tgl_bayar->format('d/m/Y H:i') }}</td>
                            <td>{{ $cicilan->metode_bayar }}</td>
                            <td>
                              @if($cicilan->bukti_bayar)
                                <button type="button" class="btn btn-sm btn-info" onclick="viewBuktiBayar('{{ asset('storage/' . $cicilan->bukti_bayar) }}')">Lihat Bukti</button>
                              @else
                                -
                              @endif
                            </td>
                            <td>
                              <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Options</a>
                                <div class="dropdown-menu">
                                  <a href="{{ route('cicilan-jemaah.edit', $cicilan->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                  {{-- <div class="dropdown-divider"></div> --}}
                                  <form id="delete-form-{{ $cicilan->id }}" action="{{ route('cicilan-jemaah.destroy', $cicilan->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    {{-- <a href="#"><button type="submit" class="dropdown-item has-icon text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus cicilan jemaah ini?')" style="border: none; background: none;"><i class="far fa-trash-alt"></i> Delete</button></a> --}}
                                    <a href="#" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus Cicilan jemaah ini?')) { document.getElementById('delete-form-{{ $cicilan->id }}').submit(); }"><i class="far fa-trash-alt"></i> Delete</a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="8" class="text-center">Tidak ada data cicilan jemaah.</td>
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
    { "sortable": false, "targets": [0, 7] }
  ]
});
function filterByJenis(jenisId) {
    const url = jenisId ? '{{ route("cicilan-jemaah.index") }}?jenis_id=' + jenisId : '{{ route("cicilan-jemaah.index") }}';
    window.location.href = url;
}
function filterByJadwal(jadwalId) {
    const currentUrl = new URL(window.location);
    const params = new URLSearchParams(currentUrl.search);
    if (jadwalId) {
        params.set('jadwal_id', jadwalId);
    } else {
        params.delete('jadwal_id');
    }
    const newUrl = '{{ route("cicilan-jemaah.index") }}' + (params.toString() ? '?' + params.toString() : '');
    window.location.href = newUrl;
}
function viewBuktiBayar(url) {
    window.open(url, '_blank');
}
</script>
@endsection
