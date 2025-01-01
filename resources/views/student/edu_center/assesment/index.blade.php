@extends('layouts.dashboard')
@section('title', 'Assessment Page - Academic Assessment')
@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fc;">
    <!-- Title and Back Button -->
    <div class="row mb-4" style="border: 1px solid #ddd; border-radius: 8px; background-color: #fff;">
        <div class="col-6 p-3 d-flex align-items-center">
            <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary d-flex align-items-center" style="border-radius: 8px;">
                ← Back
            </a>
        </div>
        <div class="col-6 p-3 text-end">
            <h5 class="mb-0 fw-bold text-dark">Assessment Page - Academic Assessment</h5>
        </div>
    </div>

    <!-- Navigation Section with Timer -->
    <div class="row mb-4 align-items-center" style="border: 1px solid #ddd; border-radius: 8px; background-color: #fff;">
        <div class="col-lg-9 col-md-8 col-sm-12 p-3 d-flex justify-content-center align-items-center">
            <!-- Left Arrow -->
            <button class="btn btn-outline-primary rounded-circle me-2" style="width: 40px; height: 40px;">
                <i class="bi bi-chevron-left"></i>
            </button>

            <!-- Navigation Buttons -->
            <div class="d-flex flex-wrap justify-content-center gap-2">
                @for($i = 1; $i <= 17; $i++)
                    <button class="btn {{ $i == 11 ? 'btn-primary text-white' : 'btn-outline-primary' }} rounded-circle" style="width: 40px; height: 40px;">
                        {{ $i }}
                    </button>
                @endfor
            </div>

            <!-- Right Arrow -->
            <button class="btn btn-outline-primary rounded-circle ms-2" style="width: 40px; height: 40px;">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 p-3 text-center text-md-end">
            <span class="badge bg-danger p-2" style="font-size: 14px;">Remaining Time: 01:30:39</span>
        </div>
    </div>

    <!-- Question Section -->
    <div class="row mb-4" style="border: 1px solid #ddd; border-radius: 8px; background-color: #fff;">
        <div class="col-12 p-4">
            <h5 class="fw-bold text-dark">11. Sebuah Lingkaran memiliki nilai diameter 14cm. Tentukan luas dari lingkaran di bawah!</h5>
            <div class="text-center my-4">
                <div class="rounded-circle border border-primary d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                    <span class="fw-bold text-primary">14 cm</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Answer Section -->
    <div class="row mb-4" style="border: 1px solid #ddd; border-radius: 8px; background-color: #fff;">
        <div class="col-12 p-4">
            <div class="list-group">
                <label class="list-group-item d-flex align-items-center py-2">
                    <input type="radio" name="answer" class="form-check-input me-2"> A. 40cm<sup>2</sup>
                </label>
                <label class="list-group-item d-flex align-items-center py-2">
                    <input type="radio" name="answer" class="form-check-input me-2"> B. 45cm<sup>2</sup>
                </label>
                <label class="list-group-item d-flex align-items-center py-2">
                    <input type="radio" name="answer" class="form-check-input me-2"> C. 44cm<sup>2</sup>
                </label>
                <label class="list-group-item d-flex align-items-center py-2">
                    <input type="radio" name="answer" class="form-check-input me-2"> D. 88cm<sup>2</sup>
                </label>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row" style="border: 1px solid #ddd; border-radius: 8px; background-color: #fff;">
        <div class="col-6 p-3">
            <button class="btn btn-warning" style="border-radius: 8px;">Mark Question</button>
        </div>
        <div class="col-6 p-3 text-end">
            <button class="btn btn-outline-secondary me-2" style="border-radius: 8px;">← Previously</button>
            <button class="btn btn-primary" style="border-radius: 8px;">Next →</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fc;
    }
    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .list-group-item {
        border: none;
        border-bottom: 1px solid #dee2e6;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@endpush
