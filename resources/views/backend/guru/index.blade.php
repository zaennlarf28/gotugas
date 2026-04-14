@extends('layouts.backend')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .avatar-sm { width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid #e9ecef; }
    .table-hover tbody tr:hover { background-color: rgba(var(--bs-primary-rgb), 0.05); }
    .btn-action { transition: all 0.2s ease; }
    .btn-action:hover { transform: scale(1.05); }
    .card-stats { border-left: 4px solid var(--bs-primary); }
    .btn-export {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 0.82rem; font-weight: 600; padding: 8px 16px;
        border-radius: 8px; background: #dc3545; color: #fff; border: none;
        cursor: pointer; transition: all 0.2s ease;
    }
    .btn-export:hover { background: #bb2d3b; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,53,69,0.3); }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Data Guru</h4>
            <p class="text-muted mb-0">Kelola semua akun guru yang terdaftar</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn-export" onclick="exportPDF()">
                <i class="ti ti-file-type-pdf"></i> Export PDF
            </button>
            <a href="{{ route('backend.guru.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="ti ti-plus"></i> Tambah Guru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
            <i class="ti ti-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-stats border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width:56px;height:56px;">
                            <i class="ti ti-users fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $guru->count() }}</h3>
                            <p class="text-muted mb-0">Total Guru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="mb-3" style="max-width:300px;">
                <select id="filterKelasGuru" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->nama_kelas }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            @if($guru->isEmpty())
                <div class="text-center py-5">
                    <i class="ti ti-users" style="font-size:5rem;color:#e0e0e0;"></i>
                    <h5 class="mt-3 mb-2">Belum Ada Guru</h5>
                    <a href="{{ route('backend.guru.create') }}" class="btn btn-primary mt-2">
                        <i class="ti ti-plus me-1"></i> Tambah Guru
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="guruTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th>Guru</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>No. Telepon</th>
                                <th class="text-center no-export" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru as $item)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $item->foto_profil_url }}" class="avatar-sm" alt="{{ $item->name }}">
                                        <div>
                                            <div class="fw-semibold">{{ $item->name }}</div>
                                            @if($item->alamat)
                                                <small class="text-muted">{{ Str::limit($item->alamat, 25) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-muted">{{ $item->email }}</span></td>
                                <td>
                                    @foreach($item->classes as $kelas)
                                        <span class="badge bg-primary-subtle text-primary me-1" style="font-size:0.72rem;">{{ $kelas->nama_kelas }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($item->mapels as $mapel)
                                        <span class="badge bg-success-subtle text-success me-1" style="font-size:0.72rem;">{{ $mapel->nama_mapel }}</span>
                                    @endforeach
                                </td>
                                <td><span class="text-muted">{{ $item->no_telepon ?? '-' }}</span></td>
                                <td class="text-center no-export">
                                    <div class="btn-group">
                                        <a href="{{ route('backend.guru.edit', $item->id) }}" class="btn btn-sm btn-warning btn-action"><i class="ti ti-edit"></i></a>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('backend.guru.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                        </form>
                                        <button class="btn btn-sm btn-danger btn-action" onclick="confirmHapus({{ $item->id }}, '{{ $item->name }}')"><i class="ti ti-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script>
    const tableGuru = new DataTable('#guruTable', {
        language: { search:"Cari:", lengthMenu:"Tampilkan _MENU_ data", info:"_START_-_END_ dari _TOTAL_ guru", paginate:{next:"Selanjutnya",previous:"Sebelumnya"}, zeroRecords:"Data tidak ditemukan" },
        pageLength: 10, order: [[0,'asc']]
    });

    document.getElementById('filterKelasGuru').addEventListener('change', function () {
        tableGuru.column(3).search(this.value).draw();
    });

    function confirmHapus(id, nama) {
        Swal.fire({ title:'Hapus Guru?', text:'Yakin hapus guru '+nama+'?', icon:'warning', showCancelButton:true, confirmButtonColor:'#d33', cancelButtonColor:'#6c757d', confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal' })
        .then(r => { if(r.isConfirmed) document.getElementById('delete-form-'+id).submit(); });
    }

    function exportPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });

        doc.setFillColor(26, 107, 60);
        doc.rect(0, 0, 297, 28, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(16); doc.setFont('helvetica', 'bold');
        doc.text('Data Guru', 14, 12);
        doc.setFontSize(9); doc.setFont('helvetica', 'normal');
        doc.text('GoTugas — Platform Manajemen Tugas Sekolah', 14, 20);
        doc.text('Dicetak: ' + new Date().toLocaleDateString('id-ID', {day:'2-digit',month:'long',year:'numeric'}), 14, 26);

        const rows = [];
        document.querySelectorAll('#guruTable tbody tr').forEach((tr, i) => {
            const tds = tr.querySelectorAll('td');
            const nama = tr.querySelector('.fw-semibold')?.innerText?.trim() || '';
            const email = tds[2]?.innerText?.trim() || '';
            const kelas = tds[3]?.innerText?.trim().replace(/\s+/g,' ') || '-';
            const mapel = tds[4]?.innerText?.trim().replace(/\s+/g,' ') || '-';
            const telp  = tds[5]?.innerText?.trim() || '-';
            rows.push([i + 1, nama, email, kelas, mapel, telp]);
        });

        doc.autoTable({
            startY: 34,
            head: [['No', 'Nama Guru', 'Email', 'Kelas', 'Mapel', 'No. Telepon']],
            body: rows,
            headStyles: { fillColor:[26,107,60], textColor:255, fontStyle:'bold', fontSize:9 },
            bodyStyles: { fontSize: 8 },
            alternateRowStyles: { fillColor:[240,249,244] },
            columnStyles: {
                0: { halign:'center', cellWidth: 10 },
                1: { cellWidth: 45 },
                2: { cellWidth: 60 },
                3: { cellWidth: 35 },
                4: { cellWidth: 40 },
                5: { cellWidth: 35 },
            },
            margin: { left: 14, right: 14 },
            didDrawPage: function(data) {
                doc.setFontSize(8); doc.setTextColor(150);
                doc.text('GoTugas © ' + new Date().getFullYear(), 14, doc.internal.pageSize.height - 8);
                doc.text('Hal ' + data.pageNumber, 283, doc.internal.pageSize.height - 8, { align:'right' });
            }
        });

        doc.save('data-guru-gotugas.pdf');
    }
</script>
@endpush