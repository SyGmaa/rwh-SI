@extends('layouts.app')

@section('content')
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Jemaah</h4>
                  </div>
                  <div class="card-body">
                    @if(session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif
                    <form action="{{ route('jemaah.update', $jemaah->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label>Pendaftaran</label>
                        <select name="pendaftaran_id" class="form-control" required>
                          <option value="">Pilih Pendaftaran</option>
                          @foreach($pendaftarans as $pendaftaran)
                            <option value="{{ $pendaftaran->id }}" {{ $pendaftaran->id == $jemaah->pendaftaran_id ? 'selected' : '' }}>{{ $pendaftaran->nama_pendaftar }} - {{ $pendaftaran->jadwalKeberangkatan->paket->nama_paket }}</option>
                          @endforeach
                        </select>
                        @error('pendaftaran_id')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Nama Jemaah</label>
                        <input type="text" name="nama_jemaah" class="form-control" value="{{ old('nama_jemaah', $jemaah->nama_jemaah) }}" required>
                        @error('nama_jemaah')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_tlp" class="form-control" value="{{ old('no_tlp', $jemaah->no_tlp) }}">
                        @error('no_tlp')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Jadwal Override</label>
                        <select name="jadwal_override_id" class="form-control">
                          <option value="">Pilih Jadwal Override (Opsional)</option>
                          @foreach($jadwalKeberangkatans as $jadwal)
                            <option value="{{ $jadwal->id }}" {{ $jadwal->id == $jemaah->jadwal_override_id ? 'selected' : '' }}>{{ $jadwal->paket->nama_paket }} - {{ $jadwal->tgl_berangkat->format('d/m/Y') }}</option>
                          @endforeach
                        </select>
                        @error('jadwal_override_id')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Status Berkas</label>
                        <select name="status_berkas" class="form-control" required>
                          <option value="Belum Lengkap" {{ old('status_berkas', $jemaah->status_berkas) == 'Belum Lengkap' ? 'selected' : '' }}>Belum Lengkap</option>
                          <option value="Lengkap" {{ old('status_berkas', $jemaah->status_berkas) == 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                        </select>
                        @error('status_berkas')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                      <div class="control-label">Pax</div>
                      <div class="custom-switches mt-2">
                        <label class="custom-switch">
                          <input type="radio" name="option" value="2" class="custom-switch-input" {{ $jemaah->pax == 2 ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">2 Pax</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="3" class="custom-switch-input" {{ $jemaah->pax == 3 ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">3 Pax</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="4" class="custom-switch-input" {{ $jemaah->pax == 4 ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">4 Pax</span>
                        </label>
                      </div>
                    </div>
                      <div class="form-group">
                        <label>Biaya Tambahan</label>
                        <input type="text" name="biaya_tambahan" class="form-control bg-white text-dark" value="{{ old('biaya_tambahan', $jemaah->biaya_tambahan) }}" readonly>
                        @error('biaya_tambahan')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Status Pembayaran</label>
                        <select name="status_pembayaran" class="form-control" required>
                          <option value="Belum Lunas" {{ old('status_pembayaran', $jemaah->status_pembayaran) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                          <option value="Lunas" {{ old('status_pembayaran', $jemaah->status_pembayaran) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                          <option value="Dibatalkan" {{ old('status_pembayaran', $jemaah->status_pembayaran) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status_pembayaran')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a href="{{ route('jemaah.index') }}" class="btn btn-outline-secondary">Cancel</a>
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

    $('input[name="biaya_tambahan"]').on('input', function() {
        formatNumber(this);
    });

    $('input[name="option"]').change(function() {
        var selectedPax = $(this).val();
        var biayaTambahan = 0;
        if (selectedPax == 3) {
            biayaTambahan = 1000000; // 1 juta for 3 pax
        } else if (selectedPax == 2) {
            biayaTambahan = 2000000; // 2 juta for 2 pax
        }
        $('input[name="biaya_tambahan"]').val(biayaTambahan);
        formatNumber($('input[name="biaya_tambahan"]')[0]); // Format after setting value
    });

    $('form').on('submit', function() {
        $('input[name="biaya_tambahan"]').val(function() {
            return unformatNumber($(this).val());
        });
    });
});
</script>
@endsection

