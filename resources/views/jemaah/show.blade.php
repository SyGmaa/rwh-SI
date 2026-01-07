@extends('layouts.app')

@section('title', 'Detail Jemaah')

@section('css')
<!-- <link rel="stylesheet" href="{{ asset('admin/assets/bundles/chocolat/dist/css/chocolat.css') }}"> -->
<style>
  .section-header-button a {
    text-decoration: none;
  }
</style>
@endsection

@section('content')
<div class="section-header">
  <h1>Detail Jemaah</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('jemaah.index') }}">Data Jemaah</a></div>
    <div class="breadcrumb-item">Detail</div>
  </div>
</div>

<div class="section-body">
  <div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-8">

      <!-- Personal Information Card -->
      <div class="card">
        <div class="card-header">
          <h4>
            <i class="fas fa-user text-primary mr-2"></i> Informasi Jemaah
          </h4>
          <div class="card-header-action">
            @if($jemaah->status_berkas == 'Lengkap')
            <span class="badge badge-success">Berkas: Lengkap</span>
            @else
            <span class="badge badge-warning">Berkas: Belum Lengkap</span>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold text-muted text-uppercase" style="font-size: 12px;">Nama Lengkap</label>
              <h6 class="text-dark">{{ $jemaah->nama_jemaah }}</h6>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold text-muted text-uppercase" style="font-size: 12px;">Nomor Telepon</label>
              <h6 class="text-dark">{{ $jemaah->no_tlp ?? '-' }}</h6>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold text-muted text-uppercase" style="font-size: 12px;">Jumlah Pax</label>
              <h6 class="text-dark">{{ $jemaah->pax }} Pax</h6>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold text-muted text-uppercase" style="font-size: 12px;">Status
                Pembayaran</label>
              <div>
                @if($jemaah->status_pembayaran == 'Lunas')
                <span class="badge badge-success">Lunas</span>
                @elseif($jemaah->status_pembayaran == 'Dibatalkan')
                <span class="badge badge-danger">Dibatalkan</span>
                @else
                <span class="badge badge-warning">Belum Lunas</span>
                @endif
              </div>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold text-muted text-uppercase" style="font-size: 12px;">Biaya Tambahan</label>
              <h6 class="text-dark">Rp {{ number_format($jemaah->biaya_tambahan, 0, ',', '.') }}</h6>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold text-muted text-uppercase" style="font-size: 12px;">Sisa Tagihan</label>
              <h6 class="text-danger">Rp {{ number_format($jemaah->sisa_tagihan, 0, ',', '.') }}</h6>
            </div>
          </div>
        </div>
      </div>

      <!-- Package & Schedule Info -->
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4><i class="fas fa-box text-info mr-2"></i> Informasi Paket</h4>
            </div>
            <div class="card-body">
              <div class="form-group mb-3">
                <label class="font-weight-bold text-muted text-uppercase" style="font-size: 11px;">Jenis & Nama
                  Paket</label>
                <div class="font-weight-bold text-dark">{{
                  $jemaah->pendaftaran->jadwalKeberangkatan->paket->jenisPaket->nama_jenis }}</div>
                <div class="text-small text-muted">{{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->nama_paket }}
                </div>
              </div>
              <div class="row">
                <div class="col-6 form-group mb-3">
                  <label class="font-weight-bold text-muted text-uppercase" style="font-size: 11px;">Harga</label>
                  <div class="font-weight-bold text-dark">Rp {{
                    number_format($jemaah->pendaftaran->jadwalKeberangkatan->paket->harga, 0, ',', '.') }}</div>
                </div>
                <div class="col-6 form-group mb-3">
                  <label class="font-weight-bold text-muted text-uppercase" style="font-size: 11px;">Durasi</label>
                  <div class="font-weight-bold text-dark">{{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->jml_hari
                    }} Hari</div>
                </div>
              </div>
              <div class="form-group mb-0">
                <label class="font-weight-bold text-muted text-uppercase" style="font-size: 11px;">Keterangan</label>
                <div class="text-small text-dark">{{ $jemaah->pendaftaran->jadwalKeberangkatan->paket->keterangan ?? '-'
                  }}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4><i class="fas fa-calendar-alt text-warning mr-2"></i> Jadwal Keberangkatan</h4>
            </div>
            <div class="card-body">
              <div class="form-group mb-4">
                <label class="font-weight-bold text-muted text-uppercase" style="font-size: 11px;">Tanggal
                  Berangkat</label>
                <h5 class="text-dark">
                  {{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->tgl_berangkat->format('d/m/Y') :
                  $jemaah->pendaftaran->jadwalKeberangkatan->tgl_berangkat->format('d/m/Y') }}
                </h5>
              </div>
              <div class="row">
                <div class="col-6 form-group mb-3">
                  <label class="font-weight-bold text-muted text-uppercase" style="font-size: 11px;">Kuota Total</label>
                  <div class="font-weight-bold text-dark">{{ $jemaah->jadwalOverride ?
                    $jemaah->jadwalOverride->total_kuota : $jemaah->pendaftaran->jadwalKeberangkatan->total_kuota }}
                  </div>
                </div>
                <div class="col-6 form-group mb-3">
                  <label class="font-weight-bold text-muted text-uppercase" style="font-size: 11px;">Sisa Kuota</label>
                  <div class="font-weight-bold text-dark">{{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->kuota :
                    $jemaah->pendaftaran->jadwalKeberangkatan->kuota }}</div>
                </div>
              </div>
              <div class="form-group mb-0">
                <label class="font-weight-bold text-muted text-uppercase" style="font-size: 11px;">Status</label>
                <div>
                  <span class="badge badge-info">
                    {{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->status :
                    $jemaah->pendaftaran->jadwalKeberangkatan->status }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Document Gallery -->
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-file-alt text-danger mr-2"></i> Dokumen Jemaah</h4>
        </div>
        <div class="card-body">
          @if($jemaah->dokumenJemaah->count() > 0)
          <div class="row">
            @foreach($jemaah->dokumenJemaah as $dokumen)
            @php
            $extension = strtolower(pathinfo($dokumen->file_path, PATHINFO_EXTENSION));
            $fileUrl = asset('storage/' . $dokumen->file_path);
            @endphp
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
              <div class="card card-primary h-100 shadow-sm">
                <div class="card-img-top overflow-hidden"
                  style="height: 150px; background-color: #f4f6f9; display: flex; align-items: center; justify-content: center;">
                  @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                  <img src="{{ $fileUrl }}" alt="{{ $dokumen->jenisDokumen->nama_jenis }}" class="img-fluid"
                    style="object-fit: cover; height: 100%; width: 100%;">
                  @elseif($extension === 'pdf')
                  <iframe src="{{ route('jemaah.dokumen.preview', $dokumen->id) }}#toolbar=0&navpanes=0&scrollbar=0"
                    style="width: 100%; height: 100%; border: none;"></iframe>
                  @else
                  <div class="text-center text-muted">
                    <i class="fas fa-file text-secondary fa-4x mb-2"></i>
                    <div class="text-uppercase small font-weight-bold">{{ $extension }} FILE</div>
                  </div>
                  @endif
                </div>
                <div class="card-body p-3">
                  <h6 class="card-title text-truncate mb-1" title="{{ $dokumen->jenisDokumen->nama_jenis }}">
                    {{ $dokumen->jenisDokumen->nama_jenis }}
                  </h6>
                  <small class="text-muted d-block mb-3">{{ $dokumen->tanggal_upload->format('d M Y, H:i') }}</small>
                  <a href="{{ route('jemaah.dokumen.preview', $dokumen->id) }}" target="_blank"
                    class="btn btn-outline-primary btn-sm btn-block">
                    Lihat Detail
                  </a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          @else
          <div class="empty-state" data-height="200" style="height: 200px;">
            <div class="empty-state-icon">
              <i class="fas fa-folder-open"></i>
            </div>
            <h2>Belum ada dokumen</h2>
            <p class="lead">
              Belum ada dokumen yang diupload untuk jemaah ini.
            </p>
          </div>
          @endif
        </div>
      </div>

    </div>

    <!-- Sidebar Info Column -->
    <div class="col-12 col-md-12 col-lg-4">

      <!-- Actions -->
      <div class="card mb-4">
        <div class="card-body">
          <a href="{{ route('jemaah.index') }}" class="btn btn-secondary btn-block mb-2">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
          </a>
          <a href="{{ route('jemaah.edit', $jemaah->id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-edit mr-1"></i> Edit Data
          </a>
        </div>
      </div>

      <!-- Registration Summary Info -->
      <div class="card card-primary">
        <div class="card-header">
          <h4><i class="fas fa-clipboard-list text-primary mr-2"></i> Info Pendaftaran</h4>
        </div>
        <div class="card-body">
          <div class="media mb-4">
            <div class="media-icon bg-primary-transparent text-primary mr-3 rounded-circle p-2"
              style="background: rgba(103, 119, 239, 0.1);">
              <i class="fas fa-user-circle fa-2x text-primary"></i>
            </div>
            <div class="media-body">
              <h6 class="media-title mb-0 text-muted small text-uppercase font-weight-bold">Pendaftar Utama</h6>
              <div class="media-description font-weight-bold text-dark">{{ $jemaah->pendaftaran->nama_pendaftar }}</div>
              <div class="text-small text-muted">{{ $jemaah->pendaftaran->no_tlp }}</div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-6 mb-3">
              <label class="font-weight-bold text-muted small text-uppercase">Uang Muka (DP)</label>
              <div class="font-weight-bold text-dark">Rp {{ number_format($jemaah->pendaftaran->dp, 0, ',', '.') }}
              </div>
            </div>
            <div class="col-6 mb-3">
              <label class="font-weight-bold text-muted small text-uppercase">Metode Bayar</label>
              <div class="font-weight-bold text-dark">{{ $jemaah->pendaftaran->metode_bayar }}</div>
            </div>
            <div class="col-12">
              <label class="font-weight-bold text-muted small text-uppercase">Tanggal Daftar</label>
              <div class="font-weight-bold text-dark">{{ $jemaah->pendaftaran->tgl_daftar->format('d F Y, H:i') }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Installment History -->
      <div class="card card-success">
        <div class="card-header">
          <h4><i class="fas fa-money-bill-wave text-success mr-2"></i> Riwayat Cicilan</h4>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="p-3">Tgl Bayar</th>
                  <th class="p-3 text-right">Nominal</th>
                </tr>
              </thead>
              <tbody>
                @forelse($jemaah->cicilans as $cicilan)
                <tr>
                  <td class="p-3">
                    <div class="font-weight-bold text-dark">{{ $cicilan->tgl_bayar->format('d/m/Y') }}</div>
                    <div class="text-small text-muted">{{ $cicilan->metode_bayar }}</div>
                  </td>
                  <td class="p-3 text-right">
                    <div class="font-weight-bold text-success">+ Rp {{ number_format($cicilan->nominal_cicilan, 0, ',',
                      '.') }}</div>
                    <div class="text-small text-muted font-monospace">{{ $cicilan->kode_cicilan }}</div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="2" class="text-center py-4 text-muted font-italic">
                    Belum ada data cicilan
                  </td>
                </tr>
                @endforelse
              </tbody>
              <tfoot class="bg-light">
                <tr>
                  <td class="p-3 font-weight-bold text-dark">Total Cicilan</td>
                  <td class="p-3 font-weight-bold text-success text-right">
                    Rp {{ number_format($jemaah->cicilans->sum('nominal_cicilan'), 0, ',', '.') }}
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('js')
<!-- Add component specific JS if needed -->
@endsection
