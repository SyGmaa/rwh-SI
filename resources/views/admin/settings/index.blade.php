@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pengaturan Aplikasi</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Perusahaan</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ $settings['company_name'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea name="company_address" class="form-control"
                                    style="height: 100px;">{{ $settings['company_address'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No. Telepon</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="company_phone" class="form-control"
                                    value="{{ $settings['company_phone'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="email" name="company_email" class="form-control"
                                    value="{{ $settings['company_email'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo Perusahaan</label>
                            <div class="col-sm-12 col-md-7">
                                @if(isset($settings['company_logo']))
                                <div class="mb-2">
                                    <!-- Check if it is a storage path or default asset -->
                                    @if(str_contains($settings['company_logo'], 'admin/assets'))
                                    <img src="{{ asset($settings['company_logo']) }}" alt="Logo"
                                        style="max-height: 100px;">
                                    @else
                                    <img src="{{ asset('storage/' . $settings['company_logo']) }}" alt="Logo"
                                        style="max-height: 100px;">
                                    @endif
                                </div>
                                @endif
                                <input type="file" name="company_logo" class="form-control">
                                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB.</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <div class="mt-4">
                        <h5>Maintenance & Maintenance</h5>
                        <p class="text-muted">Gunakan fitur ini untuk memicu pencadangan database secara manual.</p>
                        <form action="{{ route('settings.backup') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-database"></i> Cadangkan Database (.sql)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
