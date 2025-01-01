@extends('layouts.dashboard')
@section('title', 'Select Brand')
@section('content')
<style>
    .brand-card.selected {
        border-color: #28a745;
        background-color: #e8f5e9; 
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.5); 
    }

    /* Ensure non-selected cards look normal */
    .brand-card {
        transition: all 0.3s ease;
    }
</style>
<div class="container-fluid">
    <h4 class="text-center">Select Your Brand ✨</h4>
    <form action="{{ route('admin.educenter.save_selected_brand') }}" method="POST">
         @csrf
        <div class="row justify-content-center">
            @foreach ($brands as $brand)
                <div class="col-md-3 col-sm-6 mb-3">
                    <label for="brand-{{ $brand->id }}" 
                           class="card text-center p-3 shadow-sm cursor-pointer brand-card" 
                           style="border: 1px solid #007bff; border-radius: 10px;">
                        <input type="radio" name="brand_id" id="brand-{{ $brand->id }}" value="{{ $brand->id }}" hidden required>
                        <div class="card-body">
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="mb-3" style="width: 70px; height: 70px; object-fit: contain;">
                            <h5 class="mb-2">{{ $brand->name }}</h5>
                            <p class="text-muted small">{{ $brand->description }}</p>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4 py-2">Next Step →</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandCards = document.querySelectorAll('.brand-card');
        brandCards.forEach(card => {
            const input = card.querySelector('input[type="radio"]');
            // console.log(inpput);
            if (input.checked) {
                card.classList.add('selected');
            }

            card.addEventListener('click', function () {
                brandCards.forEach(c => c.classList.remove('selected'));

                // Add 'selected' class to the clicked card
                this.classList.add('selected');

                // Mark the radio input as checked
                input.checked = true;
            });
        });
    });
</script>
@endpush
