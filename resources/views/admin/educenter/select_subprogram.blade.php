@extends('layouts.dashboard')
@section('title', 'Select Subprogram')
@section('content')
<style>
    .subprogram-card.selected {
        border-color: #28a745;
        background-color: #e8f5e9;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
    }

    .subprogram-card {
        transition: all 0.3s ease;
    }
</style>
<div class="container-fluid">
    <h4 class="text-center">Select a Subprogram</h4>
    <form action="{{ route('admin.educenter.educenter.save_selected_program') }}" method="POST">
        @csrf
        <input type="hidden" name="eModuleId" value="{{ $eModuleId }}">
        <div class="row justify-content-center">
            @foreach ($subprograms as $subprogram)
                <div class="col-md-3 col-sm-6 mb-3">
                    <label for="subprogram-{{ $subprogram->id }}" class="card text-center p-3 shadow-sm cursor-pointer subprogram-card {{ isset($selectedSubprogram) && $selectedSubprogram == $subprogram->id ? 'selected' : '' }}" style="border: 1px solid #007bff; border-radius: 10px;">
                        <input type="radio" name="subprogram_id" id="subprogram-{{ $subprogram->id }}" value="{{ $subprogram->id }}" hidden required {{ isset($selectedSubprogram) && $selectedSubprogram == $subprogram->id ? 'checked' : '' }}>
                        <div class="card-body">
                            <i class="fa-solid fa-user" style="font-size: 25px; color: {{ isset($selectedSubprogram) && $selectedSubprogram == $subprogram->id ? '#28a745' : '#007bff' }};"></i>
                            <h5 class="mb-2">{{ $subprogram->name }}</h5>
                            <p class="text-muted small">{{ $subprogram->description }}</p>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.educenter.select_brand') }}" class="btn btn-danger px-4 py-2">
                ← Back to Select Brand
            </a>
            <button type="submit" class="btn btn-primary px-4 py-2">
                Next Step →
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subprogramCards = document.querySelectorAll('.subprogram-card');
        subprogramCards.forEach(card => {
            const input = card.querySelector('input[type="radio"]');
            if (input.checked) {
                card.classList.add('selected');
            }

            // Add click event listener
            card.addEventListener('click', function () {
                subprogramCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');

                input.checked = true;
            });
        });
    });
</script>
@endpush
