@extends('layouts.backend')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e9ecef;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.05);
        transition: all 0.2s ease;
    }

    .btn-action {
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: scale(1.05);
    }

    .card-stats {
        border-left: 4px solid var(--bs-primary);
    }

    .nis-badge {
        font-family: monospace;
        font-size: 0.78rem;
        background: #f1f3f5;
        color: #495057;
        padding: 2px 8px;
        border-radius: 6px;
        letter-spacing: 0.03em;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Data Siswa</h4>
            <p class="text-muted mb-0">Kelola semua akun siswa yang terdaftar</p>
        </div>
        <a href="{{ route('backend.siswa.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="ti ti-plus"></i>
            Tambah Siswa
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="ti ti-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-stats border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle"
                             style="width:56px;height:56px;">
                            <i class="ti ti-school fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $siswa->count() }}</h3>
                            <p class="text-muted mb-0">Total Siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- Filter Kelas --}}
            <div class="mb-3" style="max-width: 300px;">
                <label class="form-label fw-semibold">
                    <i class="ti ti-filter me-1"></i>Filter Kelas
                </label>
                <select id="filterKelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->nama_kelas }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            @if($siswa->isEmpty())
                <div class="text-center py-5">
                    <i class="ti ti-users" style="font-size: 5rem; color: #e0e0e0;"></i>
                    <h5 class="mt-3 mb-2">Belum Ada Siswa</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan siswa pertama</p>
                    <a href="{{ route('backend.siswa.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Siswa
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="siswaTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th>Siswa</th>
                                <th>NIS</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th>No. Telepon</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $item)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>

                                {{-- Foto + Nama --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $item->foto_profil_url }}"
                                             class="avatar-sm"
                                             alt="{{ $item->name }}">
                                        <div>
                                            <div class="fw-semibold">{{ $item->name }}</div>
                                            @if($item->alamat)
                                                <small class="text-muted">
                                                    <i class="ti ti-map-pin" style="font-size:0.7rem;"></i>
                                                    {{ Str::limit($item->alamat, 25) }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- NIS --}}
                                <td>
                                    @if($item->nis)
                                        <span class="nis-badge">{{ $item->nis }}</span>
                                    @else
                                        <span class="text-muted small fst-italic">Belum ada</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="text-muted">{{ $item->email }}</span>
                                </td>

                                {{-- Kelas --}}
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse($item->classes as $kelas)
                                            <span class="badge bg-primary-subtle text-primary"
                                                  style="font-size:0.72rem;padding:4px 8px;">
                                                {{ $kelas->nama_kelas }}
                                            </span>
                                        @empty
                                            <span class="text-muted small">-</span>
                                        @endforelse
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted">{{ $item->no_telepon ?? '-' }}</span>
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('backend.siswa.edit', $item->id) }}"
                                           class="btn btn-sm btn-warning btn-action"
                                           title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-danger btn-action"
                                                title="Hapus"
                                                onclick="confirmDeleteSiswa('{{ route('backend.siswa.destroy', $item->id) }}', '{{ $item->name }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
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

{{-- Hidden form hapus --}}
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const tableSiswa = $('#siswaTable').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ total siswa)",
            paginate: {
                first: "Pertama", last: "Terakhir",
                next: "Selanjutnya", previous: "Sebelumnya"
            },
            zeroRecords: "Data tidak ditemukan"
        },
        pageLength: 10,
        order: [[0, 'asc']]
    });

    // Filter kelas (kolom ke-4 = index 4)
    document.getElementById('filterKelas').addEventListener('change', function () {
        tableSiswa.column(4).search(this.value).draw();
    });

    // Konfirmasi hapus
    function confirmDeleteSiswa(url, nama) {
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