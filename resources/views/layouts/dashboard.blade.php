<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Title -->
    <title>@yield('title', 'Akademi Dashboard')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('eduline/images/favicon.png') }}" />

    <!-- CSS Files -->
    <link href="{{ asset('eduline/vendor/wow-master/css/libs/animate.css') }}" rel="stylesheet" />
    <link href="{{ asset('eduline/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('eduline/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('eduline/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
    <link href="{{ asset('eduline/vendor/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('eduline/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('eduline/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
    <link href="{{ asset('eduline/css/style.css') }}" rel="stylesheet" />

    @stack('css')
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
            <div class="dots">
                <div class="dot mainDot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div id="main-wrapper" class="wallet-open active">
        <!-- Nav Header -->
        @include('partials.nav-header')

        <!-- Header -->
        @include('partials.header')

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Content -->
        <div class="content-body">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        @include('partials.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('eduline/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/apexchart/apexchart.js') }}"></script>
    <script src="{{ asset('eduline/vendor/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/swiper/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('eduline/js/plugins-init/datatables.init.js') }}"></script>
    <script src="{{ asset('eduline/js/dashboard/dashboard-1.js') }}"></script>
    <script src="{{ asset('eduline/vendor/wow-master/dist/wow.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
    <script src="{{ asset('eduline/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/bootstrap-select-country/js/bootstrap-select-country.min.js') }}"></script>
    <script src="{{ asset('eduline/js/dlabnav-init.js') }}"></script>
    <script src="{{ asset('eduline/js/custom.min.js') }}"></script>
    <script src="{{ asset('eduline/js/demo.js') }}"></script>
    <script src="{{ asset('eduline/js/styleSwitcher.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
