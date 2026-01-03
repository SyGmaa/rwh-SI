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
                    <h4>Paket @if($jenisId) - {{ $jenisPakets->where('id', $jenisId)->first()->nama_jenis ?? '' }} @endif</h4>
                    <div class="card-header-action">
                      <a href="{{ route('paket.create', ['jenis_id' => $jenisId]) }}" class="btn btn-primary">Tambah Paket</a>
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
                            <th>Nama Paket</th>
                            <th>Jenis Paket</th>
                            <th>Harga</th>
                            <th>Jumlah Hari</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($pakets as $index => $paket)
                          <tr>
                            <td class="text-center">
                              {{ $index + 1 }}
                            </td>
                            <td>{{ $paket->nama_paket }}</td>
                            <td>{{ $paket->jenisPaket->nama_jenis }}</td>
                            <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                            <td>{{ $paket->jml_hari }} hari</td>
                            <td>
                              @if($paket->is_active)
                                <div class="badge badge-success badge-shadow">Aktif</div>
                              @else
                                <div class="badge badge-danger badge-shadow">Tidak Aktif</div>
                              @endif
                            </td>
                            <td>
                              <a href="{{ route('paket.edit', $paket->id) }}" class="btn btn-info btn-sm">Edit</a>
                              <form action="{{ route('paket.destroy', $paket->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">Hapus</button>
                              </form>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="7" class="text-center">Tidak ada data paket.</td>
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
<script src="{{ asset('admin/assets/js/page/datatables.js') }}"></script>
<script>
function filterByJenis(jenisId) {
    const url = jenisId ? '{{ route("paket.index") }}?jenis_id=' + jenisId : '{{ route("paket.index") }}';
    window.location.href = url;
}
</script>
@endsection
