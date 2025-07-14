@extends('layouts.frontend') {{-- atau layouts.guru/siswa jika perlu --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-center mb-4">
                            <img src="{{ $user->foto_profil_url }}" alt="Foto Profil" class="rounded-circle shadow" width="130" height="130">
                            <div class="mt-2">
                                <input type="file" name="foto_profil" class="form-control form-control-sm w-75 mx-auto mt-2">
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center">
                            <i class="bi bi-person-fill me-3 text-secondary fs-5"></i> {{-- Abu-abu --}}
                            <div class="flex-grow-1">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center">
                            <i class="bi bi-house-door-fill me-3 text-primary fs-5"></i> {{-- Biru --}}
                            <div class="flex-grow-1">
                                <label class="form-label fw-semibold">Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user->alamat) }}">
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center">
                            <i class="bi bi-telephone-fill me-3 text-success fs-5"></i> {{-- Hijau --}}
                            <div class="flex-grow-1">
                                <label class="form-label fw-semibold">No Telepon</label>
                                <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}">
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success px-4 rounded-pill">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('profil') }}" class="btn btn-outline-secondary px-4 rounded-pill ms-2">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
