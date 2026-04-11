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

    .badge-mapel {
        font-size: 0.72rem;
        padding: 4px 8px;
    }
    .badge-kelas {
        font-size: 0.72rem;
        padding: 4px 8px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Data Guru</h4>
            <p class="text-muted mb-0">Kelola semua akun guru yang terdaftar</p>
        </div>
        <a href="{{ route('backend.guru.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="ti ti-plus"></i>
            Tambah Guru
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
                            <i class="ti ti-users fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $guru->count() }}</h3>
                            <p class="text-muted mb-0">Total Guru</p>
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
                <select id="filterKelasGuru" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->nama_kelas }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            @if($guru->isEmpty())
                <div class="text-center py-5">
                    <i class="ti ti-users" style="font-size: 5rem; color: #e0e0e0;"></i>
                    <h5 class="mt-3 mb-2">Belum Ada Guru</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan guru pertama</p>
                    <a href="{{ route('backend.guru.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Guru
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="guruTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th>Guru</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>No. Telepon</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru as $item)
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

                                <td>
                                    <span class="text-muted">{{ $item->email }}</span>
                                </td>

                                {{-- Kelas --}}
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse($item->classes as $kelas)
                                            <span class="badge bg-primary-subtle text-primary badge-kelas">
                                                {{ $kelas->nama_kelas }}
                                            </span>
                                        @empty
                                            <span class="text-muted small">-</span>
                                        @endforelse
                                    </div>
                                </td>

                                {{-- Mapel --}}
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse($item->mapels as $mapel)
                                            <span class="badge bg-success-subtle text-success badge-mapel">
                                                {{ $mapel->nama_mapel }}
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
                                        <a href="{{ route('backend.guru.edit', $item->id) }}"
                                           class="btn btn-sm btn-warning btn-action"
                                           title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <form id="delete-form-{{ $item->id }}"
                                              action="{{ route('backend.guru.destroy', $item->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button class="btn btn-sm btn-danger btn-action"
                                                title="Hapus"
                                                onclick="confirmHapus({{ $item->id }}, '{{ $item->name }}')">
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
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const tableGuru = new DataTable('#guruTable', {
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ guru",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ total guru)",
            paginate: {
                first: "Pertama", last: "Terakhir",
                next: "Selanjutnya", previous: "Sebelumnya"
            },
            zeroRecords: "Data tidak ditemukan"
        },
        pageLength: 10,
        order: [[0, 'asc']]
    });

    // Filter kelas
    document.getElementById('filterKelasGuru').addEventListener('change', function () {
        tableGuru.column(3).search(this.value).draw();
    });

    // Konfirmasi hapus
    function confirmHapus(id, nama) {
        Swal.fire({
            title: 'Hapus Guru?',
            text: 'Yakin ingin menghapus guru ' + nama + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush