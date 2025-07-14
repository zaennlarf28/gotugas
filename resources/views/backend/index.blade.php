@extends('layouts.backend')

@section('content')
<div class="container-fluid mt-4">
    {{-- Selamat Datang --}}
    <div class="mb-4 p-4 rounded-4 bg-light border-start border-5 border-primary shadow-sm">
        <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name }} 👋</h3>
        <p class="mb-0 text-muted">Ini adalah dashboard admin. Kamu bisa mengelola data pengguna di sini.</p>
    </div>

    {{-- Statistik Kartu --}}
    <div class="row g-4">

        <!-- Total Akun -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-light position-relative overflow-hidden">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ asset('/assets/backend/images/svgs/icon-user-male.svg') }}" width="50" height="50" alt="User Icon" />
                    </div>
                    <p class="fw-semibold fs-5 text-primary mb-0">Total Akun</p>
                    <h4 class="fw-bold text-primary">{{ $jumlahUser }}</h4>
                    <span class="position-absolute top-0 start-0 badge bg-primary text-white rounded-end-pill px-3 py-1 mt-2 ms-2">User</span>
                </div>
            </div>
        </div>

        <!-- Jumlah Guru -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white position-relative overflow-hidden">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ asset('/assets/backend/images/svgs/icon-briefcase.svg') }}" width="50" height="50" alt="Guru Icon" />
                    </div>
                    <p class="fw-semibold fs-5 text-success mb-0">Guru</p>
                    <h4 class="fw-bold text-success">{{ $jumlahGuru }}</h4>
                    <span class="position-absolute top-0 start-0 badge bg-success text-white rounded-end-pill px-3 py-1 mt-2 ms-2">Guru</span>
                </div>
            </div>
        </div>

        <!-- Jumlah Siswa -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white position-relative overflow-hidden">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" width="50" height="50" alt="Siswa Icon" />
                    </div>
                    <p class="fw-semibold fs-5 text-info mb-0">Siswa</p>
                    <h4 class="fw-bold text-info">{{ $jumlahSiswa }}</h4>
                    <span class="position-absolute top-0 start-0 badge bg-info text-white rounded-end-pill px-3 py-1 mt-2 ms-2">Siswa</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
