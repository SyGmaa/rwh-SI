@extends('layouts.app1')
@section('title', 'Jemaah')
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
                    <h4>Jemaah @if($jenisId) - {{ $jenisPakets->where('id', $jenisId)->first()->nama_jenis ?? '' }} @endif</h4>
                    <div class="card-header-action">
                      <a href="{{ route('jemaah.create') }}" class="btn btn-primary">Tambah Jemaah</a>
                    </div>
                  </div>
                  <div class="card-body">
                    @if(session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif
                    <div class="mb-3">
                      <label for="jadwal_filter" class="form-label">Filter berdasarkan Jadwal Keberangkatan:</label>
                      <select id="jadwal_filter" class="form-control" onchange="filterByJadwal(this.value)">
                        <option value="">Semua Jadwal Keberangkatan</option>
                        @foreach($jadwalKeberangkatans as $jadwal)
                          <option value="{{ $jadwal->id }}" {{ $jadwalId == $jadwal->id ? 'selected' : '' }}>{{ $jadwal->paket->nama_paket }} - {{ $jadwal->paket->jml_hari }} Hari - Rp {{ number_format($jadwal->paket->harga, 0, ',', '.') }} - {{ $jadwal->tgl_berangkat->format('d/m/Y') }}</option>
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
                            <th>No. Telepon</th>
                            <th>Tanggal Berangkat</th>
                            <th>Status Berkas</th>
                            <th>Pax</th>
                            <th>Status Pembayaran</th>
                            <th>Sisa Tagihan</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($jemaahs as $index => $jemaah)
                          <tr>
                            <td class="text-center">
                              {{ $index + 1 }}
                            </td>
                            <td>{{ $jemaah->nama_jemaah }}</td>
                            <td>{{ $jemaah->no_tlp ?? '-' }}</td>
                            <td>{{ ($jemaah->jadwal_override_id ? $jemaah->jadwalOverride->tgl_berangkat : $jemaah->pendaftaran->jadwalKeberangkatan->tgl_berangkat)->format('d/m/Y') }}</td>
                            <td>
                              @if($jemaah->status_berkas == 'Lengkap')
                                <div class="badge badge-success badge-shadow">Lengkap</div>
                              @else
                                <div class="badge badge-warning badge-shadow">Belum Lengkap</div>
                              @endif
                            </td>
                            <td>{{ $jemaah->pax }}</td>
                            <td>
                              @if($jemaah->status_pembayaran == 'Lunas')
                                <div class="badge badge-success badge-shadow">Lunas</div>
                              @elseif($jemaah->status_pembayaran == 'Dibatalkan')
                                <div class="badge badge-danger badge-shadow">Dibatalkan</div>
                              @else
                                <div class="badge badge-warning badge-shadow">Belum Lunas</div>
                              @endif
                            </td>
                            <td>Rp {{ number_format($jemaah->sisa_tagihan, 0, ',', '.') }}</td>
                            <td>
                              <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Options</a>
                                <div class="dropdown-menu">
                                  <a href="{{ route('jemaah.show', $jemaah->id) }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                  <a href="{{ route('jemaah.edit', $jemaah->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                  <div class="dropdown-divider"></div>
                                  <form id="delete-form-{{ $jemaah->id }}" action="{{ route('jemaah.destroy', $jemaah->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    {{-- <a href="#"><button type="submit" class="dropdown-item has-icon text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jemaah ini?')" style="border: none; background: none;"><i class="far fa-trash-alt"></i> Delete</button></a> --}}
                                    <a href="#" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus Pendaftaran jemaah ini?')) { document.getElementById('delete-form-{{ $jemaah->id }}').submit(); }"><i class="far fa-trash-alt"></i> Delete</a>
                                  </form>
                                </div>
                              </div>
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
@endsection

@section('js')
<script src="{{ asset('admin/assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
$("#table-1").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0, 8] }
  ]
});
function filterByJadwal(jadwalId) {
    const url = jadwalId ? '{{ route("jemaah.index") }}?jadwal_id=' + jadwalId : '{{ route("jemaah.index") }}';
    window.location.href = url;
}
</script>
@endsection
