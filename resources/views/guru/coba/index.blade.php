@extends('layouts.guru') {{-- ganti dengan layout yang kamu pakai --}}

@section('content')
<div class="container mt-4">
    <h4>Data Tugas yang Sudah Dinilai</h4>

    @if($coba->isEmpty())
        <div class="alert alert-info">Belum ada tugas yang dinilai.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Status</th>
                    <th>Nilai</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coba as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->nilai ?? '-' }}</td>
                        <td>
                            @if($item->file)
                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank">Lihat File</a>
                            @else
                                Tidak ada file
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
