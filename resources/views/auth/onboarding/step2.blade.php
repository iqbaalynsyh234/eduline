@extends('layouts.master')
@section('content')
<style>
.card {
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    border: 2px solid transparent;
}

.card:hover {
    background-color: #f8f9fa;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transform: scale(1.03);
    border-color: #007bff;
}

input[type="radio"]:checked + label.card {
    background-color: #eaf4ff;
    border-color: #007bff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transform: scale(1.05);
}
</style>
<div class="container mt-5">
    <div class="d-flex justify-content-center mb-4">
        <div class="progress" style="width: 50%;">
            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                Step 2
            </div>
        </div>
    </div>

    <h3 class="text-center mb-4 font-weight-bold">Select Your Program ✨</h3>

    <form action="{{ route('onboarding.program.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            @foreach ($programs as $program)
                <div class="col-md-4 mb-3">
                    <input type="radio" id="program-{{ $program->id }}" name="program" value="{{ $program->id }}" hidden required>
                    <label for="program-{{ $program->id }}" class="card text-center p-4 border rounded-lg shadow-sm">
                        <div class="card-body">
                            <h5 class="font-weight-bold">{{ $program->name }}</h5>
                            <p class="text-muted">{{ $program->description }}</p>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">Next Step →</button>
        </div>
    </form>
</div>
@endsection