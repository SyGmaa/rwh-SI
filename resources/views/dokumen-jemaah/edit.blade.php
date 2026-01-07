@extends('layouts.app')

@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Edit Dokumen Jemaah</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('dokumen-jemaah.update', $dokumenJemaah->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="jemaah_id">Jemaah</label>
              <select name="jemaah_id" id="jemaah_id" class="form-control" required>
                <option value="">Pilih Jemaah</option>
                @foreach($jemaahs as $jemaah)
                <option value="{{ $jemaah->id }}" {{ $jemaah->id == $dokumenJemaah->jemaah_id ? 'selected' : '' }}>{{
                  $jemaah->nama_jemaah }} - {{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->nama_paket }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="jenis_id">Jenis Dokumen</label>
              <select name="jenis_id" id="jenis_id" class="form-control" required>
                <option value="">Pilih Jenis Dokumen</option>
                @foreach($jenisDokumens as $jenisDokumen)
                <option value="{{ $jenisDokumen->id }}" {{ $jenisDokumen->id == $dokumenJemaah->jenis_id ? 'selected' :
                  '' }}>{{ $jenisDokumen->nama_jenis }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="file_path">File Dokumen</label>
              <input type="file" name="file_path" id="file_path" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
              <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB. Biarkan kosong jika tidak
                ingin mengubah file.</small>
              @if($dokumenJemaah->file_path)
              <div class="mt-2">
                <span class="d-inline-block mr-2">File saat ini:</span>
                <a class="btn btn-sm btn-primary" href="{{ Storage::url($dokumenJemaah->file_path) }}"
                  target="_blank">Lihat File</a>
                <button type="button" class="btn btn-sm btn-danger ml-2" onclick="confirmDelete()">Hapus Berkas</button>
              </div>
              @endif
            </div>


            <div class="card-footer text-right">
              <button class="btn btn-primary mr-1" type="submit">Update</button>
              <a href="{{ route('dokumen-jemaah.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- Hidden Delete Form --}}
  <form id="delete-file-form" action="{{ route('dokumen-jemaah.destroy', $dokumenJemaah->id) }}" method="POST"
    style="display: none;">
    @csrf
    @method('DELETE')
  </form>
</div>

@endsection

@section('js')
<script>
  function confirmDelete() {
      if (confirm('Apakah Anda yakin ingin menghapus berkas ini?')) {
          document.getElementById('delete-file-form').submit();
      }
  }
</script>
@endsection
