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
            <h5 class="mb-0 fw-semibold">📝 Daftar Tugas di Semua Kelas</h5>
            <div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown">
                    Tambah Tugas
                </button>
                <ul class="dropdown-menu">
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

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tugasTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Judul</th>
                            <th>Perintah</th>
                            <th>Deskripsi</th>
                            <th>Deadline</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($kelas as $item)
                            @foreach ($item->tugas as $tugas)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><strong>{{ $item->nama_kelas }}</strong></td>
                                <td>{{ $tugas->judul }}</td>
                                <td>{{ $tugas->perintah }}</td>
                                <td>{{ $tugas->deskripsi }}</td>
                                <td>{{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M Y') }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($tugas->tipe) }}</span></td>
                                <td>
                                    <a href="{{ route('guru.tugas.edit', $tugas->id) }}" class="btn btn-sm btn-warning rounded-pill mb-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="{{ route('guru.tugas.pengumpulan', $tugas->id) }}" class="btn btn-sm btn-info rounded-pill mb-1">
                                        <i class="bi bi-folder2-open"></i> Pengumpulan
                                    </a>
                                    <form action="{{ route('guru.tugas.destroy', $tugas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill mb-1">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
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
        $('#tugasTable').DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false
        });
    });
</script>
@endpush
