@extends('layouts.guru')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .kode-badge {
        font-family: 'Courier New', monospace;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        letter-spacing: 1px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.05);
        transition: all 0.2s ease;
    }
    
    .card-stats {
        border-left: 4px solid var(--bs-primary);
    }
    
    .btn-copy {
        transition: all 0.2s ease;
    }
    
    .btn-copy:hover {
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Kelas Saya</h4>
            <p class="text-muted mb-0">Kelola semua kelas yang Anda ampu</p>
        </div>
        <a href="{{ route('guru.kelas.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="ti ti-plus"></i>
            Buat Kelas Baru
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="ti ti-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('kode_kelas'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti ti-info-circle fs-4 me-2"></i>
                <div>
                    <strong>Kelas berhasil dibuat!</strong><br>
                    Kode Kelas: <span class="badge bg-dark kode-badge">{{ session('kode_kelas') }}</span>
                    <button onclick="copyKode('{{ session('kode_kelas') }}')" class="btn btn-sm btn-outline-dark ms-2">
                        <i class="ti ti-copy"></i> Salin
                    </button>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-stats border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ti ti-school fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
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
            
            @if($kelas->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="ti ti-school" style="font-size: 5rem; color: #e0e0e0;"></i>
                    </div>
                    <h5 class="mb-2">Belum Ada Kelas</h5>
                    <p class="text-muted mb-4">Mulai dengan membuat kelas pertama Anda</p>
                    <a href="{{ route('guru.kelas.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Buat Kelas Baru
                    </a>
                </div>
            @else
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="kelasTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="60">No</th>
                                <th>
                                    <i class="ti ti-chalkboard me-1"></i>Nama Kelas
                                </th>
                                <th>
                                    <i class="ti ti-book me-1"></i>Mata Pelajaran
                                </th>
                                <th>
                                    <i class="ti ti-key me-1"></i>Kode Kelas
                                </th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $k)
                            <tr>
                                <td class="text-center fw-semibold text-muted">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center me-2">
                                            <i class="ti ti-users"></i>
                                        </div>
                                        <span class="fw-semibold">{{ $k->nama_kelas }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info">
                                        {{ $k->mapel->nama_mapel }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <code class="bg-light px-3 py-2 rounded">{{ $k->kode_kelas }}</code>
                                        <button onclick="copyKode('{{ $k->kode_kelas }}')"
                                                class="btn btn-sm btn-outline-secondary btn-copy"
                                                title="Salin kode">
                                            <i class="ti ti-copy"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('guru.kelas.edit', $k->id) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('guru.kelas.destroy', $k->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kelas {{ $k->nama_kelas }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Hapus">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
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
    // Initialize DataTable
    $(document).ready(function() {
        $('#kelasTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ kelas",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 kelas",
                infoFiltered: "(difilter dari _MAX_ total kelas)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                zeroRecords: "Data tidak ditemukan"
            },
            pageLength: 10,
            order: [[0, 'asc']]
        });
    });

    // Copy kode function with better UX
    function copyKode(kode) {
        navigator.clipboard.writeText(kode).then(function() {
            // Show toast notification
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
        }, function(err) {
            alert('Gagal menyalin kode: ' + err);
        });
    }
</script>
@endpush