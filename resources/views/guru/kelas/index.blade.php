@extends('layouts.guru')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .content-wrapper {
        margin-top: 30px;
    }
    .btn-copy {
        background: #f1f1f1;
        border: none;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 0.8rem;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid content-wrapper">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
            <h5 class="mb-0 fw-semibold">📚 Daftar Kelas</h5>
            <a href="{{ route('guru.kelas.create') }}" class="btn btn-sm btn-primary rounded-pill">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kelas
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="kelasTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Kode Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->nama_kelas }}</strong></td>
                            <td>{{ $item->mataPelajaran->mata_pelajaran ?? '-' }}</td>
                            <td>{{ $item->guru->name ?? '-' }}</td>
                            <td>
                                <span id="kode_{{ $item->id }}" class="text-success">{{ $item->kode_kelas }}</span>
                                <button class="btn-copy" onclick="copyKode({{ $item->id }})">Copy</button>
                            </td>
                            <td>
                                <a href="{{ route('guru.kelas.edit', $item->id) }}" class="btn btn-sm btn-warning rounded-pill mb-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('guru.kelas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill mb-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
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
        $('#kelasTable').DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false
        });
    });

    function copyKode(id) {
        const text = document.getElementById('kode_' + id).innerText;
        navigator.clipboard.writeText(text).then(function () {
            alert('Kode berhasil disalin!');
        });
    }
</script>
@endpush
