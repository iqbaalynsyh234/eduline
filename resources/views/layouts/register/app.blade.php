<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>@yield('title', 'Register Account - Eduline')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="{{ asset('eduline/css/style.css') }}" rel="stylesheet">
</head>
<body class="body h-100">
    <div class="authincation d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="login-aside text-center d-flex flex-column flex-row-auto">
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <h3 class="mb-2 text-white">Register Your Account</h3>
            </div>
            <div class="aside-image position-relative" style="background-image:url({{ asset('eduline/images/background/Signup-amico.svg') }});"></div>
        </div>
        
        <div class="container flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            @yield('content')
        </div>
    </div>
  
    <script src="{{ asset('eduline/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('eduline/js/custom.min.js') }}"></script>
    <script src="{{ asset('eduline/js/dlabnav-init.js') }}"></script>
</body>
</html>
