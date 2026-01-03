@extends('layouts.app1')

@section('css')
@endsection

@section('content')
<div class="section-body">
  <form action="{{ route('cicilan-jemaah.store') }}" method="POST" enctype="multipart/form-data" id="cicilan-form">
    @csrf
    <div id="form-wrapper">
      <div class="row form-card">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Cicilan Jemaah</h4>
            </div>
            <div class="card-body">
              @if(session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div>
              @endif
              <div class="form-group">
                <label>Jemaah</label>
                <select name="cicilan[0][jemaah_id]" class="form-control jemaah-select" required>
                  <option value="">Pilih Jemaah</option>
                  @foreach($jemaahs as $jemaah)
                    <option value="{{ $jemaah->id }}">{{ $jemaah->nama_jemaah }} - {{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->nama_paket }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Nominal Cicilan</label>
                <input type="text" name="cicilan[0][nominal_cicilan]" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Metode Bayar</label>
                <select name="cicilan[0][metode_bayar]" class="form-control" required>
                  <option value="Transfer">Transfer</option>
                  <option value="Tunai">Tunai</option>
                </select>
              </div>

              <div class="form-group">
                <label>Bukti Bayar</label>
                <input type="file" name="cicilan[0][bukti_bayar]" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                <small class="form-text text-muted">Format: JPG, PNG, PDF. Maks 2MB.</small>
              </div>

              <div class="card-footer text-right">
                <button type="button" class="btn btn-danger remove-card d-none mt-1">Hapus</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Tombol Tambah & Submit --}}
    <div class="row mt-3">
      <div class="col-6 text-right">
        <button type="button" class="btn btn-success mt-1" id="addCardBtn">+ Tambah Cicilan Jemaah</button>
        <button class="btn btn-primary mt-1" type="submit">Submit semua</button>
        <a href="{{ route('cicilan-jemaah.index') }}" class="btn btn-outline-secondary mt-1">Cancel</a>
      </div>
    </div>
  </form>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const addBtn = document.getElementById('addCardBtn');
  const wrapper = document.getElementById('form-wrapper');

  // 🔹 Simpan semua select jemaah dalam NodeList
  const getAllSelects = () => document.querySelectorAll('.jemaah-select');

  // 🔹 Fungsi untuk format angka dengan titik
  function formatNumber(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-digits
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Add dot every 3 digits
    input.value = value;
  }

  // 🔹 Fungsi untuk update dropdown agar tidak bisa memilih jemaah yang sudah dipilih
  function updateJemaahOptions() {
    const selectedValues = Array.from(getAllSelects())
      .map(sel => sel.value)
      .filter(v => v !== '');

    getAllSelects().forEach(select => {
      const currentValue = select.value;
      select.querySelectorAll('option').forEach(opt => {
        if (opt.value && selectedValues.includes(opt.value) && opt.value !== currentValue) {
          opt.disabled = true; // Nonaktifkan opsi yang sudah dipilih di form lain
        } else {
          opt.disabled = false;
        }
      });
    });
  }

  // 🔹 Tambah form baru
  addBtn.addEventListener('click', function () {
    const allCards = document.querySelectorAll('.form-card');
    const index = allCards.length;
    const firstCard = document.querySelector('.form-card');
    const clone = firstCard.cloneNode(true);

    // Kosongkan semua input & select
    clone.querySelectorAll('input, select').forEach(el => {
      el.value = '';
      if (el.tagName === 'SELECT') el.selectedIndex = 0;
    });

    // Update name attributes with new index
    clone.querySelectorAll('input, select').forEach(el => {
      if (el.name) {
        el.name = el.name.replace(/cicilan\[\d+\]/, `cicilan[${index}]`);
      }
    });

    // Tampilkan tombol hapus
    clone.querySelector('.remove-card').classList.remove('d-none');

    // Hapus alert success
    const alert = clone.querySelector('.alert');
    if (alert) alert.remove();

    // Tambahkan card baru
    wrapper.appendChild(clone);

    // Update listener baru untuk dropdown
    attachSelectListener(clone.querySelector('.jemaah-select'));

    // Attach format listener to new nominal_cicilan input
    const newNominalInput = clone.querySelector('input[name="cicilan[' + index + '][nominal_cicilan]"]');
    if (newNominalInput) {
      newNominalInput.addEventListener('input', () => formatNumber(newNominalInput));
    }

    // Perbarui opsi setelah penambahan form
    updateJemaahOptions();
  });

  // 🔹 Listener untuk hapus form
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-card')) {
      e.target.closest('.form-card').remove();
      updateJemaahOptions();
    }
  });

  // 🔹 Listener untuk setiap select agar update otomatis
  function attachSelectListener(select) {
    select.addEventListener('change', updateJemaahOptions);
  }

  // Pasang listener awal
  getAllSelects().forEach(attachSelectListener);

  // Attach format listener to existing nominal_cicilan inputs
  document.querySelectorAll('input[name*="nominal_cicilan"]').forEach(input => {
    input.addEventListener('input', () => formatNumber(input));
  });

  // Unformat on form submit
  document.getElementById('cicilan-form').addEventListener('submit', function() {
    document.querySelectorAll('input[name*="nominal_cicilan"]').forEach(input => {
      input.value = input.value.replace(/\./g, '');
    });
  });
});
</script>
@endsection
