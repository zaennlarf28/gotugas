@extends('layouts.guru')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .deadline-badge { font-size:0.85rem;padding:0.4rem 0.8rem; }
    .deadline-urgent  { background:linear-gradient(135deg,#ff6b6b,#ee5a6f); }
    .deadline-soon    { background:linear-gradient(135deg,#ffd93d,#f6c23e); }
    .deadline-normal  { background:linear-gradient(135deg,#6bcf7f,#57b969); }
    .table-hover tbody tr:hover { background-color: rgba(var(--bs-primary-rgb), 0.03); }
    .btn-action { font-size:0.875rem;padding:0.375rem 0.75rem; }
    .notif-new {
        display:inline-flex;align-items:center;gap:5px;
        background:linear-gradient(135deg,#e53935,#ef5350);
        color:#fff;font-size:0.7rem;font-weight:700;
        padding:3px 9px;border-radius:50px;
        box-shadow:0 2px 8px rgba(229,57,53,0.35);
        white-space:nowrap;animation:popIn 0.35s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes popIn { from{opacity:0;transform:scale(0.7)} to{opacity:1;transform:scale(1)} }
    tr.has-new-submission { background-color:rgba(229,57,53,0.04)!important;border-left:3px solid #e53935; }
    .stat-card { border:none;transition:all 0.25s ease; }
    .stat-card:hover { transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,0.1); }
    .stat-icon { width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.3rem; }
    .btn-export {
        display:inline-flex;align-items:center;gap:6px;
        font-size:0.82rem;font-weight:600;padding:8px 16px;
        border-radius:8px;background:#dc3545;color:#fff;border:none;
        cursor:pointer;transition:all 0.2s ease;
    }
    .btn-export:hover { background:#bb2d3b;transform:translateY(-1px);box-shadow:0 4px 12px rgba(220,53,69,0.3); }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Daftar Tugas</h4>
            <p class="text-muted mb-0">Kelola semua tugas di kelas Anda</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn-export" onclick="exportPDF()">
                <i class="ti ti-file-type-pdf"></i> Export PDF
            </button>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="ti ti-plus"></i> Tambah Tugas Baru
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" style="max-height:300px;overflow-y:auto;">
                    @forelse($kelas as $item)
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('guru.tugas.create', ['kelas' => $item->id]) }}">
                                <i class="ti ti-chalkboard me-2"></i>
                                <div>
                                    <div class="fw-semibold">{{ $item->nama_kelas }}</div>
                                    <small class="text-muted">{{ $item->mapel->nama_mapel }}</small>
                                </div>
                            </a>
                        </li>
                        @if(!$loop->last)<li><hr class="dropdown-divider"></li>@endif
                    @empty
                        <li class="px-3 py-2 text-muted"><small>Belum ada kelas</small></li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
            <i class="ti ti-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="row mb-4">
        @php
            $totalTugas = 0; $totalPengumpulan = 0; $totalBelumDinilai = 0; $totalBaru = 0;
            foreach($kelas as $item) {
                $totalTugas += $item->tugas->count();
                foreach($item->tugas as $tgs) {
                    $totalPengumpulan  += $tgs->pengumpulan->count();
                    $totalBelumDinilai += $tgs->pengumpulan->whereNull('nilai')->count();
                    $totalBaru += $tgs->pengumpulan->where('created_at','>=',now()->subHours(24))->whereNull('nilai')->count();
                }
            }
        @endphp
        @foreach([
            ['icon'=>'ti-clipboard-list','color'=>'primary','val'=>$totalTugas,'label'=>'Total Tugas'],
            ['icon'=>'ti-send','color'=>'success','val'=>$totalPengumpulan,'label'=>'Total Pengumpulan'],
            ['icon'=>'ti-hourglass','color'=>'warning','val'=>$totalBelumDinilai,'label'=>'Belum Dinilai'],
            ['icon'=>'ti-bell-ringing','color'=>'danger','val'=>$totalBaru,'label'=>'Pengumpulan Baru'],
        ] as $s)
        <div class="col-md-3 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-{{ $s['color'] }}-subtle text-{{ $s['color'] }}">
                        <i class="ti {{ $s['icon'] }}"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $s['val'] }}</h3>
                        <small class="text-muted">{{ $s['label'] }}</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($totalBaru > 0)
        <div class="alert d-flex align-items-center gap-3 mb-4 rounded-3 shadow-sm" style="background:#fff5f5;border:1.5px solid rgba(229,57,53,0.25);">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(229,57,53,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="ti ti-bell-ringing text-danger fs-4"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="text-danger">Ada {{ $totalBaru }} pengumpulan baru!</strong><br>
                <small class="text-muted">Dikirim dalam 24 jam terakhir dan belum dinilai.</small>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @php $hasTugas = false; foreach($kelas as $item) { if($item->tugas->isNotEmpty()) { $hasTugas = true; break; } } @endphp
            @if(!$hasTugas)
                <div class="text-center py-5">
                    <i class="ti ti-clipboard-off" style="font-size:5rem;color:#e0e0e0;"></i>
                    <h5 class="mt-3 mb-2">Belum Ada Tugas</h5>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tugasTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th>Kelas</th>
                                <th>Judul Tugas</th>
                                <th>Deadline</th>
                                <th class="text-center">Pengumpulan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center no-export" width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($kelas as $item)
                                @foreach($item->tugas as $tugas)
                                @php
                                    $deadline = \Carbon\Carbon::parse($tugas->deadline);
                                    $diff = now()->diffInDays($deadline, false);
                                    $badgeClass = $diff < 0 || $diff <= 2 ? 'deadline-urgent' : ($diff <= 7 ? 'deadline-soon' : 'deadline-normal');
                                    $badgeText  = $diff < 0 ? 'Terlewat' : ($diff <= 2 ? 'Mendesak' : ($diff <= 7 ? 'Segera' : 'Normal'));
                                    $jumlahMasuk  = $tugas->pengumpulan->count();
                                    $belumDinilai = $tugas->pengumpulan->whereNull('nilai')->count();
                                    $sudahDinilai = $tugas->pengumpulan->whereNotNull('nilai')->count();
                                    $pengBaru     = $tugas->pengumpulan->where('created_at','>=',now()->subHours(24))->whereNull('nilai')->count();
                                @endphp
                                <tr class="{{ $pengBaru > 0 ? 'has-new-submission' : '' }}">
                                    <td class="text-center fw-semibold text-muted">{{ $no++ }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->nama_kelas }}</div>
                                        <span class="badge bg-info-subtle text-info" style="font-size:0.72rem;">{{ $item->mapel->nama_mapel }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">{{ $tugas->judul }}</span>
                                            @if($pengBaru > 0)
                                                <span class="notif-new"><i class="bi bi-bell-fill" style="font-size:0.65rem;"></i> {{ $pengBaru }} baru</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ Str::limit($tugas->perintah, 45) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $badgeClass }} text-white deadline-badge">{{ $badgeText }}</span><br>
                                        <small class="text-muted">{{ $deadline->translatedFormat('d M Y, H:i') }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if($jumlahMasuk > 0)
                                            <span class="badge bg-primary rounded-pill px-2 d-block mb-1">{{ $jumlahMasuk }} masuk</span>
                                            @if($belumDinilai > 0)<span class="badge bg-warning text-dark rounded-pill px-2 d-block mb-1">{{ $belumDinilai }} belum</span>@endif
                                            @if($sudahDinilai > 0)<span class="badge bg-success rounded-pill px-2 d-block">{{ $sudahDinilai }} dinilai</span>@endif
                                        @else
                                            <span class="text-muted small">Belum ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($pengBaru > 0)
                                            <span class="badge bg-danger"><i class="ti ti-bell me-1"></i>Ada Baru</span>
                                        @elseif($belumDinilai > 0)
                                            <span class="badge bg-warning text-dark"><i class="ti ti-clock me-1"></i>Perlu Dinilai</span>
                                        @elseif($jumlahMasuk > 0)
                                            <span class="badge bg-success"><i class="ti ti-check me-1"></i>Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">Kosong</span>
                                        @endif
                                    </td>
                                    <td class="no-export">
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            <a href="{{ route('guru.tugas.pengumpulan', $tugas->id) }}" class="btn btn-sm btn-info btn-action">
                                                <i class="ti ti-folder-open me-1"></i>Pengumpulan
                                                @if($pengBaru > 0)<span class="badge bg-white text-danger ms-1">{{ $pengBaru }}</span>@endif
                                            </a>
                                            <a href="{{ route('guru.tugas.edit', $tugas->id) }}" class="btn btn-sm btn-warning btn-action"><i class="ti ti-edit"></i></a>
                                            <form action="{{ route('guru.tugas.destroy', $tugas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus tugas {{ $tugas->judul }}?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger btn-action"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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
        $('#tugasTable').DataTable({
            language: { search:"Cari:", lengthMenu:"Tampilkan _MENU_ data", info:"_START_-_END_ dari _TOTAL_ tugas", paginate:{next:"Selanjutnya",previous:"Sebelumnya"}, zeroRecords:"Data tidak ditemukan" },
            pageLength: 10, order: [[3,'asc']]
        });
    });

    function exportPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });

        doc.setFillColor(26, 107, 60);
        doc.rect(0, 0, 297, 28, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(16); doc.setFont('helvetica', 'bold');
        doc.text('Rekap Tugas', 14, 12);
        doc.setFontSize(9); doc.setFont('helvetica', 'normal');
        doc.text('GoTugas — Platform Manajemen Tugas Sekolah', 14, 20);
        doc.text('Dicetak: ' + new Date().toLocaleDateString('id-ID', {day:'2-digit',month:'long',year:'numeric'}), 14, 26);

        const rows = [];
        document.querySelectorAll('#tugasTable tbody tr').forEach((tr, i) => {
            const tds = tr.querySelectorAll('td');
            const kelas   = tds[1]?.querySelector('.fw-semibold')?.innerText?.trim() || '';
            const mapel   = tds[1]?.querySelector('.badge')?.innerText?.trim() || '';
            const judul   = tds[2]?.querySelector('.fw-semibold')?.innerText?.trim() || '';
            const deadline = tds[3]?.querySelector('small')?.innerText?.trim() || '';
            const masuk   = tds[4]?.querySelector('.bg-primary')?.innerText?.replace('masuk','').trim() || '0';
            const status  = tds[5]?.querySelector('.badge')?.innerText?.trim() || '-';
            rows.push([i + 1, kelas + '\n' + mapel, judul, deadline, masuk, status]);
        });

        doc.autoTable({
            startY: 34,
            head: [['No', 'Kelas', 'Judul Tugas', 'Deadline', 'Masuk', 'Status']],
            body: rows,
            headStyles: { fillColor:[26,107,60], textColor:255, fontStyle:'bold', fontSize:9 },
            bodyStyles: { fontSize: 8 },
            alternateRowStyles: { fillColor:[240,249,244] },
            columnStyles: {
                0: { halign:'center', cellWidth:10 },
                1: { cellWidth:40 },
                2: { cellWidth:70 },
                3: { cellWidth:45 },
                4: { halign:'center', cellWidth:18 },
                5: { halign:'center', cellWidth:35 },
            },
            margin: { left:14, right:14 },
            didDrawPage: function(data) {
                doc.setFontSize(8); doc.setTextColor(150);
                doc.text('GoTugas © ' + new Date().getFullYear(), 14, doc.internal.pageSize.height - 8);
                doc.text('Hal ' + data.pageNumber, 283, doc.internal.pageSize.height - 8, { align:'right' });
            }
        });

        doc.save('rekap-tugas-gotugas.pdf');
    }
</script>
@endpush