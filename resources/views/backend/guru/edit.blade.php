@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Guru</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.guru.update', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ $guru->name }}" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ $guru->email }}" required>
                </div>

                <div class="mb-3">
                    <label>Kelas</label>
                    <select name="classes[]" class="form-control" multiple required>
                        @foreach($classes as $kelas)
                            <option value="{{ $kelas->id }}"
                                @selected($guru->classes->contains($kelas->id))>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Mata Pelajaran</label>
                    <select name="mapels[]" class="form-control" multiple required>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}"
                                @selected($guru->mapels->contains($mapel->id))>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">Update</button>
                <a href="{{ route('backend.guru.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection