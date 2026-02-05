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

                            <form action="{{ route('backend.guru.destroy', $item->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus guru?')"
                                        class="btn btn-danger btn-sm">
                                    Hapus
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
@endsection
