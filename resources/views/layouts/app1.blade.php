<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title', 'Admin RWH') - RWH</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
  @yield('css')
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset(' admin/assets/img/gabut_logo.ico') }}' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <!-- Navbar -->
      @include('layouts.partials.navbar')
      <!-- Sidebar -->
      @include('layouts.partials.sidebar')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @yield('content')
        </section>
        @include('layouts.partials.settingsidebar')
      </div>
      @include('layouts.partials.footer')
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('admin/assets/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('admin/assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('admin/assets/js/page/index.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
  @yield('js')
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->

</html>