@extends('layouts.app1')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
  href="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">

@endsection
@section('content')
<div class="row ">
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="card">
      <div class="card-statistic-4">
        <div class="align-items-center justify-content-between">
          <div class="row ">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
              <div class="card-content">
                <h5 class="font-15">Total Jadwal Bulan Ini</h5>
                <h2 class="mb-3 font-18">{{ $totalJadwalCurrent }}</h2>
                <p class="mb-0"><span class="col-{{ $jadwalChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                    number_format($jadwalChange['percentage'], 0) }}%</span> {{ ucfirst($jadwalChange['type']) }}</p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
              <div class="banner-img">
                <img src="/admin/assets/img/banner/1.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="card">
      <div class="card-statistic-4">
        <div class="align-items-center justify-content-between">
          <div class="row ">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
              <div class="card-content">
                <h5 class="font-15"> Total Jemaah Bulan ini</h5>
                <h2 class="mb-3 font-18">{{ number_format($totalJemaahCurrent, 0, ',', '.') }}</h2>
                <p class="mb-0"><span class="col-{{ $jemaahChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                    number_format($jemaahChange['percentage'], 0) }}%</span> {{ ucfirst($jemaahChange['type']) }}</p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
              <div class="banner-img">
                <img src="/admin/assets/img/banner/2.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="card">
      <div class="card-statistic-4">
        <div class="align-items-center justify-content-between">
          <div class="row ">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
              <div class="card-content">
                <h5 class="font-15">Total Jemaah yang Batal</h5>
                <h2 class="mb-3 font-18">{{ $totalBatalCurrent }}</h2>
                <p class="mb-0"><span class="col-{{ $batalChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                    number_format($batalChange['percentage'], 0) }}%</span>
                  {{ ucfirst($batalChange['type']) }}</p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
              <div class="banner-img">
                <img src="/admin/assets/img/banner/3.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="card">
      <div class="card-statistic-4">
        <div class="align-items-center justify-content-between">
          <div class="row ">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
              <div class="card-content">
                <h5 class="font-15">Total Pemasukan Bulan ini</h5>
                <h2 class="mb-3 font-18">Rp {{ number_format($totalPemasukanCurrent, 0, ',', '.') }}</h2>
                <p class="mb-0"><span class="col-{{ $pemasukanChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                    number_format($pemasukanChange['percentage'], 0) }}%</span> {{ ucfirst($pemasukanChange['type']) }}
                </p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
              <div class="banner-img">
                <img src="/admin/assets/img/banner/4.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card ">
      <div class="card-header">
        <h4>Chart Tahun ini</h4>
        <div class="card-header-action">
          <div class="dropdown">
            <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Options</a>
            <div class="dropdown-menu">
              <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
              <a href="#" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
                Delete</a>
            </div>
          </div>
          <a href="#" class="btn btn-primary">View All</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-9">
            <div id="dashboard-chart"></div>
            <div class="row mb-0">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="list-inline text-center">
                  <div class="list-inline-item p-r-30"><i
                      data-feather="{{ $pemasukanWeekChange['type'] == 'increase' ? 'arrow-up-circle' : 'arrow-down-circle' }}"
                      class="{{ $pemasukanWeekChange['type'] == 'increase' ? 'col-green' : 'col-orange' }}"></i>
                    <h5 class="m-b-0">Rp {{ number_format($totalPemasukanWeek, 0, ',', '.') }}</h5>
                    <p class="text-muted font-14 m-b-0">Pendapatan Minggu Ini</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="list-inline text-center">
                  <div class="list-inline-item p-r-30"><i
                      data-feather="{{ $pemasukanChange['type'] == 'increase' ? 'arrow-up-circle' : 'arrow-down-circle' }}"
                      class="{{ $pemasukanChange['type'] == 'increase' ? 'col-green' : 'col-orange' }}"></i>
                    <h5 class="m-b-0">Rp {{ number_format($totalPemasukanCurrent, 0, ',', '.') }}</h5>
                    <p class="text-muted font-14 m-b-0">Pendapatan Bulan Ini</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="list-inline text-center">
                  <div class="list-inline-item p-r-30"><i
                      data-feather="{{ $pemasukanYearChange['type'] == 'increase' ? 'arrow-up-circle' : 'arrow-down-circle' }}"
                      class="{{ $pemasukanYearChange['type'] == 'increase' ? 'col-green' : 'col-orange' }}"></i>
                    <h5 class="mb-0 m-b-0">Rp {{ number_format($totalPemasukanYear, 0, ',', '.') }}</h5>
                    <p class="text-muted font-14 m-b-0">Pendapatan Tahun Ini</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="row mt-5">
              <div class="col-7 col-xl-7 mb-3">Rata-rata Jemaah per bulan </div>
              <div class="col-5 col-xl-5 mb-3">
                <span class="text-big">{{ number_format($avgJemaahPerMonth, 0, ',', '.') }}</span>
                <sup class="col-{{ $avgJemaahChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                  $avgJemaahChange['type'] == 'increase' ? '+' : '-' }}{{ number_format($avgJemaahChange['percentage'],
                  0) }}%</sup>
              </div>
              <div class="col-7 col-xl-7 mb-3">Jemaah Tertinggi dalam 1 Bulan</div>
              <div class="col-5 col-xl-5 mb-3">
                <span class="text-big">{{ number_format($highestJemaah, 0, ',', '.') }}</span>
                <sup class="col-{{ $highestJemaahChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                  $highestJemaahChange['type'] == 'increase' ? '+' : '-' }}{{
                  number_format($highestJemaahChange['percentage'], 0) }}%</sup>
              </div>
              <div class="col-7 col-xl-7 mb-3"> Jemaah Terendah dalam 1 Bulan</div>
              <div class="col-5 col-xl-5 mb-3">
                <span class="text-big">{{ number_format($lowestJemaah, 0, ',', '.') }}</span>
                <sup class="col-{{ $lowestJemaahChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                  $lowestJemaahChange['type'] == 'increase' ? '+' : '-' }}{{
                  number_format($lowestJemaahChange['percentage'], 0) }}%</sup>
              </div>
              <div class="col-7 col-xl-7 mb-3">Total Keberangkatan Tahun ini</div>
              <div class="col-5 col-xl-5 mb-3">
                <span class="text-big">{{ number_format($totalKeberangkatanYear, 0, ',', '.') }}</span>
                <sup class="col-{{ $keberangkatanChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                  $keberangkatanChange['type'] == 'increase' ? '+' : '-' }}{{
                  number_format($keberangkatanChange['percentage'], 0) }}%</sup>
              </div>
              <div class="col-7 col-xl-7 mb-3">Total Jemaah Tahun ini</div>
              <div class="col-5 col-xl-5 mb-3">
                <span class="text-big">{{ number_format($totalJemaahYear, 0, ',', '.') }}</span>
                <sup class="col-{{ $totalJemaahChange['type'] == 'increase' ? 'green' : 'orange' }}">{{
                  $totalJemaahChange['type'] == 'increase' ? '+' : '-' }}{{
                  number_format($totalJemaahChange['percentage'], 0) }}%</sup>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="section-body">
  <div class="row">
    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Jadwal Keberangkatan Terdekat</h4>
          <div class="card-header-action">
            <a href="{{ route('jadwal-keberangkatan.index') }}" class="btn btn-primary">View All</a>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped mb-0">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Paket</th>
                  <th>Kuota</th>
                  <th>Terdaftar</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($upcomingSchedules as $jadwal)
                <tr>
                  <td>{{ $jadwal->tgl_berangkat->format('d M Y') }}</td>
                  <td>{{ $jadwal->paket->nama_paket ?? '-' }}</td>
                  <td>{{ $jadwal->kuota }}</td>
                  <td>{{ $jadwal->pendaftaran->count() }}</td>
                  <td>
                    @php
                    $perc = $jadwal->kuota > 0 ? ($jadwal->pendaftaran->count() / $jadwal->kuota) * 100 : 0;
                    $color = 'success';
                    if($perc >= 100) $color = 'danger';
                    elseif($perc >= 80) $color = 'warning';
                    @endphp
                    <div class="badge badge-{{ $color }}">{{ $jadwal->status }}</div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center">Tidak ada jadwal keberangkatan dalam waktu dekat.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Aktivitas Terbaru</h4>
          <div class="card-header-action">
            <a href="{{ route('log-activity.index') }}" class="btn btn-primary">View All</a>
          </div>
        </div>
        <div class="card-body">
          <ul class="list-unstyled list-unstyled-border">
            @forelse($recentActivities as $activity)
            <li class="media">
              <div class="mr-3">
                <div class="bg-primary text-white rounded-circle p-2 d-flex justify-content-center align-items-center"
                  style="width: 40px; height: 40px;">
                  <i class="fas fa-{{ $activity->getIconForEvent() }}"></i>
                </div>
              </div>
              <div class="media-body">
                <div class="float-right text-primary">{{ $activity->created_at->diffForHumans() }}</div>
                <div class="media-title">{{ $activity->causer->name ?? 'System' }}</div>
                <span class="text-small text-muted">{{ $activity->description }} on {{
                  class_basename($activity->subject_type) }}</span>
              </div>
            </li>
            @empty
            <li class="media">
              <div class="media-body text-center">
                Belum ada aktivitas tercatat.
              </div>
            </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Monitoring Jemaah (Keberangkatan < 30 Hari)</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>
                <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th>Nama Jemaah</th>
                  <th>No. Telepon</th>
                  <th>Tanggal Berangkat</th>
                  <th>Status Berkas</th>
                  <th>Pax</th>
                  <th>Status Pembayaran</th>
                  <th>Sisa Tagihan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($jemaahs as $jemaah)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $jemaah->nama_jemaah }}</td>
                  <td>{{ $jemaah->no_tlp ?? '-' }}</td>
                  <td>{{ $jemaah->jadwalOverride ? $jemaah->jadwalOverride->tgl_berangkat->format('d/m/Y') :
                    $jemaah->pendaftaran->jadwalKeberangkatan->tgl_berangkat->format('d/m/Y') }}</td>
                  <td>
                    @if($jemaah->status_berkas == 'Lengkap')
                    <div class="badge badge-success badge-shadow">Lengkap</div>
                    @else
                    <div class="badge badge-danger badge-shadow">Belum Lengkap</div>
                    @endif
                  </td>
                  <td>{{ $jemaah->pax }}</td>
                  <td>
                    @if($jemaah->status_pembayaran == 'Lunas')
                    <div class="badge badge-success badge-shadow">Lunas</div>
                    @elseif($jemaah->status_pembayaran == 'Dibatalkan')
                    <div class="badge badge-danger badge-shadow">Dibatalkan</div>
                    @else
                    <div class="badge badge-warning badge-shadow">Belum Lunas</div>
                    @endif
                  </td>
                  <td>Rp {{ number_format($jemaah->sisa_tagihan, 0, ',', '.') }}</td>
                  <td>
                    <div class="dropdown">
                      <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Options</a>
                      <div class="dropdown-menu">
                        <a href="{{ route('jemaah.show', $jemaah->id) }}" class="dropdown-item has-icon"><i
                            class="fas fa-eye"></i> View</a>
                        <a href="{{ route('jemaah.edit', $jemaah->id) }}" class="dropdown-item has-icon"><i
                            class="far fa-edit"></i> Edit</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('jemaah.destroy', $jemaah->id) }}" method="POST"
                          style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <a href="#"><button type="submit" class="dropdown-item has-icon text-danger"
                              onclick="return confirm('Apakah Anda yakin ingin menghapus jemaah ini?')"
                              style="border: none; background: none;"><i class="far fa-trash-alt"></i>
                              Delete</button></a>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9" class="text-center">Tidak ada data jemaah dengan keberangkatan mendekati dan status
                    belum lengkap.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('admin/assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
</script>
<script src="{{ asset('admin/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
  $("#table-1").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0, 8] }
  ]
});

$(function () {
    // New chart rendering
    var chartData = @json($chartData);

    if (chartData.labels.length > 0) {
        var options = {
            chart: {
                height: 230,
                type: "line",
                shadow: {
                    enabled: true,
                    color: "#000",
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 1
                },
                toolbar: {
                    show: false
                }
            },
    colors: ["#786BED", "#999b9c", "#28a745"],
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: "smooth"
            },
            series: @json($chartData['series']),
            grid: {
                borderColor: "#e7e7e7",
                row: {
                    colors: ["#f3f3f3", "transparent"],
                    opacity: 0.0
                }
            },
            markers: {
                size: 6
            },
            xaxis: {
                categories: @json($chartData['labels']),
                labels: {
                    style: {
                        colors: "#9aa0ac"
                    }
                }
            },
            yaxis: {
                title: {
                    text: "Jumlah Jemaah"
                },
                labels: {
                    style: {
                        color: "#9aa0ac"
                    }
                },
            },
            legend: {
                position: "top",
                horizontalAlign: "right",
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart = new ApexCharts(document.querySelector("#dashboard-chart"), options);
        chart.render();
    }
});
</script>
@endsection