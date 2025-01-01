<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <title>@yield('title', 'Default Title')</title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('eduline/images/favicon.png') }}" />
    <link href="{{ asset('eduline/vendor/wow-master/css/libs/animate.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Plugins css start-->
    <link href="{{ asset('eduline/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('eduline/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
    <link href="{{ asset('eduline/vendor/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <link href="{{asset('eduline/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('eduline/vendor/swiper/css/swiper-bundle.min.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
    <link href="{{asset('eduline/css/style.css')}}" rel="stylesheet" />

</head>

<body class="body h-100">
    <div class="authincation d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="login-aside text-center d-flex flex-column flex-row-auto">
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <div class="text-center mb-lg-4 mb-2 pt-5 logo">
                    <img src="{{ asset('eduline/images/edulinePlatinum.png') }}" alt="Logo" style="width: 100%;">
                </div>
                <h3 class="mb-2 text-white">Welcome back!</h3>
            </div>
            <div class="aside-image position-relative"
                style="background-image:url({{ asset('eduline/images/background/edulinebg.svg') }});"></div>
        </div>

        <div
            class="container flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            @yield('content')
        </div>
    </div>
    <!--**** Scripts ***********-->
    <script src="{{asset('eduline/vendor/global/global.min.js')}}"></script>
    <script src="{{asset('eduline/vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Plugins JS start-->
     
    <!-- Chart piety plugin files -->
    <script src="{{ asset('eduline/vendor/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>

    <!-- Swiper slider -->
    <script src="{{ asset('eduline/vendor/swiper/js/swiper-bundle.min.js') }}"></script>

    <!-- Datatable -->
    <script src="{{ asset('eduline/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('eduline/js/plugins-init/datatables.init.js') }}"></script>

    <!-- Dashboard 1 -->
    <script src="{{ asset('eduline/js/dashboard/dashboard-1.js') }}"></script>

    <script src="{{ asset('eduline/vendor/wow-master/dist/wow.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
    <script src="{{ asset('eduline/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('eduline/vendor/bootstrap-select-country/js/bootstrap-select-country.min.js') }}"></script>

    <script src="{{asset('eduline/js/dlabnav-init.js')}}"></script>
    <script src="{{asset('eduline/js/custom.min.js')}}"></script>
    <script src="{{asset('eduline/js/demo.js')}}"></script>
    <!-- Plugins JS Ends-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('eduline/js/styleSwitcher.js') }}"></script>
</body>

</html>