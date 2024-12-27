@extends('layouts.dashboard')
@section('title', 'My Targets')
@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4"><span>✨</span> My Target</h4>
    <div class="row">
        @foreach ($targets as $target)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar {{ $target->color ?? 'bg-primary' }} text-white rounded-circle me-3">
                                <span class="fw-bold">{{ $target->icon ?? strtoupper(substr($target->title, 0, 1)) }}</span>
                            </div>
                            <h5 class="mb-0">{{ $target->title }}</h5>
                        </div>
                        <p class="text-muted mb-2">{{ $target->description }}</p>
                        <p class="text-muted small mb-0">
                            <i class="material-symbols-outlined">
                              {{ $target->schedule }}
                            </i>
                        </p>
                        <p class="text-muted small">
                            <i class="material-symbols-outlined">
                                 {{ $target->time }}
                            </i>
                        </p>
                        <a href="{{ route('student.targets.details', $target->slug) }}" class="text-primary">View →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
