@extends('layouts.backend')

@section('styles')
<style>
    .icon-input {
        position: relative;
    }

    .icon-input i.input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 5;
    }

    .icon-input .form-control,
    .icon-input .form-select {
        padding-left: 45px;
    }

    .back-button:hover {
        transform: translateX(-3px);
        transition: transform 0.2s ease;
    }

    select[multiple] {
        min-height: 150px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="mb-4">
        <a href="{{ route('backend.siswa.index') }}" class="btn btn-light btn-sm back-button mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">Tambah Siswa</h4>
        <p class="text-muted mb-0">Lengkapi informasi siswa yang akan didaftarkan</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3 bg-primary-subtle text-primary rounded-circle" style="width:48px;height:48px;">
                            <i class="ti ti-user-plus fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Informasi Siswa</h5>
                            <small class="text-muted">Isi data siswa dengan lengkap</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.siswa.store') }}" method="POST" id="createSiswaForm">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-user me-1"></i>Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-user input-icon"></i>
                                <input type="text"
                                       name="name"
                                       class="form-control form-control-lg @error('name') is-invalid @enderror"
                                       placeholder="Masukkan nama lengkap siswa"
                                       required
                                       value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-mail me-1"></i>Email
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-mail input-icon"></i>
                                <input type="email"
                                       name="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       placeholder="contoh@email.com"
                                       required
                                       value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-lock me-1"></i>Password
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-lock input-icon"></i>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       placeholder="Minimal 8 karakter"
                                       required>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Kelas -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-door me-1"></i>Kelas
                                <span class="text-danger">*</span>
                            </label>
                            <select name="classes[]"
                                    class="form-select form-select-lg @error('classes') is-invalid @enderror"
                                    multiple
                                    required>
                                @foreach($classes as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ in_array($kelas->id, old('classes', [])) ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                <i class="ti ti-info-circle me-1"></i>
                                Tahan Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu kelas
                            </small>
                            @error('classes')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('backend.siswa.index') }}" class="btn btn-light">
                                <i class="ti ti-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Siswa
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-primary-subtle">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-info-circle fs-4 text-primary me-2"></i>
                        <h6 class="mb-0 fw-bold text-primary">Informasi</h6>
                    </div>
                    <small class="d-flex align-items-start mb-2">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Email digunakan untuk login ke sistem</span>
                    </small>
                    <small class="d-flex align-items-start mb-2">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Siswa bisa terdaftar di lebih dari satu kelas</span>
                    </small>
                    <small class="d-flex align-items-start">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Password bisa diubah oleh siswa setelah login</span>
                    </small>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-bulb fs-4 text-warning me-2"></i>
                        <h6 class="mb-0 fw-bold">Tips</h6>
                    </div>
                    <small class="text-muted">
                        <ul class="ps-3 mb-0">
                            <li class="mb-1">Gunakan email aktif siswa</li>
                            <li class="mb-1">Password awal sebaiknya diberitahukan langsung</li>
                            <li>Pastikan kelas yang dipilih sudah benar</li>
                        </ul>
                    </small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('input[name="name"]').focus();
    });
</script>
@endpush