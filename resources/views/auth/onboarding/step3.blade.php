@extends('layouts.master')
@section('content')
<style>
    .form-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .progress-container {
        margin-bottom: 30px;
    }

    .progress {
        height: 8px;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        height: 8px;
    }

    h3 {
        font-weight: 700;
        margin-bottom: 30px;
        color: #333333;
    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
        color: #555555;
    }

    .form-control {
        height: 45px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .row>div {
        padding: 10px;
    }
</style>

<div class="container mt-5">
    <div class="form-wrapper">
        <!-- Progress Bar -->
        <div class="progress-container text-center">
            <div class="progress w-100">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100">
                    Step 3
                </div>
            </div>
        </div>

        <h3 class="text-center">Complete Your Profile ✨</h3>

        <form action="{{ route('onboarding.details.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label for="full_name">Nama Lengkap</label>
                    <input type="text" id="full_name" name="full_name" class="form-control"
                        placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- Kota Lahir -->
                <div class="col-md-6">
                    <label for="birth_city">Kota Lahir</label>
                    <select id="birth_city" name="birth_city" class="form-control">
                        <option value="">Pilih Kota</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Bandung">Bandung</option>
                    </select>
                </div>

                <!-- Tanggal Lahir -->
                <div class="col-md-6">
                    <label for="birth_date">Tanggal Lahir</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control" required>
                </div>

                <!-- Agama -->
                <div class="col-md-6">
                    <label for="religion">Agama</label>
                    <select id="religion" name="religion" class="form-control">
                        <option value="">Pilih Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                    </select>
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-12">
                    <label>Jenis Kelamin</label>
                    <div>
                        <input type="radio" id="male" name="gender" value="male" required>
                        <label for="male">Laki-laki</label>
                        <input type="radio" id="female" name="gender" value="female" required>
                        <label for="female">Perempuan</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="province">Provinsi</label>
                    <select id="province" name="address[province]" class="form-control" required>
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id_prov }}">{{ $province->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="city">Kab/Kota</label>
                    <select id="city" name="address[city]" class="form-control selectpicker" required>
                        <option value="">Pilih Kota</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="district">Kecamatan</label>
                    <select id="district" name="address[district]" class="form-control selectpicker" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="subdistrict">Kelurahan</label>
                    <select id="subdistrict" name="address[subdistrict]" class="form-control selectpicker" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Kode Pos</label>
                    <input type="text" name="address[postal_code]" class="form-control" placeholder="Kode Pos" required>
                </div>
                <div class="col-md-12">
                    <label>Detail Alamat</label>
                    <textarea name="address[detail]" class="form-control" rows="3" placeholder="Detail Alamat"
                        required></textarea>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('onboarding.program') }}" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-primary">Next →</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('province').addEventListener('change', function () {
        const provinceId = this.value;
        const cityDropdown = document.getElementById('city');
        const districtDropdown = document.getElementById('district');
        const subdistrictDropdown = document.getElementById('subdistrict');

        cityDropdown.innerHTML = '<option value="">Memuat data kota...</option>';
        districtDropdown.innerHTML = '<option value="">Pilih Kecamatan</option>';
        subdistrictDropdown.innerHTML = '<option value="">Pilih Kelurahan</option>';

        if (provinceId) {
            fetch(`/get-cities/${provinceId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    let options = '<option value="">Pilih Kota</option>';
                    data.forEach(city => {
                        options += `<option value="${city.id_kab}">${city.nama}</option>`;
                    });
                    cityDropdown.innerHTML = options;

                    if ($(cityDropdown).hasClass('selectpicker')) {
                        $(cityDropdown).selectpicker('refresh');
                    }

                    cityDropdown.dispatchEvent(new Event('change'));
                })
                .catch(error => {
                    console.error("Error fetching cities:", error);
                });
        }
    });

    document.getElementById('city').addEventListener('change', function () {
        const cityId = this.value;
        const districtDropdown = document.getElementById('district');
        districtDropdown.innerHTML = '<option value="">Pilih Kecamatan</option>';

        if (cityId) {
            console.log("Fetching districts for city ID:", cityId);
            fetch(`/get-districts/${cityId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Districts fetched:", data);
                    let options = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(district => {
                        options += `<option value="${district.id_kec}">${district.nama}</option>`;
                    });
                    districtDropdown.innerHTML = options;

                    if ($(districtDropdown).hasClass('selectpicker')) {
                        $(districtDropdown).selectpicker('refresh');
                    }
                })
                .catch(error => {
                    console.error("Error fetching districts:", error);
                });
        }
    });

    document.getElementById('district').addEventListener('change', function () {
        const districtId = this.value;
        const subdistrictDropdown = document.getElementById('subdistrict');
        subdistrictDropdown.innerHTML = '<option value="">Pilih Kelurahan</option>'; 

        if (districtId) {
            console.log("Fetching subdistricts for district ID:", districtId);
            fetch(`/get-subdistricts/${districtId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Subdistricts fetched:", data);
                    let options = '<option value="">Pilih Kelurahan</option>';
                    data.forEach(subdistrict => {
                        options += `<option value="${subdistrict.id_kel}">${subdistrict.nama}</option>`;
                    });
                    subdistrictDropdown.innerHTML = options;

                    if ($(subdistrictDropdown).hasClass('selectpicker')) {
                        $(subdistrictDropdown).selectpicker('refresh');
                    }
                })
                .catch(error => {
                    console.error('Error fetching subdistricts:', error);
                });
        }
    });
</script>
@endsection