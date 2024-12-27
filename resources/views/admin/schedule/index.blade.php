@extends('layouts.dashboard')
@section('title', 'My Schedule')
@section('content')
<div class="container-fluid">
    <div class="row mt-5">
        <!-- Sidebar for Selecting Schedule Type -->
        <div class="col-xl-3">
            <h5>Pilih Jenis Jadwal</h5>
            <div>
                <input type="radio" name="schedule_type" value="assessment" id="assessment"
                    data-target="#table-assessment" checked>
                <label for="assessment">Jadwal Assessment</label>
            </div>
            <div>
                <input type="radio" name="schedule_type" value="kbm" id="kbm" data-target="#table-kbm">
                <label for="kbm">Jadwal KBM</label>
            </div>
            <div>
                <input type="radio" name="schedule_type" value="coaching" id="coaching" data-target="#table-coaching">
                <label for="coaching">Jadwal Coaching</label>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-xl-9">
            <!-- Table for Assessment -->
            <div id="table-assessment" class="schedule-table">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">+ Add
                        Data</button>
                </div>
                <h5>Jadwal Assessment</h5>
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-student">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Waktu</th>
                                <th>Mapel</th>
                                <th>Materi</th>
                                <th>Keterangan</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessments as $index => $assessment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $assessment->student->full_name }}</td>
                                    <td>{{ $assessment->date }}</td>
                                    <td>{{ $assessment->location }}</td>
                                    <td>{{ $assessment->time }}</td>
                                    <td>{{ $assessment->subject }}</td>
                                    <td>{{ $assessment->material }}</td>
                                    <td>{{ $assessment->notes ?? '-' }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-warning btn-sm edit-schedule" data-id="{{ $assessment->id }}"
                                            data-student="{{ $assessment->student_id }}" data-date="{{ $assessment->date }}"
                                            data-time="{{ $assessment->time }}" data-location="{{ $assessment->location }}"
                                            data-subject="{{ $assessment->subject }}"
                                            data-material="{{ $assessment->material }}"
                                            data-notes="{{ $assessment->notes }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-schedule"
                                            data-id="{{ $assessment->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- List Siswa for KBM -->
            <div id="table-kbm" class="schedule-table d-none">
                <h5 class="mb-3">Pilih Siswa</h5>
                <div class="row">
                    @foreach ($students as $student)
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-graduate fa-4x text-primary mb-3"></i>
                                    <h6>{{ $student->full_name }}</h6>
                                    <button class="btn btn-link btn-sm p-0 text-decoration-none select-student"
                                        data-id="{{ $student->id }}">
                                        <small>Lihat Jadwal</small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Table for KBM --}}
            <div id="table-kbm-schedule" class="schedule-table d-none">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModalKbm">+ Add Data Jadwal</button>
                </div>
                <h5>Jadwal KBM</h5>
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-kbm">
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
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="kbm-schedule-body">
                            <!-- Data dari jadwal KBM akan diisi secara dinamis -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal add Kbm --}}
<div class="modal fade" id="addScheduleModalKbm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.kbm.schedule.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal KBM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="selected_student_id">

                    <div class="mb-3">
                        <label for="selected_student_name" class="form-label">Nama Siswa</label>
                        <input type="text" id="selected_student_name" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="program_id" class="form-label">Program</label>
                        <select name="program_id" id="program_id"
                            class="form-control @error('program_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                        @error('program_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date Selection -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" name="date" id="date"
                            class="form-control @error('date') is-invalid @enderror" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_time" class="form-label">Jam Mulai</label>
                        <input type="time" name="start_time" id="start_time"
                            value="{{ old('start_time') }}" class="form-control @error('start_time') is-invalid @enderror" required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_time" class="form-label">Jam Selesai</label>
                        <input type="time" name="end_time" id="end_time"
                            value="{{ old('end_time') }}" class="form-control @error('end_time') is-invalid @enderror" required>
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div class="mb-3">
                        <label for="subject" class="form-label">Mata Pelajaran</label>
                        <input type="text" name="subject" id="subject"
                            class="form-control @error('subject') is-invalid @enderror" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" name="location" id="location"
                            class="form-control @error('location') is-invalid @enderror" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teacher Selection -->
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Guru</label>
                        <select name="teacher_id" id="teacher_id"
                            class="form-control @error('teacher_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Guru</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teacher Fee -->
                    <div class="mb-3">
                        <label for="fee" class="form-label">Fee Guru</label>
                        <input type="number" name="fee" id="fee" class="form-control @error('fee') is-invalid @enderror"
                            placeholder="Masukkan Fee Guru" required>
                        @error('fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal Add Schedule -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
    <input type="hidden" name="student_id" id="selected_student_id">
    <div class="modal-dialog">
        <form action="{{ route('admin.schedule.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Schedule</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Nama Siswa</label>
                        <select name="student_id" id="student_id" class="form-control">
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="datetime" class="form-label">Tanggal dan Waktu</label>
                        <input type="datetime-local" name="datetime" id="datetime" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" name="location" id="location" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Mapel</label>
                        <input type="text" name="subject" id="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="material" class="form-label">Materi</label>
                        <input type="text" name="material" id="material" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Keterangan</label>
                        <textarea name="notes" id="notes" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Schedule -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Schedule</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editScheduleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_student_id" class="form-label">Nama Siswa</label>
                        <select name="student_id" id="edit_student_id" class="form-control">
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_datetime" class="form-label">Tanggal dan Waktu</label>
                        <input type="datetime-local" name="datetime" id="edit_datetime" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_location" class="form-label">Lokasi</label>
                        <input type="text" name="location" id="edit_location" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_subject" class="form-label">Mapel</label>
                        <input type="text" name="subject" id="edit_subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_material" class="form-label">Materi</label>
                        <input type="text" name="material" id="edit_material" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_notes" class="form-label">Keterangan</label>
                        <textarea name="notes" id="edit_notes" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radios = document.querySelectorAll('input[name="schedule_type"]');
            const tables = document.querySelectorAll('.schedule-table');
            const studentCards = document.querySelectorAll('.select-student');
            const kbmBody = document.getElementById('kbm-schedule-body');
            const modalKbm = new bootstrap.Modal(document.getElementById('addScheduleModalKbm'));
            const studentNameInput = document.getElementById('selected_student_name');
            const studentIdInput = document.getElementById('selected_student_id');
            const formKbm = document.querySelector('#addScheduleModalKbm form');
            const backButton = document.getElementById('back-to-student-list');
            const editButtons = document.querySelectorAll('.edit-schedule');
            const editForm = document.getElementById('editScheduleForm');
            const editModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));

            const updateVisibleTable = () => {
                tables.forEach(table => table.classList.add('d-none'));
                const activeRadio = document.querySelector('input[name="schedule_type"]:checked');
                if (activeRadio) {
                    const target = activeRadio.dataset.target;
                    const targetElement = document.querySelector(target);
                    if (targetElement) {
                        targetElement.classList.remove('d-none');
                    } else {
                        console.error('Target table not found:', target);
                    }
                } else {
                    console.error('No active radio button found!');
                }
            };

            // Change visible table based on radio button
            radios.forEach(radio => {
                radio.addEventListener('change', updateVisibleTable);
            });

            // Function to fetch KBM schedule for selected student
            const fetchScheduleData = (studentId) => {
                fetch(`/admin/kbm/schedule/${studentId}/data`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch KBM schedule data');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('kbm-schedule-body').dispatchEvent(new Event('data-changed'));
                        kbmBody.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach((kbm, index) => {
                                const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${kbm.student.full_name}</td>
                                        <td>${kbm.date}</td>
                                        <td>${kbm.time || '-'}</td>
                                        <td>${kbm.subject}</td>
                                        <td>${kbm.location}</td>
                                        <td>${kbm.teacher ? kbm.teacher.full_name : '-'}</td>
                                        <td>${kbm.fee ? 'Rp ' + parseFloat(kbm.fee).toLocaleString('id-ID') : '-'}</td>
                                        <td class="text-end">
                                            <button class="btn btn-warning btn-sm edit-schedule" data-id="${kbm.id}">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-schedule" data-id="${kbm.id}">Delete</button>
                                        </td>
                                    </tr>`;
                                kbmBody.insertAdjacentHTML('beforeend', row);
                            });
                        } else {
                            kbmBody.innerHTML = '<tr><td colspan="9" class="text-center">Tidak ada jadwal tersedia</td></tr>';
                        }
                        document.getElementById('table-kbm-schedule').classList.remove('d-none');
                        document.getElementById('table-kbm').classList.add('d-none');
                    })
                    .catch(err => console.error('Error fetching KBM schedule:', err));
            };

            // Handle student card click to fetch KBM schedule and set student data in modal
            studentCards.forEach(card => {
                card.addEventListener('click', () => {
                    const studentId = card.dataset.id;
                    const studentName = card.closest('.card-body').querySelector('h6').textContent.trim();

                    studentIdInput.value = studentId;
                    studentNameInput.value = studentName;

                    fetchScheduleData(studentId);
                });
            });

            // Handle back button to return to student list
            backButton.addEventListener('click', () => {
                document.getElementById('table-kbm-schedule').classList.add('d-none');
                document.getElementById('table-kbm').classList.remove('d-none');
            });

            // Handle form submission for KBM schedule
            formKbm.addEventListener('submit', (event) => {
                event.preventDefault();

                const formData = new FormData(formKbm);
                fetch(formKbm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .catch(error => {
                        if (error.errors) {
                            Swal.fire({
                                title: 'Validation Error',
                                html: Object.values(error.errors).map(err => `<p>${err}</p>`).join(''),
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: error.message || 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    });
            });

            // Populate edit modal with data
            const populateEditModal = (event) => {
                const button = event.target;
                const id = button.dataset.id;
                const studentId = button.dataset.student;
                const date = button.dataset.date;
                const time = button.dataset.time;
                const location = button.dataset.location;
                const subject = button.dataset.subject;
                const material = button.dataset.material;
                const notes = button.dataset.notes;

                editForm.action = `/admin/assessment/${id}`;

                // Update form fields
                const studentSelect = document.getElementById('edit_student_id');
                if (studentSelect) {
                    Array.from(studentSelect.options).forEach(option => {
                        option.selected = option.value == studentId;
                    });
                }
                document.getElementById('edit_datetime').value = `${date}T${time}`;
                document.getElementById('edit_location').value = location;
                document.getElementById('edit_subject').value = subject;
                document.getElementById('edit_material').value = material;
                document.getElementById('edit_notes').value = notes;

                editModal.show();
            };

            // Attach click event to edit buttons
            editButtons.forEach(button => {
                button.addEventListener('click', populateEditModal);
            });

            // Handle update form submission
            editForm.addEventListener('submit', (event) => {
                event.preventDefault();

                const formData = new FormData(editForm);

                fetch(editForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'An error occurred');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            editModal.hide();
                            location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: error.message || 'Failed to update schedule. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    });
            });

            // Initialize visible table
            updateVisibleTable();
        });
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButtons = document.querySelectorAll('.delete-schedule');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const scheduleId = button.dataset.id;

                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you really want to delete this schedule? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, keep it',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/schedule/${scheduleId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                },
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Failed to delete schedule. Please try again.');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: data.message || 'The schedule has been deleted.',
                                            icon: 'success',
                                            confirmButtonText: 'OK',
                                        }).then(() => {
                                            location.reload(); 
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: data.message || 'Failed to delete the schedule.',
                                            icon: 'error',
                                            confirmButtonText: 'OK',
                                        });
                                    }
                                })
                                .catch(error => {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: error.message || 'An error occurred while deleting the schedule.',
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                    });
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush