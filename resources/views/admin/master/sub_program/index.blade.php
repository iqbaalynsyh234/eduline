@extends('layouts.dashboard')
@section('title', 'Sub Programs')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="page-title flex-wrap">
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSubProgramModal">
                        + New Sub Program
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
                            <th>Sub Program Name</th>
                            <th>Program</th>
                            <th>Brand</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subPrograms as $index => $subProgram)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $subProgram->name }}</td>
                            <td>{{ $subProgram->program->name }}</td>
                            <td>{{ $subProgram->brand->name }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSubProgramModal-{{ $subProgram->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-sub-program" data-id="{{ $subProgram->id }}" data-name="{{ $subProgram->name }}">Delete</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editSubProgramModal-{{ $subProgram->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.master-data.sub-program.update', $subProgram) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Edit Sub Program</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" name="name" value="{{ $subProgram->name }}" class="form-control mb-3" required>
                                            <select name="program_id" class="form-control mb-3">
                                                @foreach ($programs as $program)
                                                <option value="{{ $program->id }}" {{ $subProgram->program_id == $program->id ? 'selected' : '' }}>
                                                    {{ $program->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <select name="brand_id" class="form-control">
                                                @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ $subProgram->brand_id == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createSubProgramModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.master-data.sub-program.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>New Sub Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-3" placeholder="Sub Program Name" required>
                    <select name="program_id" class="form-control mb-3">
                        <option value="">Select Program</option>
                        @foreach ($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                    <select name="brand_id" class="form-control">
                        <option value="">Select Brand</option>
                        @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-sub-program');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const subProgramId = this.dataset.id;
                const subProgramName = this.dataset.name;

                Swal.fire({
                    title: `Are you sure you want to delete "${subProgramName}"?`,
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/master-data/sub-program/${subProgramId}`, {
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
                                'There was a problem deleting the Sub Program.',
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
