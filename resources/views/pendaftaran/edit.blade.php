@extends('layouts.app')
@section('content')
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Pendaftaran</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label>Jadwal Keberangkatan</label>
                        <select name="jadwal_id" class="form-control" required>
                          <option value="">Pilih Jadwal Keberangkatan</option>
                          @foreach($jadwalKeberangkatans as $jadwal)
                            <option value="{{ $jadwal->id }}" {{ $jadwal->id == $pendaftaran->jadwal_id ? 'selected' : '' }}>{{ $jadwal->paket->nama_paket }} - {{ $jadwal->paket->jml_hari }} Hari - Rp {{ number_format($jadwal->paket->harga, 0, ',', '.') }} - {{ $jadwal->tgl_berangkat->format('d/m/Y') }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Nama Pendaftar</label>
                        <input type="text" name="nama_pendaftar" class="form-control" value="{{ $pendaftaran->nama_pendaftar }}" required>
                      </div>
                      <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_tlp" class="form-control" value="{{ $pendaftaran->no_tlp }}">
                      </div>
                      <div class="form-group">
                        <label>DP (Uang Muka)</label>
                        <input type="text" name="dp" class="form-control" value="{{ $pendaftaran->dp }}" required>
                      </div>
                      <div class="form-group">
                        <label>Metode Bayar</label>
                        <select name="metode_bayar" class="form-control" required>
                          <option value="Transfer" {{ $pendaftaran->metode_bayar == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                          <option value="Tunai" {{ $pendaftaran->metode_bayar == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Bukti Bayar</label>
                        <input type="text" name="bukti_bayar" class="form-control" value="{{ $pendaftaran->bukti_bayar }}" placeholder="Link atau nama file bukti bayar">
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-outline-secondary">Batal</a>
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

    $('input[name="dp"]').on('input', function() {
        formatNumber(this);
    });

    $('form').on('submit', function() {
        $('input[name="dp"]').val(function() {
            return unformatNumber($(this).val());
        });
    });
});
</script>
@endsection

