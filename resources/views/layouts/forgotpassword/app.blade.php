<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>@yield('title', 'Default Title')</title>
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
                <div class="text-center mb-lg-4 mb-2 pt-5 logo">
                    <img src="{{ asset('eduline/images/edulinePlatinum.png') }}" alt="Logo" style="width: 100%;">
                </div>
                <h3 class="mb-2 text-white">Reset Password</h3>
            </div>
            <div class="aside-image position-relative" style="background-image:url({{ asset('eduline/images/background/Forgot-password-amico.svg') }});"></div>
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
