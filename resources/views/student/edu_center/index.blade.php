@extends('layouts.dashboard')
@section('title', 'Edu Center')
@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4"><span>✨</span> Edu Center</h4>
    <div class="row">
        @foreach ($modules as $module)
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-4">
                            <img src="{{ asset($module->image) }}" alt="{{ $module->title }}" class="img-fluid" style="max-width: 150px;">
                        </div>
                        <div>
                            <h5 class="fw-bold">{{ $module->title }}</h5>
                            <p class="text-muted">{{ $module->description }}</p>
                            <a href="{{ route('student.edu_center.module', $module->slug) }}" class="text-primary">Explore →</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
