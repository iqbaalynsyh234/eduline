@extends('layouts.dashboard')
@section('title', 'Targets')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="page-title flex-wrap">
                <div class="input-group search-area mb-md-0 mb-3">
                    <input type="text" class="form-control" placeholder="Search targets...">
                    <span class="input-group-text">
                        <a href="javascript:void(0)">
                            <i class="material-icons" id="search-button">search</i>
                        </a>
                    </span>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTargetModal">
                        + New Target
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
                            <th>Student Name</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Icon</th>
                            <th>Schedule</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($targets as $index => $target)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $target->user->full_name ?? 'Unknown Student' }}</td>
                            <td>{{ $target->title }}</td>
                            <td>{{ $target->slug }}</td>
                            <td>{{ $target->description }}</td>
                            <td>
                                @if ($target->icon)
                                    <img src="{{ asset('storage/' . $target->icon) }}" alt="Icon" width="50">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $target->schedule }}</td>
                            <td>{{ $target->time }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTargetModal-{{ $target->id }}">
                                    Edit
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm delete-target" data-id="{{ $target->id }}" data-title="{{ $target->title }}">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Modal for Target -->
                        <div class="modal fade" id="editTargetModal-{{ $target->id }}" tabindex="-1" aria-labelledby="editTargetModalLabel-{{ $target->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.master-data.target.update', $target) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Target</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="user_id-{{ $target->id }}" class="form-label">Student</label>
                                                <select name="user_id" id="user_id-{{ $target->id }}" class="form-control">
                                                    @foreach($students as $student)
                                                        <option value="{{ $student->id }}" {{ $student->id == $target->user_id ? 'selected' : '' }}>
                                                            {{ $student->full_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="title-{{ $target->id }}" class="form-label">Title</label>
                                                <input type="text" name="title" id="title-{{ $target->id }}" class="form-control" value="{{ $target->title }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="slug-{{ $target->id }}" class="form-label">Slug</label>
                                                <input type="text" name="slug" id="slug-{{ $target->id }}" class="form-control" value="{{ $target->slug }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description-{{ $target->id }}" class="form-label">Description</label>
                                                <textarea name="description" id="description-{{ $target->id }}" class="form-control">{{ $target->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <img src="{{ Storage::url($target->icon) }}" alt="Icon" style="width: 20px; height: 20px;"> 
                                                <label for="icon-{{ $target->id }}" class="form-label">Icon</label>
                                                <input type="file" name="icon" id="icon-{{ $target->id }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="schedule-{{ $target->id }}" class="form-label">Schedule</label>
                                                <input type="date" name="schedule" id="schedule-{{ $target->id }}" class="form-control" value="{{ $target->schedule }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="time-{{ $target->id }}" class="form-label">Time</label>
                                                <input type="text" name="time" id="time-{{ $target->id }}" class="form-control" value="{{ $target->time }}">
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
                            <td colspan="9" class="text-center">No targets available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Target Modal -->
<div class="modal fade" id="createTargetModal" tabindex="-1" aria-labelledby="createTargetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master-data.target.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTargetModalLabel">Create Target</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Student</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="" disabled selected>Select a student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" required>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter Slug" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter Description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="schedule" class="form-label">Schedule</label>
                        <input type="date" name="schedule" id="schedule" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" name="time" id="time" class="form-control" placeholder="Enter Time">
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
        const deleteButtons = document.querySelectorAll('.delete-target');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.dataset.id;
                const targetTitle = this.dataset.title;

                Swal.fire({
                    title: `Are you sure you want to delete "${targetTitle}"?`,
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/master-data/target/${targetId}`, {
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
                                'There was a problem deleting the target.',
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
