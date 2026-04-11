@extends('layouts.backend')

@section('styles')
<style>
    .form-check {
        padding: 8px 12px;
        border-radius: 8px;
        transition: 0.2s;
    }
    .form-check:hover { background: rgba(0,0,0,0.05); }
    .section-box {
        border: 1px solid #eaeaea;
        border-radius: 10px;
        padding: 15px;
        max-height: 250px;
        overflow-y: auto;
    }

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
    .avatar-preview {
        position: relative;
        flex-shrink: 0;
    }
    .avatar-preview img {
        width: 90px; height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    }
    .avatar-preview-label {
        position: absolute;
        bottom: 0; right: 0;
        width: 28px; height: 28px;
        background: #ffc107;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        border: 2px solid #fff;
    }
    .avatar-preview-label i { color: #fff; font-size: 12px; }
    .avatar-info .title { font-weight: 600; font-size: 0.9rem; margin-bottom: 4px; }
    .avatar-info .hint { font-size: 0.78rem; color: #6c757d; margin-bottom: 10px; }
    #foto_profil_guru_edit { display: none; }
    #foto-name-guru-edit { font-size: 0.75rem; color: #6c757d; margin-top: 4px; display: block; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="ti ti-user-edit fs-5"></i>
            <h4 class="mb-0">Edit Guru</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.guru.update', $guru->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ── FOTO PROFIL ── --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Foto Profil</label>
                    <div class="avatar-upload-wrap">
                        <div class="avatar-preview">
                            <img src="{{ $guru->foto_profil_url }}"
                                 id="preview-guru-edit" alt="Foto Guru">
                            <label class="avatar-preview-label" for="foto_profil_guru_edit" title="Ganti foto">
                                <i class="ti ti-camera"></i>
                            </label>
                        </div>
                        <div class="avatar-info">
                            <div class="title">Ganti Foto Guru</div>
                            <div class="hint">Kosongkan jika tidak ingin mengubah foto. Maks 2MB.</div>
                            <label class="btn btn-sm btn-outline-warning rounded-pill" for="foto_profil_guru_edit">
                                <i class="ti ti-upload me-1"></i> Pilih Foto Baru
                            </label>
                            <input type="file" name="foto_profil" id="foto_profil_guru_edit"
                                   accept="image/*">
                            <span id="foto-name-guru-edit">Belum ada foto dipilih</span>
                        </div>
                    </div>
                    @error('foto_profil')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <hr class="my-4">

                <div class="row">
                    {{-- ── NAMA ── --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-user me-1"></i>Nama Guru
                        </label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $guru->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- ── EMAIL ── --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-mail me-1"></i>Email
                        </label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $guru->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- ── PASSWORD ── --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-lock me-1"></i>Password Baru
                            <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="Kosongkan jika tidak diubah">
                    </div>

                    {{-- ── NO TELEPON ── --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-phone me-1"></i>No. Telepon
                        </label>
                        <input type="text" name="no_telepon"
                               class="form-control"
                               value="{{ old('no_telepon', $guru->no_telepon) }}"
                               placeholder="08xx-xxxx-xxxx">
                    </div>

                    {{-- ── ALAMAT ── --}}
                    <div class="col-12 mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-map-pin me-1"></i>Alamat
                        </label>
                        <input type="text" name="alamat"
                               class="form-control"
                               value="{{ old('alamat', $guru->alamat) }}"
                               placeholder="Alamat lengkap">
                    </div>
                </div>

                <hr class="my-4">

                {{-- ── MATA PELAJARAN ── --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="ti ti-book me-1"></i>Mata Pelajaran
                        <span class="text-danger">*</span>
                    </label>
                    <div class="section-box">
                        <div class="row">
                            @foreach ($mapels as $mapel)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="mapels[]"
                                               value="{{ $mapel->id }}"
                                               id="mapel{{ $mapel->id }}"
                                               {{ $guru->mapels->contains($mapel->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mapel{{ $mapel->id }}">
                                            {{ $mapel->nama_mapel }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('mapels') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- ── KELAS ── --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="ti ti-school me-1"></i>Kelas
                        <span class="text-danger">*</span>
                    </label>
                    <div class="section-box">
                        <div class="row">
                            @foreach ($classes as $kelas)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="classes[]"
                                               value="{{ $kelas->id }}"
                                               id="class{{ $kelas->id }}"
                                               {{ $guru->classes->contains($kelas->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="class{{ $kelas->id }}">
                                            {{ $kelas->nama_kelas }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('classes') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-device-floppy me-1"></i> Update
                    </button>
                    <a href="{{ route('backend.guru.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('foto_profil_guru_edit').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            document.getElementById('foto-name-guru-edit').textContent = file.name;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview-guru-edit').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush