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
    .avatar-upload-wrap:hover { border-color: #ffc107; }
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
        background: #ffc107;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; border: 2px solid #fff;
    }
    .avatar-preview-label i { color: #fff; font-size: 12px; }
    .avatar-info .title { font-weight: 600; font-size: 0.9rem; margin-bottom: 4px; }
    .avatar-info .hint { font-size: 0.78rem; color: #6c757d; margin-bottom: 10px; }
    #foto_profil_siswa_edit { display: none; }
    #foto-name-siswa-edit { font-size: 0.75rem; color: #6c757d; margin-top: 4px; display: block; }
    .nis-info { font-size: 0.75rem; color: #6c757d; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <a href="{{ route('backend.siswa.index') }}" class="btn btn-light btn-sm back-button mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">Edit Siswa</h4>
        <p class="text-muted mb-0">Perbarui informasi data siswa</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning-subtle border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3 bg-warning text-white rounded-circle"
                             style="width:48px;height:48px;">
                            <i class="ti ti-edit fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Edit Informasi Siswa</h5>
                            <small class="text-muted">Perbarui data siswa sesuai kebutuhan</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.siswa.update', $siswa->id) }}" method="POST"
                          enctype="multipart/form-data" id="editSiswaForm">
                        @csrf
                        @method('PUT')

                        {{-- ── FOTO PROFIL ── --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-photo me-1"></i>Foto Profil
                            </label>
                            <div class="avatar-upload-wrap">
                                <div class="avatar-preview">
                                    <img src="{{ $siswa->foto_profil_url }}"
                                         id="preview-siswa-edit" alt="Foto Siswa">
                                    <label class="avatar-preview-label" for="foto_profil_siswa_edit">
                                        <i class="ti ti-camera"></i>
                                    </label>
                                </div>
                                <div class="avatar-info">
                                    <div class="title">Ganti Foto Siswa</div>
                                    <div class="hint">Kosongkan jika tidak ingin mengubah foto. Maks 2MB.</div>
                                    <label class="btn btn-sm btn-outline-warning rounded-pill"
                                           for="foto_profil_siswa_edit">
                                        <i class="ti ti-upload me-1"></i> Pilih Foto Baru
                                    </label>
                                    <input type="file" name="foto_profil" id="foto_profil_siswa_edit"
                                           accept="image/*">
                                    <span id="foto-name-siswa-edit">Belum ada foto dipilih</span>
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
                                           value="{{ old('name', $siswa->name) }}" required>
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
                                           value="{{ old('nis', $siswa->nis) }}">
                                </div>
                                @error('nis')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <div class="nis-info">
                                        <i class="ti ti-info-circle"></i>
                                        NIS harus unik antar siswa
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
                                           value="{{ old('email', $siswa->email) }}" required>
                                </div>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- ── PASSWORD ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-lock me-1"></i>Password Baru
                                    <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-lock input-icon"></i>
                                    <input type="password" name="password"
                                           class="form-control form-control-lg"
                                           placeholder="Kosongkan jika tidak diubah">
                                </div>
                            </div>

                            {{-- ── NO TELEPON ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-phone me-1"></i>No. Telepon
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-phone input-icon"></i>
                                    <input type="text" name="no_telepon"
                                           class="form-control form-control-lg"
                                           value="{{ old('no_telepon', $siswa->no_telepon) }}"
                                           placeholder="08xx-xxxx-xxxx">
                                </div>
                            </div>

                            {{-- ── ALAMAT ── --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-map-pin me-1"></i>Alamat
                                </label>
                                <div class="icon-input">
                                    <i class="ti ti-map-pin input-icon"></i>
                                    <input type="text" name="alamat"
                                           class="form-control form-control-lg"
                                           value="{{ old('alamat', $siswa->alamat) }}"
                                           placeholder="Alamat lengkap">
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
                                        @selected($siswa->classes->contains($kelas->id))>
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

                        <div class="mb-4">
                            <small class="text-muted">
                                <i class="ti ti-clock me-1"></i>
                                Terakhir diupdate: {{ $siswa->updated_at->format('d M Y, H:i') }}
                            </small>
                        </div>

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

            {{-- Danger Zone --}}
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
                    <button type="button" class="btn btn-danger"
                            onclick="confirmDelete('{{ route('backend.siswa.destroy', $siswa->id) }}', '{{ $siswa->name }}')">
                        <i class="ti ti-trash me-1"></i> Hapus Siswa Ini
                    </button>
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="ti ti-info-circle me-1"></i> Status Saat Ini
                    </h6>

                    {{-- Avatar besar --}}
                    <div class="text-center mb-3 pb-3 border-bottom">
                        <img src="{{ $siswa->foto_profil_url }}"
                             class="rounded-circle mb-2"
                             width="72" height="72"
                             style="object-fit:cover;border:3px solid #e9ecef;"
                             alt="Foto">
                        <div class="fw-semibold">{{ $siswa->name }}</div>
                        <small class="text-muted">{{ $siswa->email }}</small>
                    </div>

                    <div class="mb-2 pb-2 border-bottom">
                        <small class="text-muted d-block mb-1">NIS</small>
                        <span class="fw-semibold">
                            {{ $siswa->nis ?? '-' }}
                        </span>
                    </div>

                    <div class="mb-2 pb-2 border-bottom">
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
        </div>
    </div>

</div>

<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Preview foto
    document.getElementById('foto_profil_siswa_edit').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            document.getElementById('foto-name-siswa-edit').textContent = file.name;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview-siswa-edit').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Konfirmasi hapus
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