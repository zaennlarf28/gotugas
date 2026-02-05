@extends('layouts.guru')

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
        z-index: 10;
    }
    
    .icon-input .form-control,
    .icon-input .form-select {
        padding-left: 45px;
    }
    
    .back-button:hover {
        transform: translateX(-3px);
        transition: transform 0.2s ease;
    }
    
    .char-counter {
        font-size: 0.75rem;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Breadcrumb -->
    <div class="mb-4">
        <a href="{{ route('guru.tugas.index') }}" class="btn btn-light btn-sm back-button mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">
            {{ isset($tugas) ? 'Edit Tugas' : 'Tambah Tugas Baru' }}
        </h4>
        <p class="text-muted mb-0">
            {{ isset($tugas) ? 'Perbarui informasi tugas' : 'Lengkapi informasi tugas untuk kelas ' . $kelas->nama_kelas }}
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header {{ isset($tugas) ? 'bg-warning-subtle' : 'bg-primary-subtle' }} border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md {{ isset($tugas) ? 'bg-warning' : 'bg-primary' }} text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="ti {{ isset($tugas) ? 'ti-edit' : 'ti-plus' }} fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Informasi Tugas</h5>
                            <small class="text-muted">Isi detail tugas dengan lengkap</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" 
                          action="{{ isset($tugas) ? route('guru.tugas.update', $tugas->id) : route('guru.tugas.store', ['kelas' => $kelas->id]) }}"
                          id="tugasForm">
                        @csrf
                        @if(isset($tugas))
                            @method('PUT')
                        @endif

                        <!-- Kelas Info (Only for create) -->
                        @if(!isset($tugas))
                        <div class="alert alert-info d-flex align-items-center mb-4">
                            <i class="ti ti-info-circle fs-4 me-2"></i>
                            <div>
                                <strong>Kelas:</strong> {{ $kelas->nama_kelas }}
                                <br>
                                <small>{{ $kelas->mapel->nama_mapel }}</small>
                            </div>
                        </div>
                        @endif

                        <!-- Judul -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-file-text me-1"></i>Judul Tugas
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-pencil"></i>
                                <input type="text" 
                                       name="judul"
                                       class="form-control form-control-lg"
                                       placeholder="Contoh: Soal Latihan Bab 5"
                                       maxlength="100"
                                       required
                                       value="{{ old('judul', $tugas->judul ?? '') }}"
                                       id="judulInput">
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                @error('judul')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="text-muted">Buat judul yang jelas dan mudah dipahami</small>
                                @enderror
                                <small class="char-counter">
                                    <span id="judulCount">0</span>/100
                                </small>
                            </div>
                        </div>

                        <!-- Perintah -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-message me-1"></i>Perintah
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-list-check"></i>
                                <input type="text" 
                                       name="perintah"
                                       class="form-control form-control-lg"
                                       placeholder="Contoh: Kerjakan soal halaman 45-50"
                                       maxlength="200"
                                       required
                                       value="{{ old('perintah', $tugas->perintah ?? '') }}"
                                       id="perintahInput">
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                @error('perintah')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="text-muted">Instruksi singkat untuk siswa</small>
                                @enderror
                                <small class="char-counter">
                                    <span id="perintahCount">0</span>/200
                                </small>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-align-left me-1"></i>Deskripsi
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi" 
                                      class="form-control" 
                                      rows="5"
                                      placeholder="Jelaskan detail tugas, kriteria penilaian, atau catatan tambahan..."
                                      maxlength="500"
                                      required
                                      id="deskripsiInput">{{ old('deskripsi', $tugas->deskripsi ?? '') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                @error('deskripsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @else
                                    <small class="text-muted">Penjelasan lengkap tentang tugas</small>
                                @enderror
                                <small class="char-counter">
                                    <span id="deskripsiCount">0</span>/500
                                </small>
                            </div>
                        </div>

                        <!-- Deadline -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-calendar me-1"></i>Deadline
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="ti ti-clock"></i>
                                <input type="datetime-local" 
                                       name="deadline"
                                       class="form-control form-control-lg"
                                       required
                                       value="{{ old('deadline', isset($tugas) ? date('Y-m-d\TH:i', strtotime($tugas->deadline)) : '') }}"
                                       min="{{ date('Y-m-d\TH:i') }}">
                            </div>
                            @error('deadline')
                                <small class="text-danger">{{ $message }}</small>
                            @else
                                <small class="text-muted">
                                    <i class="ti ti-info-circle me-1"></i>
                                    Tentukan batas waktu pengumpulan tugas
                                </small>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('guru.tugas.index') }}" class="btn btn-light">
                                <i class="ti ti-x me-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn {{ isset($tugas) ? 'btn-warning' : 'btn-primary' }}">
                                <i class="ti ti-device-floppy me-1"></i>
                                {{ isset($tugas) ? 'Update Tugas' : 'Simpan Tugas' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="col-lg-4">
            <!-- Tips Card -->
            <div class="card border-0 shadow-sm {{ isset($tugas) ? 'bg-warning-subtle' : 'bg-primary-subtle' }}">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-bulb fs-4 {{ isset($tugas) ? 'text-warning' : 'text-primary' }} me-2"></i>
                        <h6 class="mb-0 fw-bold {{ isset($tugas) ? 'text-warning' : 'text-primary' }}">
                            Tips Membuat Tugas
                        </h6>
                    </div>
                    
                    <small class="text-muted">
                        <ul class="ps-3 mb-0">
                            <li class="mb-2">Gunakan judul yang spesifik dan jelas</li>
                            <li class="mb-2">Berikan perintah yang mudah dipahami</li>
                            <li class="mb-2">Jelaskan kriteria penilaian di deskripsi</li>
                            <li class="mb-2">Beri waktu yang cukup untuk siswa</li>
                            <li>Cek kembali sebelum menyimpan</li>
                        </ul>
                    </small>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-info-circle fs-4 text-info me-2"></i>
                        <h6 class="mb-0 fw-bold">Informasi</h6>
                    </div>
                    
                    <small class="d-flex align-items-start mb-2">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Siswa dapat melihat tugas setelah disimpan</span>
                    </small>
                    <small class="d-flex align-items-start mb-2">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Anda dapat mengedit tugas kapan saja</span>
                    </small>
                    <small class="d-flex align-items-start">
                        <i class="ti ti-check text-success me-2 mt-1"></i>
                        <span>Deadline dapat disesuaikan jika diperlukan</span>
                    </small>
                </div>
            </div>

            <!-- Current Info (Edit only) -->
            @if(isset($tugas))
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="ti ti-file-info me-1"></i>
                        Informasi Tugas
                    </h6>
                    
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Kelas</small>
                        <span class="fw-semibold">{{ $tugas->kelas->nama_kelas }}</span>
                    </div>
                    
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Dibuat Pada</small>
                        <span class="fw-semibold">{{ $tugas->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    
                    <div>
                        <small class="text-muted d-block mb-1">Terakhir Diupdate</small>
                        <span class="fw-semibold">{{ $tugas->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Character counter
    function updateCounter(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        
        if(input && counter) {
            const updateCount = () => {
                counter.textContent = input.value.length;
                if(input.value.length >= maxLength * 0.9) {
                    counter.classList.add('text-danger');
                } else {
                    counter.classList.remove('text-danger');
                }
            };
            
            updateCount();
            input.addEventListener('input', updateCount);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateCounter('judulInput', 'judulCount', 100);
        updateCounter('perintahInput', 'perintahCount', 200);
        updateCounter('deskripsiInput', 'deskripsiCount', 500);
        
        // Auto-focus
        document.getElementById('judulInput').focus();
    });

    // Form validation
    document.getElementById('tugasForm').addEventListener('submit', function(e) {
        const judul = document.querySelector('input[name="judul"]').value.trim();
        const perintah = document.querySelector('input[name="perintah"]').value.trim();
        const deskripsi = document.querySelector('textarea[name="deskripsi"]').value.trim();
        const deadline = document.querySelector('input[name="deadline"]').value;
        
        if (!judul || !perintah || !deskripsi || !deadline) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }
        
        // Check if deadline is in the past
        const deadlineDate = new Date(deadline);
        const now = new Date();
        
        if (deadlineDate < now) {
            e.preventDefault();
            alert('Deadline tidak boleh di masa lalu!');
            return false;
        }
    });
</script>
@endpush