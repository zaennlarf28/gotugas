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

    .info-box {
        background: linear-gradient(135deg, #fef5e7 0%, #fcf3cf 100%);
        border-left: 4px solid #f39c12;
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
        <h4 class="mb-1 fw-bold">Edit Siswa</h4>
        <p class="text-muted mb-0">Perbarui informasi data siswa</p>
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
                            <h5 class="mb-0">Edit Informasi Siswa</h5>
                            <small class="text-muted">Perbarui data siswa sesuai kebutuhan</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.siswa.update', $siswa->id) }}" method="POST" id="editSiswaForm">
                        @csrf
                        @method('PUT')

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
                                       value="{{ old('name', $siswa->name) }}">
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
                                       value="{{ old('email', $siswa->email) }}">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password (opsional saat edit) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-lock me-1"></i>Password Baru
                                <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-lock input-icon"></i>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       placeholder="Kosongkan jika tidak ingin mengubah password">
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
                                        @selected($siswa->classes->contains($kelas->id))>
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

                        <!-- Last Updated -->
                        <div class="mb-4">
                            <small class="text-muted">
                                <i class="ti ti-clock me-1"></i>
                                Terakhir diupdate: {{ $siswa->updated_at->format('d M Y, H:i') }}
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('backend.siswa.index') }}" class="btn btn-light">
                                <i class="ti ti-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="ti ti-device-floppy me-1"></i> Update Siswa
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
                        <small>Menghapus akun siswa ini akan menghapus semua data terkait. Tindakan ini tidak dapat dibatalkan.</small>
                    </p>
                    <button type="button"
                            class="btn btn-danger"
                            onclick="confirmDelete('{{ route('backend.siswa.destroy', $siswa->id) }}', '{{ $siswa->name }}')">
                        <i class="ti ti-trash me-1"></i> Hapus Siswa Ini
                    </button>
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

                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-center me-2 bg-primary-subtle text-primary rounded-circle" style="width:40px;height:40px;">
                            <i class="ti ti-user"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Nama Siswa</small>
                            <span class="fw-semibold">{{ $siswa->name }}</span>
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Email</small>
                        <span class="fw-semibold">{{ $siswa->email }}</span>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Kelas Terdaftar</small>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @foreach($siswa->classes as $kelas)
                                <span class="badge bg-primary-subtle text-primary">{{ $kelas->nama_kelas }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <small class="text-muted d-block mb-1">Terdaftar Sejak</small>
                        <span class="fw-semibold">{{ $siswa->created_at->format('d M Y') }}</span>
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
                            <li class="mb-2">Kosongkan password jika tidak ingin mengubahnya</li>
                            <li class="mb-2">Email harus unik dan aktif</li>
                            <li>Pastikan kelas yang dipilih sudah benar</li>
                        </ul>
                    </small>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Hidden form for delete -->
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(url, nama) {
        Swal.fire({
            title: 'Hapus Siswa?',
            text: 'Yakin ingin menghapus siswa ' + nama + '? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                form.action = url;
                form.submit();
            }
        });
    }
</script>
@endpush