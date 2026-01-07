@extends('layouts.app')
@section('content')
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah Jadwal Keberangkatan</h4>
                  </div>
                  <div class="card-body">
                    @if(session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif
                    <form action="{{ route('jadwal-keberangkatan.store') }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label>Paket</label>
                        <select name="paket_id" class="form-control" required>
                          <option value="">Pilih Paket</option>
                          @foreach($pakets as $paket)
                            <option value="{{ $paket->id }}">{{ $paket->nama_paket }} - {{ $paket->jml_hari }} Hari - Rp {{ number_format($paket->harga, 0, ',', '.') }}</option>
                          @endforeach
                        </select>
                        @error('paket_id')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Tanggal Berangkat</label>
                        <input type="date" name="tgl_berangkat" class="form-control" value="{{ old('tgl_berangkat') }}" required>
                        @error('tgl_berangkat')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label>Total Kuota</label>
                        <input type="number" name="kuota" class="form-control" value="{{ old('kuota') }}" min="0" required>
                        @error('kuota')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                          <option value="">Pilih Status</option>
                          <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                          <option value="Penuh" {{ old('status') == 'Penuh' ? 'selected' : '' }}>Penuh</option>
                          <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                          <option value="Dibatalkan" {{ old('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
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
                    </div>
                      <div class="card-footer">
                      <button class="btn btn-primary mr-1" type="submit">Submit</button>
                      <a href="{{ route('jadwal-keberangkatan.index', ['jenis_id' => $jenisId]) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
@endsection

