@extends('layouts.dashboard')
@section('title', $module->title)
@section('content')
<div class="container-fluid py-4">
    <a href="{{ route('student.edu_center.overview') }}" class="btn btn-secondary mb-3">
        ← Back
    </a>
    <h4 class="mb-4"><span>✨</span> {{ $module->title }}</h4>
    <div class="row">
        @foreach ($module->subModules as $subModule)
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $subModule->title }}</h5>
                        <p class="text-muted">{{ $subModule->description }}</p>
                        <a href="{{ $subModule->link }}" class="text-primary">View →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
