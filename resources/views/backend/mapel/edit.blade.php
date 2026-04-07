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
        <a href="{{ route('backend.mapel.index') }}" class="btn btn-light btn-sm back-button mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">Edit Mata Pelajaran</h4>
        <p class="text-muted mb-0">Perbarui informasi mata pelajaran</p>
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
                            <h5 class="mb-0">Edit Informasi Mata Pelajaran</h5>
                            <small class="text-muted">Perbarui data sesuai kebutuhan</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.mapel.update', $mapel->id) }}" method="POST" id="editMapelForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Mapel -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-book me-1"></i>Nama Mata Pelajaran
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-book-2"></i>
                                <input type="text"
                                       name="nama_mapel"
                                       class="form-control form-control-lg @error('nama_mapel') is-invalid @enderror"
                                       placeholder="Contoh: Matematika, Bahasa Indonesia"
                                       required
                                       value="{{ old('nama_mapel', $mapel->nama_mapel) }}">
                            </div>
                            @error('nama_mapel')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Kode Mapel -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-tag me-1"></i>Kode Mata Pelajaran
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-hash"></i>
                                <input type="text"
                                       name="kode_mapel"
                                       class="form-control form-control-lg @error('kode_mapel') is-invalid @enderror"
                                       placeholder="Contoh: MTK, B.IND, IPA"
                                       required
                                       value="{{ old('kode_mapel', $mapel->kode_mapel) }}"
                                       style="text-transform: uppercase;">
                            </div>
                            @error('kode_mapel')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Last Updated -->
                        <div class="mb-4">
                            <small class="text-muted">
                                <i class="ti ti-clock me-1"></i>
                                Terakhir diupdate: {{ $mapel->updated_at->format('d M Y, H:i') }}
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('backend.mapel.index') }}" class="btn btn-light">
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
                        <small>Menghapus mata pelajaran ini akan berdampak pada data kelas yang menggunakan mapel ini. Tindakan ini tidak dapat dibatalkan.</small>
                    </p>
                    <form action="{{ route('backend.mapel.destroy', $mapel) }}"
                          method="POST"
                          onsubmit="return confirm('⚠️ PERINGATAN!\n\nYakin ingin menghapus mapel {{ $mapel->nama_mapel }}?\n\nTindakan ini tidak dapat dikembalikan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i> Hapus Mapel Ini
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
                        <small class="text-muted d-block mb-1">Nama Mata Pelajaran</small>
                        <span class="fw-semibold">{{ $mapel->nama_mapel }}</span>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Kode Mapel</small>
                        <code class="bg-light px-3 py-1 rounded">{{ $mapel->kode_mapel }}</code>
                    </div>

                    <div>
                        <small class="text-muted d-block mb-1">Dibuat Pada</small>
                        <span class="fw-semibold">{{ $mapel->created_at->format('d M Y') }}</span>
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
                            <li class="mb-2">Pastikan nama mapel tetap konsisten</li>
                            <li class="mb-2">Perubahan nama akan berdampak pada tampilan kelas</li>
                            <li>Backup data penting sebelum menghapus</li>
                        </ul>
                    </small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection