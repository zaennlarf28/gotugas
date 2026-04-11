@extends('layouts.backend')

@section('styles')
<style>
    .form-check {
        padding: 8px 12px;
        border-radius: 8px;
        transition: 0.2s;
    }
    .form-check:hover {
        background: rgba(0,0,0,0.05);
    }
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
    .avatar-upload-wrap:hover {
        border-color: #0d6efd;
    }
    .avatar-preview {
        position: relative;
        flex-shrink: 0;
    }
    .avatar-preview img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    }
    .avatar-preview-label {
        position: absolute;
        bottom: 0; right: 0;
        width: 28px; height: 28px;
        background: #0d6efd;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        border: 2px solid #fff;
        transition: background 0.2s;
    }
    .avatar-preview-label:hover { background: #0b5ed7; }
    .avatar-preview-label i { color: #fff; font-size: 12px; }
    .avatar-info {
        flex: 1;
    }
    .avatar-info .title {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 4px;
    }
    .avatar-info .hint {
        font-size: 0.78rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    #foto_profil_guru { display: none; }
    #foto-name-guru {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 4px;
        display: block;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="ti ti-user-plus fs-5"></i>
            <h4 class="mb-0">Tambah Guru</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ── FOTO PROFIL ── --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Foto Profil</label>
                    <div class="avatar-upload-wrap">
                        <div class="avatar-preview">
                            <img src="https://ui-avatars.com/api/?name=Guru&background=0D8ABC&color=fff"
                                 id="preview-guru" alt="Preview">
                            <label class="avatar-preview-label" for="foto_profil_guru" title="Ganti foto">
                                <i class="ti ti-camera"></i>
                            </label>
                        </div>
                        <div class="avatar-info">
                            <div class="title">Upload Foto Guru</div>
                            <div class="hint">Format: JPG, PNG, WEBP. Maks 2MB.</div>
                            <label class="btn btn-sm btn-outline-primary rounded-pill" for="foto_profil_guru">
                                <i class="ti ti-upload me-1"></i> Pilih Foto
                            </label>
                            <input type="file" name="foto_profil" id="foto_profil_guru"
                                   accept="image/*">
                            <span id="foto-name-guru">Belum ada foto dipilih</span>
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
                               placeholder="Nama lengkap guru"
                               value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- ── EMAIL ── --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-mail me-1"></i>Email
                        </label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@contoh.com"
                               value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- ── PASSWORD ── --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-lock me-1"></i>Password
                        </label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 6 karakter" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- ── NO TELEPON ── --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-phone me-1"></i>No. Telepon
                            <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <input type="text" name="no_telepon"
                               class="form-control"
                               placeholder="08xx-xxxx-xxxx"
                               value="{{ old('no_telepon') }}">
                    </div>

                    {{-- ── ALAMAT ── --}}
                    <div class="col-12 mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-map-pin me-1"></i>Alamat
                            <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <input type="text" name="alamat"
                               class="form-control"
                               placeholder="Alamat lengkap"
                               value="{{ old('alamat') }}">
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
                                               {{ in_array($mapel->id, old('mapels', [])) ? 'checked' : '' }}>
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
                            @foreach ($classes as $class)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="classes[]"
                                               value="{{ $class->id }}"
                                               id="class{{ $class->id }}"
                                               {{ in_array($class->id, old('classes', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="class{{ $class->id }}">
                                            {{ $class->nama_kelas }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('classes') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-device-floppy me-1"></i> Simpan
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
    // Preview foto profil guru
    document.getElementById('foto_profil_guru').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            document.getElementById('foto-name-guru').textContent = file.name;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview-guru').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush