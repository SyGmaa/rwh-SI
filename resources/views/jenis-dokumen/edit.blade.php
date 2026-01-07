@extends('layouts.app')
@section('content')
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Jenis Dokumen</h4>
                  </div>
                  <div class="card-body">
                    @if(session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif
                    <form action="{{ route('jenis-dokumen.update', $jenisDokumen->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label>Nama Jenis</label>
                        <input type="text" name="nama_jenis" class="form-control" value="{{ old('nama_jenis', $jenisDokumen->nama_jenis) }}" required>
                        @error('nama_jenis')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" value="{{ old('deskripsi', $jenisDokumen->deskripsi) }}">
                        @error('deskripsi')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <div class="control-label">Wajib Upload</div>
                        <div class="custom-switches-stacked mt-2">
                          <label class="custom-switch">
                            <input type="radio" name="wajib_upload" value="1" class="custom-switch-input" {{ old('wajib_upload', $jenisDokumen->wajib_upload) == 1 ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Ya</span>
                          </label>
                          <label class="custom-switch">
                            <input type="radio" name="wajib_upload" value="0" class="custom-switch-input" {{ old('wajib_upload', $jenisDokumen->wajib_upload) == 0 ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Tidak</span>
                          </label>
                        </div>
                        @error('wajib_upload')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <div class="control-label">Status</div>
                        <div class="custom-switches-stacked mt-2">
                          <label class="custom-switch">
                            <input type="radio" name="is_active" value="1" class="custom-switch-input" {{ old('is_active', $jenisDokumen->is_active) == 1 ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Aktif</span>
                          </label>
                          <label class="custom-switch">
                            <input type="radio" name="is_active" value="0" class="custom-switch-input" {{ old('is_active', $jenisDokumen->is_active) == 0 ? 'checked' : '' }}>
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
                      <button class="btn btn-primary mr-1" type="submit">Update</button>
                      <a href="{{ route('jenis-dokumen.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
@endsection

