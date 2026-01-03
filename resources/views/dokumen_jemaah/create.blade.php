@extends('layouts.app1')

@section('content')
<div class="section-body">
  {{-- Form utama untuk semua dokumen --}}
  <form action="{{ route('dokumen-jemaah.store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
    @csrf

    <div class="row" id="form-container">
      <div class="col-8 form-card">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Dokumen Jemaah</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Jemaah</label>
              <select name="jemaah_id[]" class="form-control jemaah-select" required>
                <option value="">Pilih Jemaah</option>
                @foreach($jemaahs as $jemaah)
                  <option value="{{ $jemaah->id }}" {{ request('jemaah_id') == $jemaah->id ? 'selected' : '' }}>
                    {{ $jemaah->nama_jemaah }} - {{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->nama_paket }} - {{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->jml_hari }} Hari - Rp {{ number_format($jemaah->pendaftaran->jadwalKeberangkatan->paket->harga, 0, ',', '.') }} - {{ $jemaah->pendaftaran->jadwalKeberangkatan->tgl_berangkat->format('d/m/Y') }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Jenis Dokumen</label>
              <select name="jenis_id[]" class="form-control jenis-select" required>
                <option value="">Pilih Jenis Dokumen</option>
                @foreach($jenisDokumens as $jenisDokumen)
                  <option value="{{ $jenisDokumen->id }}">{{ $jenisDokumen->nama_jenis }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>File Dokumen</label>
              <input type="file" name="file_path[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
              <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB.</small>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="button" class="btn btn-danger remove-card d-none mt-1">Hapus</button>
          </div>
        </div>
      </div>
    </div>

    {{-- Tombol Tambah dan Submit --}}
    <div class="row mt-3">
      <div class="col-8 text-right">
        <button type="button" class="btn btn-success" id="addFormBtn">+ Tambah Dokumen</button>
        <button type="submit" class="btn btn-primary" id="submitAllBtn">Submit Semua</button>
        <a href="{{ route('dokumen-jemaah.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </div>
  </form>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const addBtn = document.getElementById('addFormBtn');
  const formContainer = document.getElementById('form-container');
  let usedJenis = [];

  // Update daftar jenis dokumen yang sudah dipakai
  function updateUsedJenis() {
    usedJenis = Array.from(document.querySelectorAll('.jenis-select'))
      .map(select => select.value)
      .filter(v => v !== "");
  }

  // Ambil nilai jemaah terakhir
  function getCurrentJemaahValue() {
    const last = document.querySelector('.form-card:last-child .jemaah-select');
    return last ? last.value : '';
  }

  // Ketika tambah form ditekan
  addBtn.addEventListener('click', function() {
    const firstForm = document.querySelector('.form-card');
    const clone = firstForm.cloneNode(true);

    // Reset semua input di form baru
    clone.querySelectorAll('input[type="file"]').forEach(el => el.value = '');
    clone.querySelectorAll('select').forEach(el => el.value = '');

    // Ambil nilai jemaah dari form terakhir
    const lastJemaahValue = getCurrentJemaahValue();
    const jemaahSelect = clone.querySelector('.jemaah-select');
    if (lastJemaahValue) jemaahSelect.value = lastJemaahValue;

    // Filter jenis dokumen (disable yang sudah dipilih)
    const jenisSelect = clone.querySelector('.jenis-select');
    const options = jenisSelect.querySelectorAll('option');
    options.forEach(opt => {
      if (usedJenis.includes(opt.value) && opt.value !== '') {
        opt.disabled = true;
      } else {
        opt.disabled = false;
      }
    });

    // Tampilkan tombol hapus
    clone.querySelector('.remove-card').classList.remove('d-none');

    // Tambahkan ke container
    formContainer.appendChild(clone);
  });

  // Update usedJenis ketika pilihan berubah
  document.addEventListener('change', function(e) {
    if (e.target.classList.contains('jenis-select')) {
      updateUsedJenis();
      // Perbarui dropdown lain agar tidak bisa pilih yang sama
      document.querySelectorAll('.jenis-select').forEach(select => {
        select.querySelectorAll('option').forEach(opt => {
          if (usedJenis.includes(opt.value) && opt.value !== select.value && opt.value !== '') {
            opt.disabled = true;
          } else {
            opt.disabled = false;
          }
        });
      });
    }
  });

  // Hapus card
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-card')) {
      e.target.closest('.form-card').remove();
      updateUsedJenis();
    }
  });
});
</script>
@endsection
