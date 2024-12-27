@extends('layouts.dashboard')
@section('title', 'Brands')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="page-title flex-wrap">
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBrandModal">
                        + New Brand
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
                <table class="table-responsive-lg table display dataTablesCard dataTable no-footer" id="example-brand">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Brand</th>
                            <th>Logo</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $index => $brand)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="Brand Logo" class="img-thumbnail" width="50">
                            </td>
                            <td class="text-end">
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBrandModal-{{ $brand->id }}">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm delete-brand" data-id="{{ $brand->id }}" data-name="{{ $brand->name }}">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Modal for Brand -->
                        <div class="modal fade" id="editBrandModal-{{ $brand->id }}" tabindex="-1" aria-labelledby="editBrandModalLabel-{{ $brand->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.master-data.brand.update', $brand) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editBrandModalLabel-{{ $brand->id }}">Edit Brand</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name-{{ $brand->id }}" class="form-label">Brand Name</label>
                                                <input type="text" name="name" id="name-{{ $brand->id }}" class="form-control" value="{{ $brand->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="logo-{{ $brand->id }}" class="form-label">Logo</label>
                                                <input type="file" name="logo" id="logo-{{ $brand->id }}" class="form-control">
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
                            <td colspan="4" class="text-center">No Brands Available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating a Brand -->
<div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master-data.brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createBrandModalLabel">Create Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Brand Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control" required>
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
        const deleteButtons = document.querySelectorAll('.delete-brand');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const brandId = this.dataset.id;
                const brandName = this.dataset.name;

                Swal.fire({
                    title: `Are you sure you want to delete ${brandName}?`,
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/master-data/brand/${brandId}`, {
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
                                'There was a problem deleting the brand.',
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
