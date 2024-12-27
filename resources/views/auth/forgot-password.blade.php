@extends('layouts.forgotpassword.app')

@section('title', 'Forgot Password')

@section('content')
<div class="d-flex justify-content-center h-100 align-items-center">
    <div class="authincation-content style-2">
        <div class="row no-gutters">
            <div class="col-xl-12 tab-content">
                <div id="forgot-password" class="auth-form tab-pane fade show active form-validation">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="text-center mb-4">
                            <h3 class="text-center mb-2 text-black">Forgot Password</h3>
                            <span>Enter your email address to reset your password</span>
                        </div>
                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label mb-2 fs-13 label-color font-w500">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="hello@example.com" value="{{ old('email') }}" required>
                        </div>
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 text-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="mb-4 text-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <button class="btn btn-block btn-primary">Send Reset Link</button>
                    </form>
                    <div class="new-account mt-3 text-center">
                        <p class="font-w500">Remembered your password? <a class="text-primary" href="{{ route('login') }}">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
