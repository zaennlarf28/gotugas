@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Data Siswa</h4>
            <a href="{{ route('backend.siswa.create') }}" class="btn btn-primary btn-sm">
                + Tambah Siswa
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $item)
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
    <a href="{{ route('backend.siswa.edit', $item->id) }}"
       class="btn btn-warning btn-sm">Edit</a>

    <button class="btn btn-danger btn-sm"
            onclick="confirmDeleteSiswa('{{ route('backend.siswa.destroy', $item->id) }}')">
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
@push('scripts')
<script>
function confirmDeleteSiswa(url) {
    Swal.fire({
        title: 'Hapus Data!',
        text: 'Apakah Anda yakin ingin menghapus siswa ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
