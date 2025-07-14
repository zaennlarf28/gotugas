@extends('layouts.guru')

@section('content')
<div class="d-flex justify-content-center align-items-center mt-4">
    <div class="container px-4 px-md-5">
        <!-- Header Sambutan -->
        <div class="mb-5 text-center">
            <h2 class="fw-bold">Halo, {{ Auth::user()->name }} 👋</h2>
            <p class="text-muted mb-0">Selamat datang di Dashboard Guru GoTugas.</p>
        </div>

        <!-- Info Cards -->
        <div class="row g-4 justify-content-center text-center">
            <!-- Total Kelas -->
            <div class="col-xl-4 col-md-6">
                <div class="card h-100 bg-primary text-white shadow-sm rounded-4">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="fs-5">Total Kelas</div>
                        <div class="fs-3 fw-bold mt-2">{{ $totalKelas }}</div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center bg-opacity-10 bg-white rounded-bottom-4">
                        <a class="small text-white stretched-link" href="{{ route('guru.kelas.index') }}">Lihat Detail</a>
                        <i class="fas fa-angle-right small"></i>
                    </div>
                </div>
            </div>

            <!-- Total Tugas -->
            <div class="col-xl-4 col-md-6">
                <div class="card h-100 bg-warning text-white shadow-sm rounded-4">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="fs-5">Total Tugas</div>
                        <div class="fs-3 fw-bold mt-2">{{ $totalTugas }}</div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center bg-opacity-10 bg-white rounded-bottom-4">
                        <a class="small text-white stretched-link" href="{{ route('guru.tugas.index') }}">Lihat Detail</a>
                        <i class="fas fa-angle-right small"></i>
                    </div>
                </div>
            </div>

            <!-- Total Mapel -->
            <div class="col-xl-4 col-md-6">
                <div class="card h-100 bg-success text-white shadow-sm rounded-4">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="fs-5">Total Mata Pelajaran</div>
                        <div class="fs-3 fw-bold mt-2">{{ $totalMapel }}</div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center bg-opacity-10 bg-white rounded-bottom-4">
                        <a class="small text-white stretched-link" href="{{ route('guru.mapel.index') }}">Lihat Detail</a>
                        <i class="fas fa-angle-right small"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
