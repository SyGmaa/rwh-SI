@extends('layouts.app1')

@section('content')
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Cicilan Jemaah</h4>
                  </div>
                  <div class="card-body">
                    @if(session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif
                    <form action="{{ route('cicilan-jemaah.update', $cicilanJemaah->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label>Jemaah</label>
                        <select name="jemaah_id" class="form-control" required>
                          <option value="">Pilih Jemaah</option>
                          @foreach($jemaahs as $jemaah)
                            <option value="{{ $jemaah->id }}" {{ $jemaah->id == $cicilanJemaah->jemaah_id ? 'selected' : '' }}>{{ $jemaah->nama_jemaah }} - {{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->nama_paket }}</option>
                          @endforeach
                        </select>
                        @error('jemaah_id')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Kode Cicilan</label>
                        <input type="text" name="kode_cicilan" class="form-control" value="{{ old('kode_cicilan', $cicilanJemaah->kode_cicilan) }}" required>
                        @error('kode_cicilan')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Nominal Cicilan</label>
                        <input type="text" name="nominal_cicilan" class="form-control" value="{{ old('nominal_cicilan', $cicilanJemaah->nominal_cicilan) }}" required>
                        @error('nominal_cicilan')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Tanggal Bayar</label>
                        <input type="datetime-local" name="tgl_bayar" class="form-control" value="{{ old('tgl_bayar', $cicilanJemaah->tgl_bayar->format('Y-m-d\TH:i')) }}" required>
                        @error('tgl_bayar')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Metode Bayar</label>
                        <select name="metode_bayar" class="form-control" required>
                          <option value="Transfer" {{ old('metode_bayar', $cicilanJemaah->metode_bayar) == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                          <option value="Tunai" {{ old('metode_bayar', $cicilanJemaah->metode_bayar) == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        </select>
                        @error('metode_bayar')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Bukti Bayar</label>
                        <input type="file" name="bukti_bayar" class="form-control" value="{{ old('bukti_bayar', $cicilanJemaah->bukti_bayar) }}">
                        @error('bukti_bayar')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="card-footer">
                        <button class="btn btn-primary mr-1" type="submit">Update</button>
                        <a href="{{ route('cicilan-jemaah.index') }}" class="btn btn-outline-secondary">Cancel</a>
                      </div>
                    </form>
                  </div>
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

    $('input[name="nominal_cicilan"]').on('input', function() {
        formatNumber(this);
    });

    $('form').on('submit', function() {
        $('input[name="nominal_cicilan"]').val(function() {
            return unformatNumber($(this).val());
        });
    });
});
</script>
@endsection
