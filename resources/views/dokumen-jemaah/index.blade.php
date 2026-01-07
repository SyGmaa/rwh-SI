@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<style>

</style>

@endsection

@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            Dokumen Jemaah 
            @if($jadwalId)
              - {{ $jadwalKeberangkatans->where('id', $jadwalId)->first()->paket->nama_paket ?? '' }} 
              - {{ $jadwalKeberangkatans->where('id', $jadwalId)->first()->tgl_berangkat->format('d/m/Y') ?? '' }}
            @endif
          </h4>
          <div class="card-header-action">
            <a href="{{ route('dokumen-jemaah.create') }}" class="btn btn-primary">Tambah Dokumen Jemaah</a>
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
                <option value="{{ $jadwal->id }}" {{ $jadwalId == $jadwal->id ? 'selected' : '' }}>
                  {{ $jadwal->paket->nama_paket }} - {{ $jadwal->paket->jml_hari }} Hari - Rp {{ number_format($jadwal->paket->harga, 0, ',', '.') }} - {{ $jadwal->tgl_berangkat->format('d/m/Y') }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Nama Jemaah</th>
                  <th>No. Telepon</th>
                  <th>Tanggal Berangkat</th>
                  <th>Status Berkas</th>
                  <th>Dokumen</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($jemaahs as $index => $jemaah)
                <tr>
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td>{{ $jemaah->nama_jemaah }}</td>
                  <td>{{ $jemaah->no_tlp ?? '-' }}</td>
                  <td>{{ $jemaah->pendaftaran->jadwalKeberangkatan->tgl_berangkat->format('d/m/Y') }}</td>
                  <td>
                    @if($jemaah->status_berkas == 'Lengkap')
                      <div class="badge badge-success badge-shadow">Lengkap</div>
                    @else
                      <div class="badge badge-warning badge-shadow">Belum Lengkap</div>
                    @endif
                  </td>
                  <td>
                    @if($jemaah->dokumenJemaah->count() > 0)
                      <ul class="dokumen-list">
                        @foreach($jemaah->dokumenJemaah as $dokumen)
                          <li>
                            <span>{{ $dokumen->jenisDokumen->nama_jenis }}</span>
                            <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('dokumen-jemaah.edit', $dokumen->id) }}" class="btn btn-sm btn-warning">edit</a>
                          </li>
                        @endforeach
                      </ul>
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('dokumen-jemaah.create', ['jemaah_id' => $jemaah->id]) }}" class="btn btn-primary btn-sm">Tambah Dokumen</a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center">Tidak ada data jemaah.</td>
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
    { "sortable": false, "targets": [0, 6] }
  ]
});

function filterByJadwal(jadwalId) {
  const url = jadwalId ? '{{ route("dokumen-jemaah.index") }}?jadwal_id=' + jadwalId : '{{ route("dokumen-jemaah.index") }}';
  window.location.href = url;
}

function filterByJenis(jenisId) {
  const url = jenisId ? '{{ route("dokumen-jemaah.index") }}?jenis_id=' + jenisId : '{{ route("dokumen-jemaah.index") }}';
  window.location.href = url;
}

function updateJadwalFilter() {
  const jenisId = document.getElementById('jenis_filter').value;
  const jadwalSelect = document.getElementById('jadwal_filter');
  jadwalSelect.innerHTML = '<option value="">Semua Jadwal Keberangkatan</option>';
  @foreach($jadwalKeberangkatans as $jadwal)
    if (!jenisId || '{{ $jadwal->paket->jenis_id }}' === jenisId) {
      const option = document.createElement('option');
      option.value = '{{ $jadwal->id }}';
      option.textContent = '{{ $jadwal->paket->nama_paket }} {{ $jadwal->paket->jml_hari }} Hari - Rp {{ number_format($jadwal->paket->harga, 0, ',', '.') }} -- {{ $jadwal->tgl_berangkat->format('d/m/Y') }}';
      if ('{{ $jadwalId }}' === '{{ $jadwal->id }}') {
        option.selected = true;
      }
      jadwalSelect.appendChild(option);
    }
  @endforeach
}

document.addEventListener('DOMContentLoaded', function() {
  updateJadwalFilter();
});
</script>
@endsection

