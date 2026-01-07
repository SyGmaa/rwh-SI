@extends('layouts.app')
@section('content')
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah Paket</h4>
                  </div>
                  <div class="card-body">
                    @if(session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif
                    <form action="{{ route('paket.store') }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label>Jenis Paket</label>
                        <select name="jenis_id" class="form-control" required>
                          <option value="">Pilih Jenis Paket</option>
                          @foreach($jenisPakets as $jenis)
                            <option value="{{ $jenis->id }}" {{ $jenisId == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                          @endforeach
                        </select>
                        @error('jenis_id')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Nama Paket</label>
                        <input type="text" name="nama_paket" class="form-control" value="{{ old('nama_paket') }}" required>
                        @error('nama_paket')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Harga</label>
                        <input type="text" name="harga" class="form-control" value="{{ old('harga') }}" required>
                        @error('harga')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Jumlah Hari</label>
                        <input type="number" name="jml_hari" class="form-control" value="{{ old('jml_hari') }}" min="1" required>
                        @error('jml_hari')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <div class="control-label">Status</div>
                        <div class="custom-switches-stacked mt-2">
                          <label class="custom-switch">
                            <input type="radio" name="is_active" value="1" class="custom-switch-input" {{ old('is_active') == 1 ? 'checked' : '' }} checked>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Aktif</span>
                          </label>
                          <label class="custom-switch">
                            <input type="radio" name="is_active" value="0" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Tidak Aktif</span>
                          </label>
                        </div>
                        @error('is_active')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                      <div class="card-footer">
                      <button class="btn btn-primary mr-1" type="submit">Submit</button>
                      <a href="{{ route('paket.index', ['jenis_id' => $jenisId]) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    function formatNumber(input) {
        let value = input.value.replace(/\D/g, ''); // Remove non-digits
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Add dot every 3 digits
        input.value = value;
    }

    function unformatNumber(value) {
        return value.replace(/\./g, ''); // Remove dots for submission
    }

    $('input[name="harga"]').on('input', function() {
        formatNumber(this);
    });

    $('form').on('submit', function() {
        $('input[name="harga"]').val(function() {
            return unformatNumber($(this).val());
        });
    });
});
</script>
@endsection

