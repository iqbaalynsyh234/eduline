@extends('layouts.master')
@section('title', 'Reset Password')
@section('content')
<div class="d-flex justify-content-center h-100 align-items-center">
    <div class="authincation-content style-2">
        <div class="row no-gutters">
            <div class="col-xl-12 tab-content">
                <div id="reset-password" class="auth-form tab-pane fade show active form-validation">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="text-center mb-4">
                            <h3 class="text-center mb-2 text-black">Reset Password</h3>
                            <span>Enter your new password below</span>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label mb-2 fs-13 label-color font-w500">Email address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                                placeholder="hello@example.com">
                            @if ($errors->has('email'))
                                <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label mb-2 fs-13 label-color font-w500">New Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter new password" required autocomplete="new-password">
                            @if ($errors->has('password'))
                                <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label mb-2 fs-13 label-color font-w500">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                placeholder="Confirm new password" required autocomplete="new-password">
                            @if ($errors->has('password_confirmation'))
                                <div class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>
                        
                        <button class="btn btn-block btn-primary">Reset Password</button>
                    </form>
                    <div class="new-account mt-3 text-center">
                        <p class="font-w500">Remembered your password? <a class="text-primary"
                                href="{{ route('login') }}">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('sweetalert'))
<script>
    Swal.fire({
        icon: "{{ session('sweetalert.type') }}", 
        title: "{{ session('sweetalert.title') }}", 
        text: "{{ session('sweetalert.text') }}", 
    });
</script>
@endif
@endsection
