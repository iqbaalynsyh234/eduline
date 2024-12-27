@extends('layouts.master')
@section('content')
<style>
    .form-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .progress-container {
        margin-bottom: 30px;
    }

    .progress {
        height: 8px;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        height: 8px;
    }

    h3 {
        font-weight: 700;
        margin-bottom: 30px;
        color: #333333;
    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
        color: #555555;
    }

    .form-control {
        height: 45px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 5px;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .row > div {
        padding: 10px;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
</style>

<div class="container mt-5">
    <div class="form-wrapper">
        <!-- Progress Bar -->
        <div class="progress-container text-center">
            <div class="progress w-100">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>

        <h3 class="text-center">Parent Information ✨</h3>

        <form action="{{ route('onboarding.parent.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Father Information -->
                <div class="col-md-6">
                    <label for="father_name">Nama Ayah</label>
                    <input type="text" id="father_name" name="father_name" class="form-control" placeholder="Masukkan nama ayah" required>
                </div>

                <div class="col-md-6">
                    <label for="father_job">Pekerjaan Ayah</label>
                    <input type="text" id="father_job" name="father_job" class="form-control" placeholder="Masukkan pekerjaan ayah" required>
                </div>

                <div class="col-md-6">
                    <label for="father_email">Email Ayah</label>
                    <input type="email" id="father_email" name="father_email" class="form-control" placeholder="Masukkan email ayah" required>
                </div>

                <div class="col-md-6">
                    <label for="father_phone">No Telepon Ayah</label>
                    <input type="text" id="father_phone" name="father_phone" class="form-control" placeholder="Masukkan no telepon ayah" required>
                </div>

                <!-- Mother Information -->
                <div class="col-md-6">
                    <label for="mother_name">Nama Bunda</label>
                    <input type="text" id="mother_name" name="mother_name" class="form-control" placeholder="Masukkan nama bunda" required>
                </div>

                <div class="col-md-6">
                    <label for="mother_job">Pekerjaan Bunda</label>
                    <input type="text" id="mother_job" name="mother_job" class="form-control" placeholder="Masukkan pekerjaan bunda" required>
                </div>

                <div class="col-md-6">
                    <label for="mother_email">Email Bunda</label>
                    <input type="email" id="mother_email" name="mother_email" class="form-control" placeholder="Masukkan email bunda" required>
                </div>

                <div class="col-md-6">
                    <label for="mother_phone">No Telepon Bunda</label>
                    <input type="text" id="mother_phone" name="mother_phone" class="form-control" placeholder="Masukkan no telepon bunda" required>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="button-group">
                <a href="{{ route('onboarding.details') }}" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-primary">Next →</button>
            </div>
        </form>
    </div>
</div>
@endsection
