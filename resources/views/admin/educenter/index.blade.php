@extends('layouts.dashboard')
@section('title', 'EduCenter')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="page-title d-flex align-items-center justify-content-center">
                <i class="material-icons" style="font-size: 36px; color: #007bff; margin-right: 10px;">menu_book</i>
                <h4 class="text-center mb-0">EduCenter</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Card 1: E-Module -->
        <div class="col-md-4 col-sm-12 mb-4">
            <a href="{{ route('admin.educenter.e_module') }}" class="card shadow text-decoration-none">
                <div class="card-body text-center">
                    <img src="{{ asset('eduline/images/educenter/Elemen-Eduline.png') }}" alt="E-Module" class="mb-3" style="width: 100px;">
                    <h5 class="card-title">E-Module</h5>
                    <div class="mt-3">
                        <i class="material-icons" style="font-size: 36px; color: #007bff;">add</i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2: Paket Soal -->
        <div class="col-md-4 col-sm-12 mb-4">
            <a href="{{ route('admin.educenter.paket_module', parameters: '') }}" class="card shadow text-decoration-none">
                <div class="card-body text-center">
                    <img src="{{ asset('eduline/images/educenter/Elemen-Eduline.png') }}" alt="E-Module" class="mb-3" style="width: 100px;">
                    <h5 class="card-title">Paket Soal</h5>
                    <div class="mt-3">
                        <i class="material-icons" style="font-size: 36px; color: #007bff;">add</i>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Card 3: Assign Paket Soal -->
        <div class="col-md-4 col-sm-12 mb-4">
            <a href="{{ route('admin.educenter.assign_paket_module') }}" class="card shadow text-decoration-none">
                <div class="card-body text-center">
                    <img src="{{ asset('eduline/images/educenter/Elemen-Eduline.png') }}" alt="E-Module" class="mb-3" style="width: 100px;">
                    <h5 class="card-title">Assign Paket Soal</h5>
                    <div class="mt-3">
                        <i class="material-icons" style="font-size: 36px; color: #007bff;">add</i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
