@extends('layouts.guru')

@section('styles')
<style>
    .form-floating > label {
        color: #6c757d;
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .form-floating > .form-select ~ label {
        color: var(--bs-warning);
    }
    
    .icon-input {
        position: relative;
    }
    
    .icon-input i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
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
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Breadcrumb -->
    <div class="mb-4">
        <a href="{{ route('guru.kelas.index') }}" class="btn btn-light btn-sm back-button mb-2">
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
                        <div class="avatar-md bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="ti ti-edit fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Edit Informasi Kelas</h5>
                            <small class="text-muted">Perbarui data kelas sesuai kebutuhan</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('guru.kelas.update', $kelas->id) }}" 
                          method="POST" 
                          id="editKelasForm">
                        @csrf
                        @method('PUT')

                        <!-- Kode Kelas Info (Read Only) -->
                        <div class="alert info-box mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-key fs-4 me-2"></i>
                                <div class="flex-grow-1">
                                    <small class="mb-0 d-block"><strong>Kode Kelas:</strong></small>
                                    <code class="fs-5">{{ $kelas->kode_kelas }}</code>
                                </div>
                                <button type="button" 
                                        onclick="copyKode('{{ $kelas->kode_kelas }}')"
                                        class="btn btn-sm btn-warning">
                                    <i class="ti ti-copy"></i> Salin
                                </button>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="ti ti-info-circle me-1"></i>
                                Kode kelas tidak dapat diubah
                            </small>
                        </div>

                        <!-- Nama Kelas -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-chalkboard me-1"></i>Nama Kelas
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-users"></i>
                                <input type="text" 
                                       name="nama_kelas"
                                       class="form-control form-control-lg"
                                       placeholder="Contoh: Kelas 10A, Kelas XII IPA 1"
                                       required
                                       value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                            </div>
                            @error('nama_kelas')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Mata Pelajaran -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-book me-1"></i>Mata Pelajaran
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-book-2"></i>
                                <select name="mapel_id" 
                                        class="form-select form-select-lg" 
                                        required>
                                    @foreach($mapels as $mapel)
                                        <option value="{{ $mapel->id }}" 
                                            {{ (old('mapel_id', $kelas->mapel_id) == $mapel->id) ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('mapel_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Last Updated Info -->
                        <div class="mb-4">
                            <small class="text-muted">
                                <i class="ti ti-clock me-1"></i>
                                Terakhir diupdate: {{ $kelas->updated_at->format('d M Y, H:i') }}
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('guru.kelas.index') }}" 
                               class="btn btn-light">
                                <i class="ti ti-x me-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="ti ti-device-floppy me-1"></i>
                                Update Kelas
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-danger mt-3">
                <div class="card-header bg-danger-subtle">
                    <h6 class="mb-0 text-danger">
                        <i class="ti ti-alert-triangle me-1"></i>
                        Zona Berbahaya
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-3 text-muted">
                        <small>Menghapus kelas akan menghapus semua data terkait termasuk tugas dan pengumpulan siswa. Tindakan ini tidak dapat dibatalkan.</small>
                    </p>
                    <form action="{{ route('guru.kelas.destroy', $kelas->id) }}" 
                          method="POST"
                          onsubmit="return confirm('⚠️ PERINGATAN!\n\nAnda yakin ingin menghapus kelas {{ $kelas->nama_kelas }}?\n\nSemua data tugas dan pengumpulan siswa akan ikut terhapus dan tidak dapat dikembalikan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i>
                            Hapus Kelas Ini
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Current Status -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="ti ti-info-circle me-1"></i>
                        Status Kelas
                    </h6>
                    
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Nama Kelas Saat Ini</small>
                        <span class="fw-semibold">{{ $kelas->nama_kelas }}</span>
                    </div>
                    
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Mata Pelajaran Saat Ini</small>
                        <span class="badge bg-info-subtle text-info">
                            {{ $kelas->mapel->nama_mapel }}
                        </span>
                    </div>
                    
                    <div>
                        <small class="text-muted d-block mb-1">Dibuat Pada</small>
                        <span class="fw-semibold">{{ $kelas->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="card border-0 shadow-sm mt-3 bg-warning-subtle">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-bulb fs-4 text-warning me-2"></i>
                        <h6 class="mb-0 fw-bold text-warning">Tips</h6>
                    </div>
                    
                    <small class="text-muted">
                        <ul class="ps-3 mb-0">
                            <li class="mb-2">Pastikan nama kelas tetap mudah dikenali</li>
                            <li class="mb-2">Hati-hati saat mengubah mata pelajaran</li>
                            <li>Backup data penting sebelum menghapus</li>
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
    // Copy kode function
    function copyKode(kode) {
        navigator.clipboard.writeText(kode).then(function() {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'position-fixed top-0 end-0 p-3';
            alertDiv.style.zIndex = '9999';
            alertDiv.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                    <i class="ti ti-check me-2"></i>
                    Kode <strong>${kode}</strong> berhasil disalin!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        });
    }

    // Form validation
    document.getElementById('editKelasForm').addEventListener('submit', function(e) {
        const namaKelas = document.querySelector('input[name="nama_kelas"]').value.trim();
        const mapelId = document.querySelector('select[name="mapel_id"]').value;
        
        if (!namaKelas || !mapelId) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }
    });
</script>
@endpush