@extends('layouts.backend')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .table-hover tbody tr:hover { background-color: rgba(var(--bs-primary-rgb), 0.05); transition: all 0.2s ease; }
    .btn-action { transition: all 0.2s ease; }
    .btn-action:hover { transform: scale(1.05); }
    .card-stats { border-left: 4px solid var(--bs-primary); }
    .btn-export {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 0.82rem; font-weight: 600;
        padding: 8px 16px; border-radius: 8px;
        background: #dc3545; color: #fff; border: none;
        cursor: pointer; transition: all 0.2s ease;
    }
    .btn-export:hover { background: #bb2d3b; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,53,69,0.3); }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Data Kelas</h4>
            <p class="text-muted mb-0">Kelola semua kelas yang tersedia</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn-export" onclick="exportPDF()">
                <i class="ti ti-file-type-pdf"></i> Export PDF
            </button>
            <a href="{{ route('backend.classes.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="ti ti-plus"></i> Tambah Kelas
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
                            <i class="ti ti-school fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $classes->count() }}</h3>
                            <p class="text-muted mb-0">Total Kelas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($classes->isEmpty())
                <div class="text-center py-5">
                    <i class="ti ti-school" style="font-size:5rem;color:#e0e0e0;"></i>
                    <h5 class="mt-3 mb-2">Belum Ada Kelas</h5>
                    <a href="{{ route('backend.classes.create') }}" class="btn btn-primary mt-2">
                        <i class="ti ti-plus me-1"></i> Tambah Kelas
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="classTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="60">No</th>
                                <th>Nama Kelas</th>
                                <th class="text-center no-export" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $item)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center me-2 bg-primary-subtle text-primary rounded" style="width:36px;height:36px;">
                                            <i class="ti ti-users"></i>
                                        </div>
                                        <span class="fw-semibold">{{ $item->nama_kelas }}</span>
                                    </div>
                                </td>
                                <td class="text-center no-export">
                                    <div class="btn-group">
                                        <a href="{{ route('backend.classes.edit', $item) }}" class="btn btn-sm btn-warning btn-action"><i class="ti ti-edit"></i></a>
                                        <form action="{{ route('backend.classes.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kelas {{ $item->nama_kelas }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger btn-action"><i class="ti ti-trash"></i></button>
                                        </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script>
    $(document).ready(function () {
        $('#classTable').DataTable({
            language: {
                search: "Cari:", lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ kelas",
                paginate: { next: "Selanjutnya", previous: "Sebelumnya" },
                zeroRecords: "Data tidak ditemukan"
            },
            pageLength: 10, order: [[0, 'asc']]
        });
    });

    function exportPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });

        doc.setFillColor(26, 107, 60);
        doc.rect(0, 0, 210, 28, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(16);
        doc.setFont('helvetica', 'bold');
        doc.text('Data Kelas', 14, 12);
        doc.setFontSize(9);
        doc.setFont('helvetica', 'normal');
        doc.text('GoTugas — Platform Manajemen Tugas Sekolah', 14, 20);
        doc.text('Dicetak: ' + new Date().toLocaleDateString('id-ID', {day:'2-digit',month:'long',year:'numeric'}), 14, 26);

        const rows = [];
        document.querySelectorAll('#classTable tbody tr').forEach((tr, i) => {
            const tds = tr.querySelectorAll('td');
            rows.push([ i + 1, tds[1]?.innerText?.trim() || '' ]);
        });

        doc.autoTable({
            startY: 34,
            head: [['No', 'Nama Kelas']],
            body: rows,
            headStyles: { fillColor: [26, 107, 60], textColor: 255, fontStyle: 'bold', fontSize: 10 },
            bodyStyles: { fontSize: 9 },
            alternateRowStyles: { fillColor: [240, 249, 244] },
            columnStyles: { 0: { halign: 'center', cellWidth: 15 } },
            margin: { left: 14, right: 14 },
            didDrawPage: function(data) {
                doc.setFontSize(8); doc.setTextColor(150);
                doc.text('GoTugas © ' + new Date().getFullYear(), 14, doc.internal.pageSize.height - 8);
                doc.text('Hal ' + data.pageNumber, 196, doc.internal.pageSize.height - 8, { align: 'right' });
            }
        });

        doc.save('data-kelas-gotugas.pdf');
    }
</script>
@endpush