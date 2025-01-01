@extends('layouts.dashboard')
@section('title', 'My Schedule')
@section('content')
<div class="container-fluid">
    <div class="row mt-5">
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
                <input type="radio" name="schedule_type" value="kbm_private" id="kbmprivate" data-target="#table-kbmprivate">
                <label for="kbmprivate">Jadwal KBM Private</label>
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
                                        <small>Tambah jadwal KBM Kelas</small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigasi Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    @if ($students->hasPages())
                        <nav>
                            <ul class="pagination pagination-gutter">
                                {{-- Previous Page Link --}}
                                @if ($students->onFirstPage())
                                    <li class="page-item page-indicator disabled" aria-disabled="true">
                                        <span class="page-link"><i class="la la-angle-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item page-indicator">
                                        <a class="page-link" href="{{ $students->previousPageUrl() }}" rel="prev">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($students->links()->elements as $element)
                                    {{-- "Three Dots" Separator --}}
                                    @if (is_string($element))
                                        <li class="page-item disabled" aria-disabled="true">
                                            <span class="page-link">{{ $element }}</span>
                                        </li>
                                    @endif

                                    {{-- Array Of Links --}}
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $students->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($students->hasMorePages())
                                    <li class="page-item page-indicator">
                                        <a class="page-link" href="{{ $students->nextPageUrl() }}" rel="next">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item page-indicator disabled" aria-disabled="true">
                                        <span class="page-link"><i class="la la-angle-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>


            {{-- Table for KBM --}}
            <div id="table-kbm-schedule" class="schedule-table d-none">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModalKbm">+ Add Data Jadwal</button>
                </div>
                <!-- Tombol Back -->
                <button id="back-to-student-list" class="btn btn-secondary">Back</button>
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
            
            {{-- table schedule coaching--}}
            <div id="table-coaching" class="schedule-table">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoachingModal">+ Add
                        Data Schedule Coaching</button>
                </div>
                <h5>Jadwal Coaching</h5>
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-coaching">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Nama Guru</th>
                                <th>Metode Coaching</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coachings as $index => $coaching)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $coaching->student->full_name ?? 'N/A' }}</td>
                                    <td>{{ $coaching->date }}</td>
                                    <td>
                                        @if($coaching->start_time && $coaching->end_time)
                                            {{ \Carbon\Carbon::parse($coaching->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($coaching->end_time)->format('H:i') }}
                                        @else
                                            Not Specified
                                        @endif
                                    </td>
                                    <td>{{ $coaching->teacher->full_name ?? 'N/A' }}</td>
                                    <td>{{ $coaching->method }}</td>
                                    <td class="text-end">
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm edit-coaching"
                                            data-id="{{ $coaching->id }}"
                                            data-student="{{ $coaching->student_id }}"
                                            data-date="{{ $coaching->date }}"
                                            data-start-time="{{ $coaching->start_time }}"
                                            data-end-time="{{ $coaching->end_time }}"
                                            data-method="{{ $coaching->method }}">
                                            Edit
                                        </button>
                                        <!-- Delete Button -->
                                        <button class="btn btn-danger btn-sm delete-coaching" data-id="{{ $coaching->id }}">
                                                Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 

            {{-- table KBM Private--}}
            <div id="table-kbmprivate" class="schedule-table">
                <h5 class="mb-3">Pilih Siswa untuk Jadwal KBM Private</h5>
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-kbm-private">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->full_name }}</td>
                                    <td>
                                        <a href="{{ route('admin.admin.kbm.private.schedule', ['studentId' => $student->id]) }}" 
                                        class="btn btn-primary btn-sm">
                                            <i class="fas fa-calendar-alt"></i>Tambah Jadwal KBM Private
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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

{{-- Modal Edit Schedule KBM --}}
<div class="modal fade" id="editKbmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editKbmForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="editKbmId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jadwal KBM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editKbmStudentId" class="form-label">Nama Siswa</label>
                        <select name="student_id" id="editKbmStudentId" class="form-control" required>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editKbmDate" class="form-label">Tanggal</label>
                        <input type="date" name="date" id="editKbmDate" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKbmTime" class="form-label">Waktu</label>
                        <input type="time" name="time" id="editKbmTime" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKbmSubject" class="form-label">Mata Pelajaran</label>
                        <input type="text" name="subject" id="editKbmSubject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKbmLocation" class="form-label">Lokasi</label>
                        <input type="text" name="location" id="editKbmLocation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKbmTeacherId" class="form-label">Guru</label>
                        <select name="teacher_id" id="editKbmTeacherId" class="form-control" required>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editKbmFee" class="form-label">Fee Guru</label>
                        <input type="number" name="fee" id="editKbmFee" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal add coaching--}}
<div class="modal fade" id="addCoachingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createCoachingForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Coaching Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="studentId" class="form-label">Student</label>
                        <select name="student_id" id="studentId" class="form-control" required>
                            <option value="" disabled selected>Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="teacherId" class="form-label">Teacher</label>
                        <select name="teacher_id" id="teacherId" class="form-control" required>
                            <option value="" disabled selected>Select Teacher</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="method" class="form-label">Method</label>
                        <select name="method" id="method" class="form-control" required>
                            <option value="" disabled selected>Select Method</option>
                            <option value="home_visit">Home Visit</option>
                            <option value="office_visit">Office Visit</option>
                            <option value="online_zoom">Online Zoom</option>
                            <option value="phone_call">Phone Call</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- edit modal coaching--}}
<div class="modal fade" id="editCoachingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editCoachingForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="editCoachingId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Coaching Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editStudentId" class="form-label">Student</label>
                        <select name="student_id" id="editStudentId" class="form-control" required>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTeacherId" class="form-label">Teacher</label>
                        <select name="teacher_id" id="editTeacherId" class="form-control" required>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Date</label>
                        <input type="date" name="date" id="editDate" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_start_time" class="form-label">Start Time</label>
                        <input type="time" name="start_time" id="edit_start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_end_time" class="form-label">End Time</label>
                        <input type="time" name="end_time" id="edit_end_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMethod" class="form-label">Method</label>
                        <select name="method" id="editMethod" class="form-control" required>
                            <option value="home_visit">Home Visit</option>
                            <option value="office_visit">Office Visit</option>
                            <option value="online_zoom">Online Zoom</option>
                            <option value="phone_call">Phone Call</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
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
            const backButton = document.getElementById('back-to-student-list');
            const studentTable = document.getElementById('table-kbm');
            const kbmScheduleTable = document.getElementById('table-kbm-schedule');
            backButton.addEventListener('click', () => {
                console.log("aku di click");
                kbmScheduleTable.classList.add('d-none');
                studentTable.classList.remove('d-none');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const studentButtons = document.querySelectorAll('.select-student-private');
            const tableKbmPrivateSchedule = document.getElementById('table-kbmprivate-schedule');
            const tableKbmPrivate = document.getElementById('table-kbmprivate');
            const studentNameElement = document.getElementById('selected-student-name');
            const studentIdInput = document.getElementById('selected-student-id');

            studentButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const studentId = button.dataset.id;
                    const studentName = button.dataset.name;

                    // Update nama siswa di tabel
                    studentNameElement.textContent = studentName;
                    studentIdInput.value = studentId;

                    // Tampilkan tabel KBM Private dan sembunyikan daftar siswa
                    tableKbmPrivateSchedule.classList.remove('d-none');
                    tableKbmPrivate.classList.add('d-none');
                });
            });
        });


        document.addEventListener('DOMContentLoaded', () => {
            const studentButtons = document.querySelectorAll('.select-student-private');
            const tableKbmPrivateSchedule = document.getElementById('table-kbmprivate-schedule');
            const tableKbmPrivate = document.getElementById('table-kbmprivate');
            const studentNameElement = document.getElementById('selected-student-name');
            const studentIdInput = document.getElementById('selected-student-id');
            const kbmPrivateBody = document.getElementById('kbm-private-schedule-body');

            // Saat tombol "Tambah Jadwal KBM Private" diklik
            studentButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const studentId = button.dataset.id;
                    const studentName = button.dataset.name;

                    // Update nama siswa di tabel
                    studentNameElement.textContent = studentName;
                    studentIdInput.value = studentId;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const backButton = document.getElementById('back-to-student-list');
            const tableKbmPrivateSchedule = document.getElementById('table-kbmprivate-schedule');
            const tableKbmPrivate = document.getElementById('table-kbmprivate');

            backButton.addEventListener('click', () => {
                tableKbmPrivateSchedule.classList.add('d-none');
                tableKbmPrivate.classList.remove('d-none');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const kbmPrivateBody = document.getElementById('kbm-private-schedule-body');
            const addPrivateScheduleForm = document.getElementById('addPrivateScheduleForm');
            const addPrivateScheduleModal = new bootstrap.Modal(document.getElementById('addPrivateScheduleModal'));
            
            addPrivateScheduleForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const formData = new FormData(addPrivateScheduleForm);

                fetch('/admin/kbm-private/schedule', {
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
                                throw new Error(err.message || 'Validation error.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire('Success!', data.message, 'success').then(() => {
                            addPrivateScheduleModal.hide();
                            location.reload(); 
                        });
                    })
                    .catch(error => {
                        Swal.fire('Error!', error.message || 'Failed to add schedule.', 'error');
                    });
            });

            // Delete
            kbmPrivateBody.addEventListener('click', (e) => {
                if (e.target.classList.contains('delete-schedule')) {
                    const scheduleId = e.target.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                    }).then(result => {
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
                                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                                        location.reload();
                                    });
                                })
                                .catch(error => Swal.fire('Error!', 'Failed to delete the schedule.', 'error'));
                        }
                    });
                }
            });

            // Edit
            kbmPrivateBody.addEventListener('click', (e) => {
                if (e.target.classList.contains('edit-schedule')) {
                    const scheduleId = e.target.dataset.id;

                    fetch(`/admin/kbm-private/schedule/${scheduleId}/edit`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            const modal = new bootstrap.Modal(document.getElementById('editPrivateScheduleModal'));
                            document.getElementById('editPrivateScheduleId').value = data.id;
                            document.getElementById('editDate').value = data.date;
                            document.getElementById('editTime').value = data.time;
                            document.getElementById('editSubject').value = data.subject;
                            document.getElementById('editLocation').value = data.location;
                            document.getElementById('editTeacherId').value = data.teacher_id;
                            document.getElementById('editFee').value = data.fee;
                            modal.show();
                        })
                        .catch(error => Swal.fire('Error!', 'Failed to fetch schedule data.', 'error'));
                }
            });
        });

        // add coaching data
        document.addEventListener('DOMContentLoaded', () => {
            const createModal = new bootstrap.Modal(document.getElementById('addCoachingModal'));
            const editModal = new bootstrap.Modal(document.getElementById('editCoachingModal'));

            // Handle form submission for adding a coaching schedule
            document.getElementById('createCoachingForm').addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                console.log(formData);

                fetch(`/admin/coaching/store`, {
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
                            if (err.errors) throw err;
                            throw new Error('Unexpected error occurred');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire('Success', data.message, 'success').then(() => {
                        createModal.hide();
                        location.reload();
                    });
                })
                .catch(err => {
                    if (err.errors) {
                        Swal.fire({
                            title: 'Validation Error',
                            html: Object.values(err.errors).map(error => `<p>${error}</p>`).join(''),
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        Swal.fire('Error', err.message || 'Failed to add coaching schedule.', 'error');
                    }
                });
            });

           // edit modal data coaching
           document.querySelectorAll('.edit-coaching').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const studentId = button.dataset.student;
                    const date = button.dataset.date;
                    const startTime = button.dataset.startTime;
                    const endTime = button.dataset.endTime;
                    const method = button.dataset.method;

                    document.getElementById('editCoachingId').value = id;
                    document.getElementById('editStudentId').value = studentId;
                    document.getElementById('editDate').value = date;
                    document.getElementById('edit_start_time').value = startTime;
                    document.getElementById('edit_end_time').value = endTime;
                    document.getElementById('editMethod').value = method;

                    const editModal = new bootstrap.Modal(document.getElementById('editCoachingModal'));
                    editModal.show();
                });
            });

            // Handle form submission for editing a coaching schedule
            document.getElementById('editCoachingForm').addEventListener('submit', (e) => {
                e.preventDefault();

                const id = document.getElementById('editCoachingId').value;
                const formData = new FormData(e.target);

                fetch(`/admin/coaching/update/${id}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire('Success', data.message, 'success').then(() => {
                            location.reload();
                        });
                    })
                    .catch(err => {
                        Swal.fire('Error', err.message || 'Failed to update coaching schedule.', 'error');
                    });
            });


            // Handle delete action
            document.querySelectorAll('.delete-coaching').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                    }).then(result => {
                        if (result.isConfirmed) {
                            fetch(`/admin/coaching/delete/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                },
                            })
                                .then(response => response.json())
                                .then(data => {
                                    Swal.fire('Deleted', data.message, 'success').then(() => {
                                        location.reload();
                                    });
                                })
                                .catch(err => {
                                    Swal.fire('Error', err.message || 'Failed to delete coaching schedule.', 'error');
                                });
                        }
                    });
                });
            });
        });

        // edit kbm 
        document.querySelectorAll('.edit-schedule-kbm').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;

                fetch(`/admin/kbm/schedule/${id}/edit`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch schedule data');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('editKbmId').value = data.id || '';
                        document.getElementById('editKbmStudentId').value = data.student_id || '';
                        document.getElementById('editKbmDate').value = data.date || '';
                        document.getElementById('editKbmTime').value = data.start_time || '';
                        document.getElementById('editKbmSubject').value = data.subject || '';
                        document.getElementById('editKbmLocation').value = data.location || '';
                        document.getElementById('editKbmTeacherId').value = data.teacher_id || '';
                        document.getElementById('editKbmFee').value = data.fee || '';

                        const editKbmModal = new bootstrap.Modal(document.getElementById('editKbmModal'));
                        editKbmModal.show();
                    })
                    .catch(err => {
                        console.error('Error fetching KBM schedule:', err);
                        Swal.fire('Error', 'Failed to fetch schedule data.', 'error');
                    });
            });
        });

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
                // console.log(`Radio selected: ${radio.value}`);
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
                                        <td>${kbm.student }</td>
                                        <td>${kbm.date}</td>
                                        <td>${kbm.start_time && kbm.end_time ? `${kbm.start_time} - ${kbm.end_time}` : '-'}</td>
                                        <td>${kbm.subject}</td>
                                        <td>${kbm.location}</td>
                                        <td>${kbm.teacher}</td>
                                        <td>${kbm.fee ? 'Rp ' + parseFloat(kbm.fee).toLocaleString('id-ID') : '-'}</td>
                                        <td class="text-end">
                                            <button class="btn btn-warning btn-sm edit-schedule-kbm" 
                                                    data-id="${kbm.id}" 
                                                    data-student="${kbm.student_id}" 
                                                    data-date="${kbm.date}" 
                                                    data-start-time="${kbm.start_time}" 
                                                    data-end-time="${kbm.end_time}" 
                                                    data-location="${kbm.location}" 
                                                    data-subject="${kbm.subject}" 
                                                    data-teacher="${kbm.teacher_id}" 
                                                    data-fee="${kbm.fee}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-schedule" data-id="${kbm.id}">
                                                Delete
                                            </button>
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

            // // Handle back button to return to student list
            // backButton.addEventListener('click', () => {
            //     document.getElementById('table-kbm-schedule').classList.add('d-none');
            //     document.getElementById('table-kbm').classList.remove('d-none');
            // });

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

        // coaching 
        document.addEventListener('DOMContentLoaded', () => {
            const radios = document.querySelectorAll('input[name="schedule_type"]');
            const tables = document.querySelectorAll('.schedule-table');

            const updateVisibleTable = () => {
                tables.forEach(table => table.classList.add('d-none'));
                const activeRadio = document.querySelector('input[name="schedule_type"]:checked');
                if (activeRadio) {
                    const target = activeRadio.dataset.target;
                    const targetElement = document.querySelector(target);
                    if (targetElement) {
                        targetElement.classList.remove('d-none');
                    }
                }
            };

            // Change visible table based on radio button
            radios.forEach(radio => {
                radio.addEventListener('change', updateVisibleTable);
            });

            // Initialize visible table
            updateVisibleTable();
        });
    </script>
@endpush