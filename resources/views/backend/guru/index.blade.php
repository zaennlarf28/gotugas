@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Guru</h4>
            <a href="{{ route('backend.guru.create') }}" class="btn btn-sm btn-outline-primary">
                + Tambah Guru
            </a>
        </div>

        <div class="card-body">

            {{-- 🔥 FILTER KELAS --}}
            <div class="mb-3" style="max-width: 300px;">
                <label class="form-label">Filter Kelas</label>
                <select id="filterKelasGuru" class="form-control">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->nama_kelas }}">
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="guruTable">
                    <thead>
                        <tr>
                            <th width="50">No</th>
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
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form id="delete-form-{{ $item->id }}"
                                      action="{{ route('backend.guru.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button class="btn btn-sm btn-danger"
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
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const tableGuru = new DataTable('#guruTable');

    // 🔥 FILTER KELAS
    document.getElementById('filterKelasGuru').addEventListener('change', function () {
        let value = this.value;

        if (value) {
            tableGuru.column(3).search(value).draw(); // kolom kelas
        } else {
            tableGuru.column(3).search('').draw();
        }
    });

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