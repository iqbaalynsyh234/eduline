@extends('layouts.dashboard')
@section('title', 'Edu Center')
@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4"><span>✨</span> Edu Center</h4>
    <div class="row">
        <!-- Assessment -->
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <img src="{{ asset('eduline/images/educenter/assessemnt-eduline.svg') }}" alt="Assessment" class="img-fluid mb-3" style="max-width: 100%;">
                    <h5 class="fw-bold text-dark">Assessment</h5>
                    <a href="#" class="text-primary">Explore →</a>
                </div>
            </div>
        </div>
        
        <!-- Drilling Soal -->
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <img src="{{ asset('eduline/images/educenter/drilling soal.svg') }}" alt="Drilling Soal" class="img-fluid mb-3" style="max-width: 100%;">
                    <h5 class="fw-bold text-dark">Drilling Soal</h5>
                    <a href="#" class="text-primary">Explore →</a>
                </div>
            </div>
        </div>

        <!-- E-Modul -->
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <img src="{{ asset('eduline/images/educenter/E-modul.svg') }}" alt="E-Modul" class="img-fluid mb-3" style="max-width: 100%;">
                    <h5 class="fw-bold text-dark">E-Modul</h5>
                    <a href="{{ route('student.edu_center.module', 'e-modul') }}" class="text-primary">Explore →</a>
                </div>
            </div>
        </div>

        <!-- Tryout -->
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <img src="{{ asset('eduline/images/educenter/Try-out.svg') }}" alt="Tryout" class="img-fluid mb-3" style="max-width: 100%;">
                    <h5 class="fw-bold text-dark">Tryout</h5>
                    <a href="#" class="text-primary">Explore →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
