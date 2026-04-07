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

    .info-box {
        background: linear-gradient(135deg, #fef5e7 0%, #fcf3cf 100%);
        border-left: 4px solid #f39c12;
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
        <h4 class="mb-1 fw-bold">Edit Kelas</h4>
        <p class="text-muted mb-0">Perbarui informasi kelas</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning-subtle border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3 bg-warning text-white rounded-circle" style="width:48px;height:48px;">
                            <i class="ti ti-edit fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Edit Informasi Kelas</h5>
                            <small class="text-muted">Perbarui data kelas sesuai kebutuhan</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.classes.update', $class->id) }}" method="POST" id="editClassForm">
                        @csrf
                        @method('PUT')

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
                                       value="{{ old('nama_kelas', $class->nama_kelas) }}">
                            </div>
                            @error('nama_kelas')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Last Updated -->
                        <div class="mb-4">
                            <small class="text-muted">
                                <i class="ti ti-clock me-1"></i>
                                Terakhir diupdate: {{ $class->updated_at->format('d M Y, H:i') }}
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('backend.classes.index') }}" class="btn btn-light">
                                <i class="ti ti-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="ti ti-device-floppy me-1"></i> Update
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-danger mt-3">
                <div class="card-header bg-danger-subtle">
                    <h6 class="mb-0 text-danger">
                        <i class="ti ti-alert-triangle me-1"></i> Zona Berbahaya
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-3 text-muted">
                        <small>Menghapus kelas akan menghapus semua data siswa yang terhubung dengan kelas ini. Tindakan ini tidak dapat dibatalkan.</small>
                    </p>
                    <form action="{{ route('backend.classes.destroy', $class) }}"
                          method="POST"
                          onsubmit="return confirm('⚠️ PERINGATAN!\n\nYakin ingin menghapus kelas {{ $class->nama_kelas }}?\n\nTindakan ini tidak dapat dikembalikan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i> Hapus Kelas Ini
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="ti ti-info-circle me-1"></i> Status Saat Ini
                    </h6>

                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Nama Kelas</small>
                        <span class="fw-semibold">{{ $class->nama_kelas }}</span>
                    </div>

                    <div>
                        <small class="text-muted d-block mb-1">Dibuat Pada</small>
                        <span class="fw-semibold">{{ $class->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3 bg-warning-subtle">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-bulb fs-4 text-warning me-2"></i>
                        <h6 class="mb-0 fw-bold text-warning">Tips</h6>
                    </div>
                    <small class="text-muted">
                        <ul class="ps-3 mb-0">
                            <li class="mb-2">Pastikan nama kelas tetap mudah dikenali</li>
                            <li class="mb-2">Perubahan nama akan langsung terlihat oleh siswa</li>
                            <li>Backup data penting sebelum menghapus</li>
                        </ul>
                    </small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection