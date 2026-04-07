@extends('layouts.backend')

@section('styles')
<style>
    .form-check {
        padding: 8px 12px;
        border-radius: 8px;
        transition: 0.2s;
    }

    .form-check:hover {
        background: rgba(0,0,0,0.05);
    }

    .section-box {
        border: 1px solid #eaeaea;
        border-radius: 10px;
        padding: 15px;
        max-height: 250px;
        overflow-y: auto;
    }
</style>
@endsection

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

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ $guru->name }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ $guru->email }}" required>
                </div>

                <!-- MAPEL -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Mata Pelajaran</label>
                    <div class="section-box">
                        <div class="row">
                            @foreach ($mapels as $mapel)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="mapels[]"
                                               value="{{ $mapel->id }}"
                                               id="mapel{{ $mapel->id }}"
                                               {{ $guru->mapels->contains($mapel->id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="mapel{{ $mapel->id }}">
                                            {{ $mapel->nama_mapel }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- KELAS -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Kelas</label>
                    <div class="section-box">
                        <div class="row">
                            @foreach ($classes as $kelas)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="classes[]"
                                               value="{{ $kelas->id }}"
                                               id="class{{ $kelas->id }}"
                                               {{ $guru->classes->contains($kelas->id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="class{{ $kelas->id }}">
                                            {{ $kelas->nama_kelas }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button class="btn btn-warning">Update</button>
                    <a href="{{ route('backend.guru.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection