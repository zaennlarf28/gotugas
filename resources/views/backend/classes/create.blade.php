@extends('layouts.backend')

@section('styles')
<style>
    .icon-input {
        position: relative;
    }

    .icon-input i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 5;
    }

    .icon-input .form-control {
        padding-left: 45px;
    }

    .back-button:hover {
        transform: translateX(-3px);
        transition: transform 0.2s ease;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="mb-4">
        <a href="{{ route('backend.classes.index') }}" class="btn btn-light btn-sm back-button mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">Tambah Kelas</h4>
        <p class="text-muted mb-0">Lengkapi informasi kelas yang akan ditambahkan</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3 bg-primary-subtle text-primary rounded-circle" style="width:48px;height:48px;">
                            <i class="ti ti-plus fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Informasi Kelas</h5>
                            <small class="text-muted">Isi data kelas dengan lengkap</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.classes.store') }}" method="POST" id="createClassForm">
                        @csrf

                        <!-- Nama Kelas -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-door me-1"></i>Nama Kelas
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-users"></i>
                                <input type="text"
                                       name="nama_kelas"
                                       class="form-control form-control-lg @error('nama_kelas') is-invalid @enderror"
                                       placeholder="Contoh: X-A, XI IPA 1, XII IPS 2"
                                       required
                                       value="{{ old('nama_kelas') }}">
                            </div>
                            @error('nama_kelas')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('backend.classes.index') }}" class="btn btn-light">
                                <i class="ti ti-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan
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
                        <span>Nama kelas akan digunakan untuk mengelompokkan siswa</span>
                    </small>
                    <small class="d-flex align-items-start mb-2">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Siswa dapat ditetapkan ke kelas saat pendaftaran</span>
                    </small>
                    <small class="d-flex align-items-start">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Kelas dapat memiliki lebih dari satu siswa</span>
                    </small>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-bulb fs-4 text-warning me-2"></i>
                        <h6 class="mb-0 fw-bold">Tips Penamaan</h6>
                    </div>
                    <small class="text-muted">
                        <ul class="ps-3 mb-0">
                            <li class="mb-1">Gunakan format yang konsisten</li>
                            <li class="mb-1">Sertakan tingkat dan jurusan jika perlu</li>
                            <li>Hindari nama yang terlalu panjang</li>
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
        document.querySelector('input[name="nama_kelas"]').focus();
    });
</script>
@endpush