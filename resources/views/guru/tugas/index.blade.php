@extends('layouts.guru')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .deadline-badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
    }
    
    .deadline-urgent {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    }
    
    .deadline-soon {
        background: linear-gradient(135deg, #ffd93d 0%, #f6c23e 100%);
    }
    
    .deadline-normal {
        background: linear-gradient(135deg, #6bcf7f 0%, #57b969 100%);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.03);
        transition: all 0.2s ease;
    }
    
    .btn-action {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .dropdown-kelas {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .tugas-card {
        border-left: 4px solid var(--bs-primary);
        transition: all 0.3s ease;
    }
    
    .tugas-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Daftar Tugas</h4>
            <p class="text-muted mb-0">Kelola semua tugas di kelas Anda</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2" 
                    type="button" 
                    data-bs-toggle="dropdown">
                <i class="ti ti-plus"></i>
                Tambah Tugas Baru
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-kelas shadow">
                @forelse($kelas as $item)
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" 
                           href="{{ route('guru.tugas.create', ['kelas' => $item->id]) }}">
                            <i class="ti ti-chalkboard me-2"></i>
                            <div>
                                <div class="fw-semibold">{{ $item->nama_kelas }}</div>
                                <small class="text-muted">{{ $item->mapel->nama_mapel }}</small>
                            </div>
                        </a>
                    </li>
                    @if(!$loop->last)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                @empty
                    <li class="px-3 py-2 text-muted">
                        <i class="ti ti-alert-circle me-1"></i>
                        Belum ada kelas
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="ti ti-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="ti ti-clipboard-list fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">
                                @php
                                    $totalTugas = 0;
                                    foreach($kelas as $item) {
                                        $totalTugas += $item->tugas->count();
                                    }
                                @endphp
                                {{ $totalTugas }}
                            </h3>
                            <p class="text-muted mb-0">Total Tugas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="ti ti-school fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $kelas->count() }}</h3>
                            <p class="text-muted mb-0">Total Kelas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            
            @php
                $hasTugas = false;
                foreach($kelas as $item) {
                    if($item->tugas->isNotEmpty()) {
                        $hasTugas = true;
                        break;
                    }
                }
            @endphp

            @if(!$hasTugas)
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="ti ti-clipboard-off" style="font-size: 5rem; color: #e0e0e0;"></i>
                    </div>
                    <h5 class="mb-2">Belum Ada Tugas</h5>
                    <p class="text-muted mb-4">Mulai dengan membuat tugas pertama untuk kelas Anda</p>
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="ti ti-plus me-1"></i> Buat Tugas Baru
                        </button>
                        <ul class="dropdown-menu dropdown-kelas">
                            @foreach($kelas as $item)
                                <li>
                                    <a class="dropdown-item" href="{{ route('guru.tugas.create', ['kelas' => $item->id]) }}">
                                        {{ $item->nama_kelas }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tugasTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th><i class="ti ti-chalkboard me-1"></i>Kelas</th>
                                <th><i class="ti ti-file-text me-1"></i>Judul Tugas</th>
                                <th><i class="ti ti-message me-1"></i>Perintah</th>
                                <th><i class="ti ti-align-left me-1"></i>Deskripsi</th>
                                <th><i class="ti ti-calendar me-1"></i>Deadline</th>
                                <th class="text-center" width="250">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($kelas as $item)
                                @foreach ($item->tugas as $tugas)
                                @php
                                    $deadline = \Carbon\Carbon::parse($tugas->deadline);
                                    $now = \Carbon\Carbon::now();
                                    $diffDays = $now->diffInDays($deadline, false);
                                    
                                    if($diffDays < 0) {
                                        $badgeClass = 'deadline-urgent';
                                        $badgeText = 'Terlewat';
                                    } elseif($diffDays <= 2) {
                                        $badgeClass = 'deadline-urgent';
                                        $badgeText = 'Mendesak';
                                    } elseif($diffDays <= 7) {
                                        $badgeClass = 'deadline-soon';
                                        $badgeText = 'Segera';
                                    } else {
                                        $badgeClass = 'deadline-normal';
                                        $badgeText = 'Normal';
                                    }
                                @endphp
                                <tr>
                                    <td class="text-center fw-semibold text-muted">{{ $no++ }}</td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold">{{ $item->nama_kelas }}</span>
                                            <br>
                                            <small class="badge bg-info-subtle text-info">
                                                {{ $item->mapel->nama_mapel }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $tugas->judul }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ Str::limit($tugas->perintah, 50) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ Str::limit($tugas->deskripsi, 50) }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge {{ $badgeClass }} text-white deadline-badge">
                                                {{ $badgeText }}
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                {{ $deadline->translatedFormat('d M Y, H:i') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            <a href="{{ route('guru.tugas.pengumpulan', $tugas->id) }}" 
                                               class="btn btn-sm btn-info btn-action"
                                               title="Lihat Pengumpulan">
                                                <i class="ti ti-folder-open"></i>
                                                Pengumpulan
                                            </a>
                                            <a href="{{ route('guru.tugas.edit', $tugas->id) }}" 
                                               class="btn btn-sm btn-warning btn-action"
                                               title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('guru.tugas.destroy', $tugas->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus tugas {{ $tugas->judul }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger btn-action"
                                                        title="Hapus">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        $('#tugasTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ tugas",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 tugas",
                infoFiltered: "(difilter dari _MAX_ total tugas)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                zeroRecords: "Data tidak ditemukan"
            },
            pageLength: 10,
            order: [[5, 'asc']] // Sort by deadline
        });
    });
</script>
@endpush