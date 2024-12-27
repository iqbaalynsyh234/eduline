@extends('layouts.dashboard')
@section('title', 'My Profile')
@section('content')
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        font-weight: bold;
    }

    .nav-tabs .nav-link.active {
        border-bottom: 2px solid #ffc107;
        color: #ffc107;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #007bff;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        color: #fff;
        font-weight: bold;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    label {
        font-weight: bold;
        color: #555555;
    }

    .row > div {
        padding: 10px;
    }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4"><span>✨</span> My Profile</h4>
            <ul class="nav nav-tabs mb-4" id="profileTabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#myProfile" data-bs-toggle="tab">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#parentProfile" data-bs-toggle="tab">Parent Profile</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="myProfile">
                    <form action="{{ route('student.student.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">Nama Lengkap *</label>
                                <input type="text" name="full_name" class="form-control" id="full_name" value="{{ $student->full_name }}">
                            </div>

                            <!-- Religion -->
                            <div class="col-md-6">
                                <label for="religion" class="form-label">Agama *</label>
                                <select name="religion" id="religion" class="form-select">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ $student->religion == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ $student->religion == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ $student->religion == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ $student->religion == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ $student->religion == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ $student->email }}">
                            </div>

                           <!-- Address -->
                           <div class="col-md-6">
                                <label for="address" class="form-label">Alamat *</label>
                                <input type="text" name="address" class="form-control" id="address" value="{{ $studentAddress['detail'] ?? '' }}">
                            </div>
                            
                            <!-- Gender -->
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Jenis Kelamin *</label>
                                <select name="gender" id="gender" class="form-select">
                                    <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">No Telepon *</label>
                                <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ $student->phone_number }}">
                            </div>

                            <!-- Birth City -->
                            <div class="col-md-6">
                                <label for="birth_city" class="form-label">Kota Lahir *</label>
                                <input type="text" name="birth_city" class="form-control" id="birth_city" value="{{ $student->birth_city }}">
                            </div>

                            <!-- Birth Date -->
                            <div class="col-md-6">
                                <label for="birth_date" class="form-label">Tanggal Lahir *</label>
                                <input type="date" name="birth_date" class="form-control" id="birth_date" value="{{ $student->birth_date }}">
                            </div>

                            <!-- School Origin -->
                            <div class="col-md-6">
                                <label for="school_origin" class="form-label">Sekolah Asal *</label>
                                <input type="text" name="school_origin" class="form-control" id="school_origin" value="{{ $student->school_origin }}">
                            </div>

                            <!-- Class -->
                            <div class="col-md-6">
                                <label for="class" class="form-label">Kelas *</label>
                                <input type="text" name="class" class="form-control" id="class" value="{{ $student->class }}">
                            </div>

                            <!-- Instagram -->
                            <div class="col-md-6">
                                <label for="instagram" class="form-label">Akun Instagram *</label>
                                <input type="text" name="instagram" class="form-control" id="instagram" value="{{ $student->instagram }}">
                            </div>

                            <!-- Subject -->
                            <div class="col-md-6">
                                <label for="subject" class="form-label">Mata Pelajaran *</label>
                                <input type="text" name="subject" class="form-control" id="subject" value="{{ $student->subject }}">
                            </div>

                            <!-- Brand -->
                            <div class="col-md-6">
                                <label for="brand" class="form-label">Brand *</label>
                                <select name="brand_id" id="brand" class="form-select">
                                    <option value="">Pilih Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $studentBrandName == $brand->name ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hobby -->
                            <div class="col-md-6">
                                <label for="hobby" class="form-label">Hobby *</label>
                                <input type="text" name="hobby" class="form-control" id="hobby" value="{{ $student->hobby }}">
                            </div>

                            <!-- Photo -->
                            <div class="col-md-6">
                                <label for="photo" class="form-label">Foto *</label>
                                <input type="file" name="photo" class="form-control" id="photo">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning">Change</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="parentProfile">
                    <form action="{{ route('student.student.parent.profile.update') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <!-- Nama Ayah -->
                            <div class="col-md-6">
                                <label for="father_name" class="form-label">Nama Ayah *</label>
                                <input type="text" name="father_name" class="form-control" id="father_name" 
                                    value="{{ $student->father_name }}">
                            </div>

                            <!-- Pekerjaan Ayah -->
                            <div class="col-md-6">
                                <label for="father_job" class="form-label">Pekerjaan Ayah *</label>
                                <input type="text" name="father_job" class="form-control" id="father_job" 
                                    value="{{ $student->father_job }}">
                            </div>

                            <!-- Email Ayah -->
                            <div class="col-md-6">
                                <label for="father_email" class="form-label">Email Ayah *</label>
                                <input type="email" name="father_email" class="form-control" id="father_email" 
                                    value="{{ $student->father_email }}">
                            </div>

                            <!-- No Telepon Ayah -->
                            <div class="col-md-6">
                                <label for="father_phone" class="form-label">No Telepon Ayah *</label>
                                <input type="text" name="father_phone" class="form-control" id="father_phone" 
                                    value="{{ $student->father_phone }}">
                            </div>

                            <!-- Nama Ibu -->
                            <div class="col-md-6">
                                <label for="mother_name" class="form-label">Nama Ibu *</label>
                                <input type="text" name="mother_name" class="form-control" id="mother_name" 
                                    value="{{ $student->mother_name }}">
                            </div>

                            <!-- Pekerjaan Ibu -->
                            <div class="col-md-6">
                                <label for="mother_job" class="form-label">Pekerjaan Ibu *</label>
                                <input type="text" name="mother_job" class="form-control" id="mother_job" 
                                    value="{{ $student->mother_job }}">
                            </div>

                            <!-- Email Ibu -->
                            <div class="col-md-6">
                                <label for="mother_email" class="form-label">Email Ibu *</label>
                                <input type="email" name="mother_email" class="form-control" id="mother_email" 
                                    value="{{ $student->mother_email }}">
                            </div>

                            <!-- No Telepon Ibu -->
                            <div class="col-md-6">
                                <label for="mother_phone" class="form-label">No Telepon Ibu *</label>
                                <input type="text" name="mother_phone" class="form-control" id="mother_phone" 
                                    value="{{ $student->mother_phone }}">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning">Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
