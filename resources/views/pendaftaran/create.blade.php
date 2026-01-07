@extends('layouts.app')
@section('content')
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah Pendaftaran</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('pendaftaran.store') }}" method="POST" id="pendaftaranForm">
                      @csrf
                      <div class="form-group">
                        <label>Jadwal Keberangkatan</label>
                        <select name="jadwal_id" class="form-control" required>
                          <option value="">Pilih Jadwal Keberangkatan</option>
                          @foreach($jadwalKeberangkatans as $jadwal)
                            <option value="{{ $jadwal->id }}">{{ $jadwal->paket->nama_paket }} - {{ $jadwal->paket->jml_hari }} Hari - Rp {{ number_format($jadwal->paket->harga, 0, ',', '.') }} - {{ $jadwal->tgl_berangkat->format('d/m/Y') }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="row">
                        <div class="col-7">
                          <div class="form-group">
                            <label>Nama Pendaftar</label>
                            <input type="text" name="nama_pendaftar[]" class="form-control" required>
                          </div>
                        </div>
                        <div class="col-5">
                          <div class="form-group">
                            <label>No. Telepon</label>
                            <input type="text" name="no_tlp[]" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div id="anggotaContainer"></div>
                      <div class="form-group">
                        <button type="button" class="btn btn-success" id="tambahAnggota">Tambah Anggota</button>
                      </div>
                      <div class="form-group">
                      <div class="control-label">Pax</div>
                      <div class="custom-switches-stacked mt-2">
                        <label class="custom-switch">
                          <input type="radio" name="option" value="2" class="custom-switch-input" >
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">2 Pax</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="3" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">3 Pax</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="4" class="custom-switch-input" checked>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">4 Pax</span>
                        </label>
                      </div>
                    </div>
                      <div class="form-group">
                        <label>Uang Muka Per Orang</label>
                        <input type="text" name="dp" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Metode Bayar</label>
                        <select name="metode_bayar" class="form-control" required>
                          <option value="Transfer">Transfer</option>
                          <option value="Tunai">Tunai</option>
                        </select>
                      </div>
                    <div class="form-group">
                      <label>Bukti Pembayaran</label>
                      <input type="file" class="form-control">
                    </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
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

    $('#tambahAnggota').click(function() {
        var anggotaRow = `
            <div class="row anggota-row mb-3">
              <div class="col-7">
                <div class="form-group">
                  <label>Nama Jemaah</label>
                  <input type="text" name="nama_pendaftar[]" class="form-control" required>
                </div>
              </div>
              <div class="col-md-4 col-3">
                <div class="form-group">
                  <label>No. Telepon</label>
                  <input type="text" name="no_tlp[]" class="form-control">
                </div>
              </div>
              <div class="col-1">
                <div class="form-group">
                  <button type="button" class="btn btn-danger btn-sm remove-anggota" style= "margin-top: 32px;"><i class="fas fa-times"></i></button>
                </div>
              </div>
            </div>
        `;
        $('#anggotaContainer').append(anggotaRow);
    });

    $(document).on('click', '.remove-anggota', function() {
        $(this).closest('.anggota-row').remove();
    });

    $('#pendaftaranForm').on('submit', function() {
        $('input[name="dp"]').val(function() {
            return unformatNumber($(this).val());
        });
    });
});
</script>
@endsection

