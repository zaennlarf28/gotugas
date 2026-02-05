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

                            <form action="{{ route('backend.siswa.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  data-confirm-delete="true">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
