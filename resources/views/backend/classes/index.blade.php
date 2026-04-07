@extends('layouts.backend')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.05);
        transition: all 0.2s ease;
    }

    .card-stats {
        border-left: 4px solid var(--bs-primary);
    }

    .btn-action {
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Data Kelas</h4>
            <p class="text-muted mb-0">Kelola semua kelas yang tersedia</p>
        </div>
        <a href="{{ route('backend.classes.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="ti ti-plus"></i>
            Tambah Kelas
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

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-stats border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width:56px;height:56px;">
                                <i class="ti ti-school fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $classes->count() }}</h3>
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

            @if($classes->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="ti ti-school" style="font-size: 5rem; color: #e0e0e0;"></i>
                    </div>
                    <h5 class="mb-2">Belum Ada Kelas</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan kelas pertama</p>
                    <a href="{{ route('backend.classes.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Kelas
                    </a>
                </div>
            @else
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="classTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="60">No</th>
                                <th><i class="ti ti-door me-1"></i>Nama Kelas</th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $item)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center me-2 bg-primary-subtle text-primary rounded" style="width:36px;height:36px;">
                                            <i class="ti ti-users"></i>
                                        </div>
                                        <span class="fw-semibold">{{ $item->nama_kelas }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('backend.classes.edit', $item) }}"
                                           class="btn btn-sm btn-warning btn-action"
                                           title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('backend.classes.destroy', $item) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kelas {{ $item->nama_kelas }}?')">
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
        $('#classTable').DataTable({
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
</script>
@endpush