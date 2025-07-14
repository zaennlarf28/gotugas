@extends('layouts.frontend') {{-- ganti sesuai layout kamu --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
<div class="container mt-4">
    {{-- Tombol Kembali --}}
    <div class="mb-3">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left me-1"></i>
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <img src="{{ $user->foto_profil_url }}" alt="Foto Profil" class="rounded-circle shadow" width="130" height="130">
                        <h4 class="mt-3 mb-0">{{ $user->name }}</h4>
                        <span class="text-muted">{{ $user->email }}</span>
                        <div class="mt-2">
                            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'guru' ? 'success' : 'primary') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3 d-flex align-items-center">
                        <i class="bi bi-house-door-fill me-3 text-primary fs-5"></i>
                        <div>
                            <div class="fw-semibold">Alamat</div>
                            <div class="text-muted">{{ $user->alamat ?? 'Belum diisi' }}</div>
                        </div>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone-fill me-3 text-success fs-5"></i>
                        <div>
                            <div class="fw-semibold">No Telepon</div>
                            <div class="text-muted">{{ $user->no_telepon ?? 'Belum diisi' }}</div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('profil.edit') }}" class="btn btn-outline-success rounded-pill px-4">
                            <i class="bi bi-pencil-square me-1"></i> Edit Profil
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
