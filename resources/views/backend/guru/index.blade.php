@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Data Guru</h4>
            <a href="{{ route('backend.guru.create') }}" class="btn btn-primary btn-sm">
                + Tambah Guru
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guru as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            @foreach($item->classes as $kelas)
                                <span class="badge bg-primary">{{ $kelas->nama_kelas }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($item->mapels as $mapel)
                                <span class="badge bg-success">{{ $mapel->nama_mapel }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('backend.guru.edit', $item->id) }}"
                               class="btn btn-warning btn-sm">Edit</a>

                            {{-- Ganti form lama dengan button SweetAlert --}}
                            <form id="delete-form-{{ $item->id }}"
                                  action="{{ route('backend.guru.destroy', $item->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button class="btn btn-danger btn-sm"
                                    onclick="confirmHapus({{ $item->id }})">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmHapus(id) {
    Swal.fire({
        title: 'Hapus Data!',
        text: 'Apakah Anda yakin ingin menghapus guru ini?',
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