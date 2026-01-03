      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{url('/')}}"> <img alt="image" src="/admin/assets/img/logorwh1.png" class="header-logo" /> <span
                class="logo-name"></span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <a href="{{ url('/') }}" class="nav-link"><i data-feather="home"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ request()->routeIs('log-activity.index') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('log-activity.index') }}"><i data-feather="sliders"></i><span>Log Activity</span></a>
            </li>
            <li class="{{ request()->routeIs('calendar.index') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('calendar.index') }}"><i data-feather="calendar"></i><span>Calendar</span></a>
            </li>
            {{-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Widgets</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="widget-chart.html">Chart Widgets</a></li>
                <li><a class="nav-link" href="widget-data.html">Data Widgets</a></li>
              </ul>
            </li> --}}
            {{-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Apps</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="chat.html">Chat</a></li>
                <li><a class="nav-link" href="portfolio.html">Portfolio</a></li>
                <li><a class="nav-link" href="blog.html">Blog</a></li>
                <li><a class="nav-link" href="calendar.html">Calendar</a></li>
              </ul>
            </li> --}}
            {{-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Email</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="email-inbox.html">Inbox</a></li>
                <li><a class="nav-link" href="email-compose.html">Compose</a></li>
                <li><a class="nav-link" href="email-read.html">read</a></li>
              </ul>
            </li> --}}
            <li class="menu-header">Operasional</li>
            <li class="dropdown {{ request()->routeIs('jadwal-keberangkatan.*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="calendar"></i><span>Jadwal Keberangkatan</span></a>
              <ul class="dropdown-menu">
                @foreach($jenisPakets as $jenis)
                  <li class="{{ request()->routeIs('jadwal-keberangkatan.index') && request('jenis_id') == $jenis->id ? 'active' : '' }}"><a class="nav-link" href="{{ route('jadwal-keberangkatan.index', ['jenis_id' => $jenis->id]) }}">{{ $jenis->nama_jenis }}</a></li>
                @endforeach
              </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="user-plus"></i><span>Pendaftaran</span></a>
              <ul class="dropdown-menu">
                @foreach($jenisPakets as $jenis)
                  <li class="{{ request()->routeIs('pendaftaran.index') && request('jenis_id') == $jenis->id ? 'active' : '' }}"><a class="nav-link" href="{{ route('pendaftaran.index', ['jenis_id' => $jenis->id]) }}">{{ $jenis->nama_jenis }}</a></li>
                @endforeach
                {{-- <li><a class="nav-link" href="modal.html">Modal</a></li>
                <li><a class="nav-link" href="sweet-alert.html">Sweet Alert</a></li>
                <li><a class="nav-link" href="toastr.html">Toastr</a></li>
                <li><a class="nav-link" href="empty-state.html">Empty State</a></li>
                <li><a class="nav-link" href="multiple-upload.html">Multiple Upload</a></li>
                <li><a class="nav-link" href="pricing.html">Pricing</a></li>
                <li><a class="nav-link" href="tabs.html">Tab</a></li> --}}
              </ul>
            </li>
            {{-- <li><a class="nav-link" href="blank.html"><i data-feather="file"></i><span>Blank Page</span></a></li> --}}
            <li class="menu-header">Manajemen Jamaah</li>
            <li class="dropdown {{ request()->routeIs('jemaah.*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>Jemaah</span></a>
              <ul class="dropdown-menu">
                @foreach($jenisPakets as $jenis)
                  <li class="{{ request()->routeIs('jemaah.index') && request('jenis_id') == $jenis->id ? 'active' : '' }}"><a class="nav-link" href="{{ route('jemaah.index', ['jenis_id' => $jenis->id]) }}">{{ $jenis->nama_jenis }}</a></li>
                @endforeach
              </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('dokumen-jemaah.*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="file-text"></i><span>Dokumen Jemaah</span></a>
              <ul class="dropdown-menu">
                @foreach($jenisPakets as $jenis)
                  <li class="{{ request()->routeIs('dokumen-jemaah.index') && request('jenis_id') == $jenis->id ? 'active' : '' }}"><a class="nav-link" href="{{ route('dokumen-jemaah.index', ['jenis_id' => $jenis->id]) }}">{{ $jenis->nama_jenis }}</a></li>
                @endforeach
                {{-- <li><a class="nav-link" href="datatables.html">Datatable</a></li>
                <li><a class="nav-link" href="export-table.html">Export Table</a></li>
                <li><a class="nav-link" href="editable-table.html">Editable Table</a></li> --}}
              </ul>
            </li>
            {{-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="pie-chart"></i><span>Charts</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="chart-amchart.html">amChart</a></li>
                <li><a class="nav-link" href="chart-apexchart.html">apexchart</a></li>
                <li><a class="nav-link" href="chart-echart.html">eChart</a></li>
                <li><a class="nav-link" href="chart-chartjs.html">Chartjs</a></li>
                <li><a class="nav-link" href="chart-sparkline.html">Sparkline</a></li>
                <li><a class="nav-link" href="chart-morris.html">Morris</a></li>
              </ul>
            </li> --}}
            {{-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="feather"></i><span>Icons</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="icon-font-awesome.html">Font Awesome</a></li>
                <li><a class="nav-link" href="icon-material.html">Material Design</a></li>
                <li><a class="nav-link" href="icon-ionicons.html">Ion Icons</a></li>
                <li><a class="nav-link" href="icon-feather.html">Feather Icons</a></li>
                <li><a class="nav-link" href="icon-weather-icon.html">Weather Icon</a></li>
              </ul>
            </li> --}}
            <li class="menu-header">Keuangan</li>
            <li class="dropdown {{ request()->routeIs('cicilan-jemaah.*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="dollar-sign"></i><span>Cicilan Jemaah</span></a>
              <ul class="dropdown-menu">
                @foreach($jenisPakets as $jenis)
                  <li class="{{ request()->routeIs('cicilan-jemaah.index') && request('jenis_id') == $jenis->id ? 'active' : '' }}"><a class="nav-link" href="{{ route('cicilan-jemaah.index', ['jenis_id' => $jenis->id]) }}">{{ $jenis->nama_jenis }}</a></li>
                @endforeach
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="bar-chart-2"></i><span>Laporan Keuangan</span></a>
              <ul class="dropdown-menu">
                <li><a href="carousel.html">Bootstrap Carousel.html</a></li>
                <li><a class="nav-link" href="owl-carousel.html">Owl Carousel</a></li>
              </ul>
            </li>
            
            <li class="menu-header">Konfigurasi Master Data</li>
            <li class="dropdown {{ request()->routeIs('paket.*') || request()->routeIs('jenis-paket.*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="package"></i><span>Paket</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('jenis-paket.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jenis-paket.index') }}">Jenis Paket</a></li>
                @foreach($jenisPakets as $jenis)
                  <li class="{{ request()->routeIs('paket.index') && request('jenis_id') == $jenis->id ? 'active' : '' }}"><a class="nav-link" href="{{ route('paket.index', ['jenis_id' => $jenis->id]) }}">{{ $jenis->nama_jenis }}</a></li>
                @endforeach
              </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('jenis-dokumen.*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="pie-chart"></i><span>Dokumen</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('jenis-dokumen.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jenis-dokumen.index') }}">Jenis Dokumen</a></li>
                {{-- <li><a class="nav-link" href="chart-apexchart.html">apexchart</a></li>
                <li><a class="nav-link" href="chart-echart.html">eChart</a></li>
                <li><a class="nav-link" href="chart-chartjs.html">Chartjs</a></li>
                <li><a class="nav-link" href="chart-sparkline.html">Sparkline</a></li>
                <li><a class="nav-link" href="chart-morris.html">Morris</a></li> --}}
              </ul>
            </li>
            {{-- <li><a class="nav-link" href="vector-map.html"><i data-feather="map-pin"></i><span>Vector
                  Map</span></a></li> --}}
            <li class="menu-header">Pages</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="user-check"></i><span>Auth</span></a>
              <ul class="dropdown-menu">
                <li><a href="auth-login.html">Login</a></li>
                <li><a href="auth-register.html">Register</a></li>
                <li><a href="auth-forgot-password.html">Forgot Password</a></li>
                <li><a href="auth-reset-password.html">Reset Password</a></li>
                <li><a href="subscribe.html">Subscribe</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="alert-triangle"></i><span>Errors</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="errors-503.html">503</a></li>
                <li><a class="nav-link" href="errors-403.html">403</a></li>
                <li><a class="nav-link" href="errors-404.html">404</a></li>
                <li><a class="nav-link" href="errors-500.html">500</a></li>
              </ul>
            </li>
            {{-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="anchor"></i><span>Other
                  Pages</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="create-post.html">Create Post</a></li>
                <li><a class="nav-link" href="posts.html">Posts</a></li>
                <li><a class="nav-link" href="profile.html">Profile</a></li>
                <li><a class="nav-link" href="contact.html">Contact</a></li>
                <li><a class="nav-link" href="invoice.html">Invoice</a></li>
              </ul>
            </li> --}}
            {{-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="chevrons-down"></i><span>Multilevel</span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Menu 1</a></li>
                <li class="dropdown">
                  <a href="#" class="has-dropdown">Menu 2</a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Child Menu 1</a></li>
                    <li class="dropdown">
                      <a href="#" class="has-dropdown">Child Menu 2</a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Child Menu 1</a></li>
                        <li><a href="#">Child Menu 2</a></li>
                      </ul>
                    </li>
                    <li><a href="#"> Child Menu 3</a></li>
                  </ul>
                </li>
              </ul>
            </li> --}}
          </ul>
        </aside>
      </div>