@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
  href="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">

<style>
  .skeleton {
    background-color: #e2e5e7;
    background-image: linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0));
    background-size: 200px 100%;
    background-repeat: no-repeat;
    background-position: left -200px top 0;
    animation: skeleton-loading 1.5s infinite;
  }

  @keyframes skeleton-loading {
    to {
      background-position: right -200px top 0;
    }
  }

  .skeleton-text {
    height: 12px;
    margin-bottom: 10px;
    border-radius: 4px;
    width: 100%;
  }

  .skeleton-chart {
    height: 230px;
    width: 100%;
    border-radius: 4px;
  }
</style>
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
                <h2 class="mb-3 font-18">{{ $totalPemasukanCurrentFormatted }}</h2>
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
        <h4>Statistik Jemaah</h4>
        <div class="card-header-action">
          <div class="btn-group">
            <button type="button" class="btn btn-outline-primary chart-filter active" data-filter="1_year">1
              Tahun</button>
            <button type="button" class="btn btn-outline-primary chart-filter" data-filter="6_months">6 Bulan</button>
            <button type="button" class="btn btn-outline-primary chart-filter" data-filter="this_month">Bulan
              Ini</button>
            <button type="button" class="btn btn-outline-primary" id="btn-pick-month">Pilih Bulan</button>
          </div>
          <input type="month" id="month-picker" class="form-control d-none ml-2" style="width: auto; height: 35px;">
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
                    <h5 class="m-b-0">{{ $totalPemasukanWeekFormatted }}</h5>
                    <p class="text-muted font-14 m-b-0">Pendapatan Minggu Ini</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="list-inline text-center">
                  <div class="list-inline-item p-r-30"><i
                      data-feather="{{ $pemasukanChange['type'] == 'increase' ? 'arrow-up-circle' : 'arrow-down-circle' }}"
                      class="{{ $pemasukanChange['type'] == 'increase' ? 'col-green' : 'col-orange' }}"></i>
                    <h5 class="m-b-0">{{ $totalPemasukanCurrentFormatted }}</h5>
                    <p class="text-muted font-14 m-b-0">Pendapatan Bulan Ini</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="list-inline text-center">
                  <div class="list-inline-item p-r-30"><i
                      data-feather="{{ $pemasukanYearChange['type'] == 'increase' ? 'arrow-up-circle' : 'arrow-down-circle' }}"
                      class="{{ $pemasukanYearChange['type'] == 'increase' ? 'col-green' : 'col-orange' }}"></i>
                    <h5 class="mb-0 m-b-0">{{ $totalPemasukanYearFormatted }}</h5>
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
      <div class="card gradient-bottom" style="height: 460px; display: flex; flex-direction: column;">
        <div class="card-header">
          <h4>Statistik Penjualan Paket (<span id="top-5-label">Tahun Ini</span>)</h4>
          <div class="card-header-action">
            <div class="btn-group">
              <button type="button" class="btn btn-primary top-5-filter active" data-filter="this_year">Tahun
                Ini</button>
              <button type="button" class="btn btn-outline-primary top-5-filter" data-filter="this_month">Bulan
                Ini</button>
              <button type="button" class="btn btn-outline-primary" id="btn-pick-month-top5">Pilih Bulan</button>
            </div>
            <input type="month" id="month-picker-top5" class="form-control d-none ml-2"
              style="width: auto; height: 35px; display: inline-block;">
          </div>
        </div>
        <div class="card-body" id="top-5-scroll" style="flex: 1; overflow: hidden; position: relative;">
          <div id="top-5-skeleton" class="d-none">
            @for($i=0; $i<5; $i++) <div class="media mb-3">
              <div class="skeleton mr-3 rounded" style="width: 55px; height: 50px;"></div>
              <div class="media-body">
                <div class="skeleton-text" style="width: 40%; height: 15px;"></div>
                <div class="skeleton-text" style="width: 80%; height: 10px;"></div>
                <div class="skeleton-text" style="width: 100%; height: 20px;"></div>
              </div>
          </div>
          @endfor
        </div>
        <ul class="list-unstyled list-unstyled-border" id="top-5-list">
          @forelse($topSellingPackages as $paket)
          <li class="media">
            {{-- Placeholder image since packages don't have images in schema yet, or use generic --}}
            <img class="mr-3 rounded" width="55" src="{{ asset('admin/assets/img/products/product-1.png') }}"
              alt="product">
            <div class="media-body">
              <div class="float-right">
                <div class="font-weight-600 text-muted text-small">{{ $paket->total_sales }} Sales</div>
              </div>
              <div class="media-title">{{ $paket->nama_paket }}</div>
              <div class="mt-1">
                <div class="budget-price">
                  <div class="budget-price-square bg-primary" data-width="{{ $paket->revenue_percentage }}%"></div>
                  <div class="budget-price-label">Rp {{ number_format($paket->revenue, 0, ',', '.') }}</div>
                </div>
              </div>
            </div>
          </li>
          @empty
          <li class="media">
            <div class="media-body text-center">
              Belum ada data penjualan paket tahun ini.
            </div>
          </li>
          @endforelse
        </ul>
      </div>
      <div class="card-footer pt-3 d-flex justify-content-center">
        <div class="budget-price justify-content-center">
          <div class="budget-price-square bg-primary" data-width="20"></div>
          <div class="budget-price-label">Total Pendapatan</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12 col-12 col-sm-12">
    <div class="card" style="height: 460px; display: flex; flex-direction: column;">
      <div class="card-header">
        <h4>Aktivitas Terbaru</h4>
        <div class="card-header-action">
          <a href="{{ route('log-activity.index') }}" class="btn btn-primary">View All</a>
        </div>
      </div>
      <div class="card-body" id="recent-activities-scroll" style="flex: 1; overflow: hidden; position: relative;">
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
        <h4>Monitoring Kuota Paket (Akan Datang)</h4>
      </div>
      <div class="card-body">
        <div class="row">
          @forelse($quotaSchedules as $jadwal)
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="p-3 border rounded shadow-sm">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0 text-primary">{{ $jadwal->paket->nama_paket }}</h6>
                <span class="badge badge-{{ $jadwal->status == 'Sold Out' ? 'danger' : 'info' }}">{{ $jadwal->status
                  }}</span>
              </div>
              <div class="text-small text-muted mb-2">
                <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($jadwal->tgl_berangkat)->format('d M Y')
                }}
              </div>
              <div class="d-flex justify-content-between mb-1">
                <span class="text-small">Terisi: <strong>{{ $jadwal->terisi }}</strong> / {{ $jadwal->total_kuota
                  }}</span>
                <span class="text-small">{{ $jadwal->persentase }}%</span>
              </div>
              <div class="progress" style="height: 10px;">
                <div
                  class="progress-bar bg-{{ $jadwal->persentase >= 90 ? 'danger' : ($jadwal->persentase >= 70 ? 'warning' : 'success') }}"
                  role="progressbar" style="width: {{ $jadwal->persentase }}%" aria-valuenow="{{ $jadwal->persentase }}"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12 text-center text-muted">
            Tidak ada jadwal keberangkatan aktif.
          </div>
          @endforelse
        </div>
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
                      <form action="{{ route('jemaah.destroy', $jemaah->id) }}" method="POST" style="display: inline;">
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
    var chart;

    function renderChart(labels, series) {
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
            series: series,
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
                categories: labels,
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

        if (chart) {
            chart.destroy();
        }
        chart = new ApexCharts(document.querySelector("#dashboard-chart"), options);
        chart.render();
    }

    // Initial render
    var initialData = @json($chartData);
    if (initialData.labels.length > 0) {
        renderChart(initialData.labels, initialData.series);
    }

    // Filter Logic
    $('.chart-filter').click(function() {
        $('.chart-filter').removeClass('active btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('active btn-primary');
        $('#btn-pick-month').removeClass('active btn-primary').addClass('btn-outline-primary');
        $('#month-picker').addClass('d-none');

        var filter = $(this).data('filter');
        fetchChartData(filter);
    });

    $('#btn-pick-month').click(function() {
        $('.chart-filter').removeClass('active btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('active btn-primary');
        $('#month-picker').removeClass('d-none').focus();
    });

    $('#month-picker').change(function() {
        var month = $(this).val();
        if(month) {
            fetchChartData('pick_month', month);
        }
    });

    function fetchChartData(filter, month = null) {
        $.ajax({
            url: "{{ route('dashboard.chart-data') }}",
            type: "GET",
            data: {
                filter: filter,
                month: month
            },
            beforeSend: function() {
                // Show skeleton
                $('#dashboard-chart').html('<div class="skeleton-chart skeleton"></div>');
            },
            success: function(response) {
                $('#dashboard-chart').empty();
                renderChart(response.labels, response.series);
            },
            error: function(xhr) {
                console.error("Failed to fetch chart data", xhr);
                alert("Gagal memuat data chart. Silakan coba lagi.");
            }
        });
    }

    // --- Top 5 Packages Filter Logic ---
    $('.top-5-filter').click(function() {
        $('.top-5-filter').removeClass('active btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('active btn-primary');
        $('#btn-pick-month-top5').removeClass('active btn-primary').addClass('btn-outline-primary');
        $('#month-picker-top5').addClass('d-none');

        var filter = $(this).data('filter');
        fetchTopPackages(filter);
    });

    $('#btn-pick-month-top5').click(function() {
        $('.top-5-filter').removeClass('active btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('active btn-primary');
        $('#month-picker-top5').removeClass('d-none').focus();
    });

    $('#month-picker-top5').change(function() {
        var month = $(this).val();
        if(month) {
            fetchTopPackages('pick_month', month);
        }
    });

    function fetchTopPackages(filter, month = null) {
        $.ajax({
            url: "{{ route('dashboard.top-packages') }}",
            type: "GET",
            data: {
                filter: filter,
                month: month
            },
            beforeSend: function() {
                $('#top-5-list').addClass('d-none');
                $('#top-5-skeleton').removeClass('d-none');
            },
            success: function(response) {
                $('#top-5-skeleton').addClass('d-none');
                $('#top-5-list').removeClass('d-none');
                $('#top-5-label').text(response.label);
                
                var html = '';
                if(response.data.length > 0) {
                    $.each(response.data, function(index, paket) {
                        html += `
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="{{ asset('admin/assets/img/products/product-1.png') }}" alt="product">
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small">${paket.total_sales} Sales</div>
                                </div>
                                <div class="media-title">${paket.nama_paket}</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-primary" data-width="${paket.revenue_percentage}%"></div>
                                        <div class="budget-price-label">Rp ${paket.formatted_revenue}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        `;
                    });
                } else {
                    html = `
                    <li class="media">
                        <div class="media-body text-center">
                            Belum ada data penjualan paket pada periode ini.
                        </div>
                    </li>
                    `;
                }
                $('#top-5-list').html(html);

                // Re-initialize progress bars width
                 setTimeout(function() {
                    $(".budget-price-square").each(function() {
                        var width = $(this).attr("data-width");
                        $(this).css("width", width);
                    });
                 }, 100);
            },
            error: function(xhr) {
                $('#top-5-list').removeClass('d-none');
                $('#top-5-skeleton').addClass('d-none');
                console.error("Failed to fetch top packages", xhr);
                alert("Gagal memuat data paket. Silakan coba lagi.");
            }
        });
    }

  });

</script>
<script>
  $(document).ready(function() {
        // niceScroll will automatically adapt to the flex height
        if ($("#recent-activities-scroll").length) {
            $("#recent-activities-scroll").css({ height: "100%" }).niceScroll();
        }

        if ($("#top-5-scroll").length) {
            $("#top-5-scroll").css({ height: "100%" }).getNiceScroll().resize();
        }
    });
</script>
@endsection
