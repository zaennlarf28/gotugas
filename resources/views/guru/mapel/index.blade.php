@extends('layouts.guru')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .content-wrapper {
        margin-top: 30px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid content-wrapper">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
            <h5 class="mb-0 fw-semibold">📘 Daftar Mata Pelajaran</h5>
            <a href="{{ route('guru.mapel.create') }}" class="btn btn-sm btn-primary rounded-pill">
                <i class="bi bi-plus-circle me-1"></i> Tambah Mata Pelajaran
            </a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="mapelTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Nama Mata Pelajaran</th>
                            <th style="width:25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mapel as $i => $m)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $m->mata_pelajaran }}</strong></td>
                            <td>
                                <a href="{{ route('guru.mapel.edit', $m->id) }}" class="btn btn-sm btn-warning rounded-pill me-1 mb-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('guru.mapel.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-pill mb-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Belum ada mata pelajaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function () {
        $('#mapelTable').DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false
        });
    });
</script>
@endpush
