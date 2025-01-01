@extends('layouts.dashboard')
@section('title', 'Jadwal KBM Private')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 mb-3">
            <a href="{{ route('admin.schedule.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="col-xl-12">
            <div class="page-title flex-wrap">
                <div class="input-group search-area mb-md-0 mb-3">
                    <input type="text" class="form-control" placeholder="Search here...">
                    <span class="input-group-text">
                        <a href="javascript:void(0)">
                            <i class="material-icons" id="search-button">search</i>
                        </a>
                    </span>
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPrivateScheduleModal">
                        + Tambah Jadwal
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
                            <th>Nama Siswa</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Mapel</th>
                            <th>Lokasi</th>
                            <th>Nama Guru</th>
                            <th>Fee Guru</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kbmPrivateSchedules as $index => $schedule)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $schedule->student->full_name }}</td>
                            <td>{{ $schedule->date }}</td>
                            <td>{{ $schedule->start_time && $schedule->end_time ? $schedule->start_time . ' - ' . $schedule->end_time : '-' }}</td>
                            <td>{{ $schedule->subject }}</td>
                            <td>{{ $schedule->location }}</td>
                            <td>{{ $schedule->teacher->full_name ?? 'N/A' }}</td>
                            <td>{{ $schedule->fee ? 'Rp ' . number_format($schedule->fee, 0, ',', '.') : '-' }}</td>
                            <td class="text-end">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPrivateScheduleModal-{{ $schedule->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-schedule" data-id="{{ $schedule->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Jadwal KBM Private -->
                            <div class="modal fade" id="editPrivateScheduleModal-{{ $schedule->id }}" tabindex="-1" aria-labelledby="editPrivateScheduleModalLabel-{{ $schedule->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.admin.kbm.private.schedule.update', $schedule->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPrivateScheduleModalLabel-{{ $schedule->id }}">Edit Jadwal KBM Private</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="date-{{ $schedule->id }}" class="form-label">Tanggal</label>
                                                    <input type="date" name="date" id="date-{{ $schedule->id }}" class="form-control" value="{{ $schedule->date }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="start_time-{{ $schedule->id }}" class="form-label">Waktu Mulai</label>
                                                    <input type="time" name="start_time" id="start_time-{{ $schedule->id }}" class="form-control" value="{{ $schedule->start_time }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="end_time-{{ $schedule->id }}" class="form-label">Waktu Selesai</label>
                                                    <input type="time" name="end_time" id="end_time-{{ $schedule->id }}" class="form-control" value="{{ $schedule->end_time }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="subject-{{ $schedule->id }}" class="form-label">Mata Pelajaran</label>
                                                    <input type="text" name="subject" id="subject-{{ $schedule->id }}" class="form-control" value="{{ $schedule->subject }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="location-{{ $schedule->id }}" class="form-label">Lokasi</label>
                                                    <input type="text" name="location" id="location-{{ $schedule->id }}" class="form-control" value="{{ $schedule->location }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="teacher_id-{{ $schedule->id }}" class="form-label">Guru</label>
                                                    <select name="teacher_id" id="teacher_id-{{ $schedule->id }}" class="form-control" required>
                                                        @foreach ($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}" {{ $teacher->id == $schedule->teacher_id ? 'selected' : '' }}>
                                                                {{ $teacher->full_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fee-{{ $schedule->id }}" class="form-label">Fee Guru</label>
                                                    <input type="number" name="fee" id="fee-{{ $schedule->id }}" class="form-control" value="{{ $schedule->fee }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada jadwal</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal KBM Private -->
<div class="modal fade" id="addPrivateScheduleModal" tabindex="-1" aria-labelledby="addPrivateScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.admin.kbm.private.schedule.store') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPrivateScheduleModalLabel">Tambah Jadwal KBM Private</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Waktu Mulai</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">Waktu Selesai</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Mata Pelajaran</label>
                        <input type="text" name="subject" id="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" name="location" id="location" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Guru</label>
                        <select name="teacher_id" id="teacher_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Guru</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fee" class="form-label">Fee Guru</label>
                        <input type="number" name="fee" id="fee" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
        const deleteButtons = document.querySelectorAll('.delete-schedule');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const scheduleId = this.dataset.id;

                Swal.fire({
                    title: "Yakin ingin menghapus jadwal ini?",
                    text: "Tindakan ini tidak dapat diurungkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/kbm-private/schedule/${scheduleId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire('Terhapus!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'Gagal menghapus jadwal.', 'error');
                        });
                    }
                });
            });
        });
    });
</script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false,
    });
</script>
@endif
@endpush
