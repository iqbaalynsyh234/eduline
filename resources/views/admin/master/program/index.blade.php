@extends('layouts.dashboard')
@section('title', 'Programs')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="page-title flex-wrap">
                <div class="input-group search-area mb-md-0 mb-3">
                    <input type="text" class="form-control" placeholder="Search here...">
                    <span class="input-group-text">
                        <a href="javascript:void(0)">
                            <i class="material-icons" id="seach-buttom">search</i>
                        </a>
                    </span>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProgramModal">
                        + New Program
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="table-responsive full-data">
                <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer" id="example-student">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Brand</th>
                            <th>Program</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($programs as $index => $program)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $program->brand->name ?? 'No Brand Assigned' }}</td>
                            <td>{{ $program->name }}</td>
                            <td>{{ $program->description }}</td>
                            <td class="text-end">
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProgramModal-{{ $program->id }}">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm delete-program" data-id="{{ $program->id }}" data-name="{{ $program->name }}">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Modal for Program -->
                        <div class="modal fade" id="editProgramModal-{{ $program->id }}" tabindex="-1" aria-labelledby="editProgramModalLabel-{{ $program->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.master-data.program.update', $program) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editProgramModalLabel-{{ $program->id }}">Edit Program</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="brand_id-{{ $program->id }}" class="form-label">Brand Name</label>
                                                <select name="brand_id" id="brand_id-{{ $program->id }}" class="form-control" required>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}" {{ $program->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-{{ $program->id }}" class="form-label">Program Name</label>
                                                <input type="text" name="name" id="name-{{ $program->id }}" class="form-control" value="{{ $program->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description-{{ $program->id }}" class="form-label">Description</label>
                                                <textarea name="description" id="description-{{ $program->id }}" class="form-control">{{ $program->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No Programs Available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating a Program -->
<div class="modal fade" id="createProgramModal" tabindex="-1" aria-labelledby="createProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master-data.program.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createProgramModalLabel">Create Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="brand_id" class="form-label">Brand Name</label>
                        <select name="brand_id" id="brand_id" class="form-control" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Program Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Program Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Program Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-program');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const programId = this.dataset.id;
                const programName = this.dataset.name;

                Swal.fire({
                    title: `Are you sure you want to delete ${programName}?`,
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/master-data/program/${programId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire(
                                'Deleted!',
                                data.success,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the program.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });
</script>
@endpush
