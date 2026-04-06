@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Siswa</h4>
            <a href="{{ route('backend.siswa.create') }}" class="btn btn-sm btn-outline-primary">
                + Tambah Siswa
            </a>
        </div>

        <div class="card-body">

            {{-- 🔥 FILTER KELAS --}}
            <div class="mb-3" style="max-width: 300px;">
                <label class="form-label">Filter Kelas</label>
                <select id="filterKelas" class="form-control">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->nama_kelas }}">
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="siswaTable">
                    <thead>
                        <tr>
                            <th width="50">No</th>
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

                            {{-- 🔥 PENTING: kasih data kelas untuk filter --}}
                            <td>
                                @foreach($item->classes as $kelas)
                                    <span class="badge bg-primary">{{ $kelas->nama_kelas }}</span>
                                @endforeach
                            </td>

                            <td>
                                <a href="{{ route('backend.siswa.edit', $item->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <button class="btn btn-sm btn-danger"
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
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const table = new DataTable('#siswaTable');

    // 🔥 FILTER FUNCTION
    document.getElementById('filterKelas').addEventListener('change', function () {
        let value = this.value;

        if (value) {
            table.column(3).search(value).draw(); // kolom kelas = index 3
        } else {
            table.column(3).search('').draw();
        }
    });

    function confirmDeleteSiswa(url) {
        Swal.fire({
            title: 'Hapus Data!',
            text: 'Yakin hapus siswa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya',
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