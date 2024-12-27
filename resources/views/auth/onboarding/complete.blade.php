@extends('layouts.master')
@section('content')
<style>
    .completion-wrapper {
        text-align: center;
        padding: 100px 20px;
    }

    .completion-icon {
        font-size: 60px;
        color: #4caf50;
        margin-bottom: 20px;
    }

    .completion-message {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333333;
    }

    .completion-button {
        background-color: #007bff;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .completion-button:hover {
        background-color: #0056b3;
    }
</style>

<div class="container mt-5">
    <div class="completion-wrapper">
        <div class="completion-icon">✔</div>
        <div class="completion-message">Nice to have you, {{ Auth::user()->full_name }} 🙌</div>
        <form action="{{ route('onboarding.complete') }}" method="POST">
            @csrf
            <button type="submit" class="completion-button">Finish Onboarding</button>
        </form>
    </div>
</div>
@endsection
