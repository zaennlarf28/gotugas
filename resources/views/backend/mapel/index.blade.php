@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Mapel</h4>
            <a href="{{ route('backend.mapel.create') }}" class="btn btn-sm btn-outline-primary">
                + Tambah Mapel
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="mapelTable">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Mapel</th>
                            <th>Kode Mapel</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapel as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_mapel }}</td>
                            <td>{{ $item->kode_mapel }}</td>
                            <td>
                                <a href="{{ route('backend.mapel.edit', $item) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('backend.mapel.destroy', $item) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
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
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('#mapelTable');
</script>
@endpush
