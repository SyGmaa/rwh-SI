@extends('layouts.app')

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
                    <h4>Jenis Paket</h4>
                    <div class="card-header-action">
                      <a href="{{ route('jenis-paket.create') }}" class="btn btn-primary">Tambah Jenis Paket</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>Nama Jenis</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($jenisPakets as $index => $jenisPaket)
                          <tr>
                            <td class="text-center">
                              {{ $index + 1 }}
                            </td>
                            <td>{{ $jenisPaket->nama_jenis }}</td>
                            <td>{{ $jenisPaket->deskripsi ?? '-' }}</td>
                            <td>
                              @if($jenisPaket->is_active)
                                <div class="badge badge-success badge-shadow">Aktif</div>
                              @else
                                <div class="badge badge-danger badge-shadow">Tidak Aktif</div>
                              @endif
                            </td>
                            <td>
                              <a href="{{ route('jenis-paket.edit', $jenisPaket->id) }}" class="btn btn-info btn-sm">Edit</a>
                              <form action="{{ route('jenis-paket.destroy', $jenisPaket->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jenis paket ini?')">Hapus</button>
                              </form>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="5" class="text-center">Tidak ada data jenis paket.</td>
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
@endsection

