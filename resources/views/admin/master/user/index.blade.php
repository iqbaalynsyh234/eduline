@extends('layouts.dashboard')
@section('title', 'User Management')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="page-title flex-wrap">
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createUserModal">
                        + Add New User
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->pluck('name')->first() }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status" type="checkbox"
                                            data-id="{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal-{{ $user->id }}">
                                        Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger btn-sm delete-user"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal for User -->
                            <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
                                aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.master-data.user.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Edit User
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name-{{ $user->id }}" class="form-label">full_name</label>
                                                    <input type="text" name="full_name" id="full_name-{{ $user->id }}"
                                                        class="form-control" value="{{ $user->full_name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email-{{ $user->id }}" class="form-label">Email</label>
                                                    <input type="email" name="email" id="email-{{ $user->id }}"
                                                        class="form-control" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="role-{{ $user->id }}" class="form-label">Role</label>
                                                    <select name="role" id="role-{{ $user->id }}" class="form-select">
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->name }}" {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                                                                {{ ucfirst($role->name) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Users Available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating a User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master-data.user.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Enter User Full Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
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
    const toggleStatus = document.querySelectorAll('.toggle-status');
    const deleteButtons = document.querySelectorAll('.delete-user');
    toggleStatus.forEach(toggle => {
        toggle.addEventListener('change', function () {
            const userId = this.dataset.id;
            const status = this.checked ? 1 : 0;

            fetch(`/admin/master-data/user/${userId}/toggle-status`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ is_active: status })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update user status.');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    title: 'Updated!',
                    text: data.message,
                    icon: 'success',
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to update user status.',
                    icon: 'error',
                });
            });
        });
    });
    
    // delete user 
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.dataset.id;
            const userName = this.dataset.name;

            Swal.fire({
                title: `Are you sure you want to delete ${userName}?`,
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/master-data/user/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to delete user.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.success,
                            icon: 'success',
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: error.message || 'Failed to delete user.',
                            icon: 'error',
                        });
                    });
                }
            });
        });
    });
});

</script>
@endpush