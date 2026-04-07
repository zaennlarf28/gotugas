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
            <h4 class="mb-0">Tambah Guru</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.guru.store') }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Guru</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" required>
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
                                               id="mapel{{ $mapel->id }}">
                                        
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
                            @foreach ($classes as $class)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="classes[]" 
                                               value="{{ $class->id }}"
                                               id="class{{ $class->id }}">
                                        
                                        <label class="form-check-label" for="class{{ $class->id }}">
                                            {{ $class->nama_kelas }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button class="btn btn-success">
                        Simpan
                    </button>
                    <a href="{{ route('backend.guru.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection