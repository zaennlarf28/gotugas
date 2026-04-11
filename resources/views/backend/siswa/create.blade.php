@extends('layouts.backend')

@section('styles')
<style>
    .icon-input { position: relative; }
    .icon-input i.input-icon {
        position: absolute; left: 15px; top: 50%;
        transform: translateY(-50%); color: #6c757d; z-index: 5;
    }
    .icon-input .form-control,
    .icon-input .form-select { padding-left: 45px; }
    .back-button:hover { transform: translateX(-3px); transition: transform 0.2s ease; }
    select[multiple] { min-height: 150px; }

    /* Avatar Upload */
    .avatar-upload-wrap {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px dashed #dee2e6;
        transition: border-color 0.2s;
    }
    .avatar-upload-wrap:hover { border-color: #0d6efd; }
    .avatar-preview { position: relative; flex-shrink: 0; }
    .avatar-preview img {
        width: 90px; height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    }
    .avatar-preview-label {
        position: absolute; bottom: 0; right: 0;
        width: 28px; height: 28px;
        background: #0d6efd;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; border: 2px solid #fff;
    }
    .avatar-preview-label i { color: #fff; font-size: 12px; }
    .avatar-info .title { font-weight: 600; font-size: 0.9rem; margin-bottom: 4px; }
    .avatar-info .hint { font-size: 0.78rem; color: #6c757d; margin-bottom: 10px; }
    #foto_profil_siswa { display: none; }
    #foto-name-siswa { font-size: 0.75rem; color: #6c757d; margin-top: 4px; display: block; }

    /* NIS badge */
    .nis-info {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <a href="{{ route('backend.siswa.index') }}" class="btn btn-light btn-sm back-button mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">Tambah Siswa</h4>
        <p class="text-muted mb-0">Lengkapi informasi siswa yang akan didaftarkan</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3 bg-primary-subtle text-primary rounded-circle"
                             style="width:48px;height:48px;">
                            <i class="ti ti-user-plus fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Informasi Siswa</h5>
                            <small class="text-muted">Isi semua data dengan lengkap</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.siswa.store') }}" method="POST"
                          enctype="multipart/form-data" id="createSiswaForm">
                        @csrf

                        {{-- ── FOTO PROFIL ── --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-photo me-1"></i>Foto Profil
                                <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="avatar-upload-wrap">
                                <div class="avatar-preview">
                                    <img src="https://ui-avatars.com/api/?name=Siswa&background=0D8ABC&color=fff"
                                         id="preview-siswa" alt="Preview">
                                    <label class="avatar-preview-label" for="foto_profil_siswa">
                                        <i class="ti ti-camera"></i>
                                    </label>
                                </div>
                                <div class="avatar-info">
                                    <div class="title">Upload Foto Siswa</div>
                                    <div class="hint">Format: JPG, PNG, WEBP. Maks 2MB.</div>
                                    <label class="btn btn-sm btn-outline-primary rounded-pill"
                                           for="foto_profil_siswa">
                                        <i class="ti ti-upload me-1"></i> Pilih Foto
                                    </label>
                                    <input type="file" name="foto_profil" id="foto_profil_siswa"
                                           accept="image/*">
                                    <span id="foto-name-siswa">Belum ada foto dipilih</span>
                                </div>
                            </div>
                            @error('foto_profil')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            {{-- ── NAMA ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-user me-1"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-user input-icon"></i>
                                    <input type="text" name="name"
                                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           placeholder="Nama lengkap siswa"
                                           value="{{ old('name') }}" required>
                                </div>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- ── NIS ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-id-badge me-1"></i>NIS
                                    <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-hash input-icon"></i>
                                    <input type="text" name="nis"
                                           class="form-control form-control-lg @error('nis') is-invalid @enderror"
                                           placeholder="Nomor Induk Siswa"
                                           value="{{ old('nis') }}">
                                </div>
                                @error('nis')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <div class="nis-info">
                                        <i class="ti ti-info-circle"></i>
                                        NIS harus unik, biarkan kosong jika belum ada
                                    </div>
                                @enderror
                            </div>

                            {{-- ── EMAIL ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-mail me-1"></i>Email
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-mail input-icon"></i>
                                    <input type="email" name="email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           placeholder="contoh@email.com"
                                           value="{{ old('email') }}" required>
                                </div>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- ── PASSWORD ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-lock me-1"></i>Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-lock input-icon"></i>
                                    <input type="password" name="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           placeholder="Minimal 6 karakter" required>
                                </div>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- ── NO TELEPON ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-phone me-1"></i>No. Telepon
                                    <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-phone input-icon"></i>
                                    <input type="text" name="no_telepon"
                                           class="form-control form-control-lg"
                                           placeholder="08xx-xxxx-xxxx"
                                           value="{{ old('no_telepon') }}">
                                </div>
                            </div>

                            {{-- ── ALAMAT ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-map-pin me-1"></i>Alamat
                                    <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-map-pin input-icon"></i>
                                    <input type="text" name="alamat"
                                           class="form-control form-control-lg"
                                           placeholder="Alamat lengkap"
                                           value="{{ old('alamat') }}">
                                </div>
                            </div>
                        </div>

                        {{-- ── KELAS ── --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-door me-1"></i>Kelas
                                <span class="text-danger">*</span>
                            </label>
                            <select name="classes[]"
                                    class="form-select form-select-lg @error('classes') is-invalid @enderror"
                                    multiple required>
                                @foreach($classes as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ in_array($kelas->id, old('classes', [])) ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                <i class="ti ti-info-circle me-1"></i>
                                Tahan Ctrl / Cmd untuk memilih lebih dari satu kelas
                            </small>
                            @error('classes') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

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

        {{-- Sidebar Info --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-primary-subtle">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-info-circle fs-4 text-primary me-2"></i>
                        <h6 class="mb-0 fw-bold text-primary">Informasi</h6>
                    </div>
                    <small class="d-flex align-items-start mb-2">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>NIS adalah Nomor Induk Siswa yang unik</span>
                    </small>
                    <small class="d-flex align-items-start mb-2">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Foto profil akan muncul di halaman profil siswa</span>
                    </small>
                    <small class="d-flex align-items-start mb-2">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Email digunakan untuk login ke sistem</span>
                    </small>
                    <small class="d-flex align-items-start">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Siswa bisa terdaftar di lebih dari satu kelas</span>
                    </small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.getElementById('foto_profil_siswa').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            document.getElementById('foto-name-siswa').textContent = file.name;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview-siswa').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush