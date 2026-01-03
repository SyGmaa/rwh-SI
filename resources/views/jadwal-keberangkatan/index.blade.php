@extends('layouts.app1')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
  href="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Jadwal Keberangkatan @if($jenisId) - {{ $jenisPakets->where('id', $jenisId)->first()->nama_jenis ?? '' }}
            @endif</h4>
          <div class="card-header-action">
            <a href="{{ route('jadwal-keberangkatan.create', ['jenis_id' => $jenisId]) }}"
              class="btn btn-primary">Tambah Jadwal Keberangkatan</a>
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
              <option value="{{ $jenis->id }}" {{ $jenisId==$jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}
              </option>
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
                  <th>Nama Paket</th>
                  <th>Jumlah Hari</th>
                  <th>Tanggal Berangkat</th>
                  <th>Total Kuota</th>
                  <th>Sisa Kuota</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($jadwalKeberangkatans as $index => $jadwal)
                <tr>
                  <td class="text-center">
                    {{ $index + 1 }}
                  </td>
                  <td>{{ $jadwal->paket->nama_paket }}</td>
                  <td>{{ $jadwal->paket->jml_hari }} Hari</td>
                  <td>{{ $jadwal->tgl_berangkat->format('d/m/Y') }}</td>
                  <td>{{ $jadwal->total_kuota }}</td>
                  <td>{{ $jadwal->kuota }}</td>
                  <td>
                    @if($jadwal->status == 'Tersedia')
                    <div class="badge badge-success badge-shadow">Tersedia</div>
                    @elseif($jadwal->status == 'Penuh')
                    <div class="badge badge-warning badge-shadow">Penuh</div>
                    @elseif($jadwal->status == 'Selesai')
                    <div class="badge badge-info badge-shadow">Selesai</div>
                    @else
                    <div class="badge badge-danger badge-shadow">Dibatalkan</div>
                    @endif
                  </td>
                  <td>{{ $jadwal->keterangan ?? '-' }}</td>
                  <td>
                    <a href="{{ route('jadwal-keberangkatan.edit', $jadwal->id) }}" class="btn btn-info btn-sm">Edit</a>
                    <form action="{{ route('jadwal-keberangkatan.destroy', $jadwal->id) }}" method="POST"
                      style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal keberangkatan ini?')">Hapus</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9" class="text-center">Tidak ada data jadwal keberangkatan.</td>
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
<script src="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
</script>
<script src="{{ asset('admin/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
  $("#table-1").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0, 7] }
  ]
});
function filterByJenis(jenisId) {
    const url = jenisId ? '{{ route("jadwal-keberangkatan.index") }}?jenis_id=' + jenisId : '{{ route("jadwal-keberangkatan.index") }}';
    window.location.href = url;
}
</script>
@endsection