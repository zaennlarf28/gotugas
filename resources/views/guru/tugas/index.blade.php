@extends('layouts.guru')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<style>
    .deadline-badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
    }
    .deadline-urgent  { background: linear-gradient(135deg, #ff6b6b, #ee5a6f); }
    .deadline-soon    { background: linear-gradient(135deg, #ffd93d, #f6c23e); }
    .deadline-normal  { background: linear-gradient(135deg, #6bcf7f, #57b969); }

    .table-hover tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.03);
        transition: all 0.2s ease;
    }

    /* ── Notif badge pengumpulan baru ── */
    .notif-new {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: linear-gradient(135deg, #e53935, #ef5350);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 50px;
        box-shadow: 0 2px 8px rgba(229,57,53,0.35);
        animation: popIn 0.35s cubic-bezier(0.34,1.56,0.64,1) both;
        white-space: nowrap;
    }
    @keyframes popIn {
        from { opacity:0; transform: scale(0.7); }
        to   { opacity:1; transform: scale(1); }
    }
    .notif-new .bi { font-size: 0.65rem; }

    /* ── Row highlight kalau ada pengumpulan baru ── */
    tr.has-new-submission {
        background-color: rgba(229, 57, 53, 0.04) !important;
        border-left: 3px solid #e53935;
    }

    /* ── Tugas card kelas ── */
    .kelas-name { font-weight: 600; }
    .mapel-badge {
        font-size: 0.72rem;
        padding: 3px 8px;
    }

    .btn-action { font-size: 0.875rem; padding: 0.375rem 0.75rem; }

    .dropdown-kelas { max-height: 300px; overflow-y: auto; }

    /* ── Stat cards ── */
    .stat-card { border: none; transition: all 0.25s ease; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Daftar Tugas</h4>
            <p class="text-muted mb-0">Kelola semua tugas di kelas Anda</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2"
                    type="button" data-bs-toggle="dropdown">
                <i class="ti ti-plus"></i> Tambah Tugas Baru
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-kelas shadow">
                @forelse($kelas as $item)
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2"
                           href="{{ route('guru.tugas.create', ['kelas' => $item->id]) }}">
                            <i class="ti ti-chalkboard me-2"></i>
                            <div>
                                <div class="fw-semibold">{{ $item->nama_kelas }}</div>
                                <small class="text-muted">{{ $item->mapel->nama_mapel }}</small>
                            </div>
                        </a>
                    </li>
                    @if(!$loop->last)<li><hr class="dropdown-divider"></li>@endif
                @empty
                    <li class="px-3 py-2 text-muted">
                        <i class="ti ti-alert-circle me-1"></i> Belum ada kelas
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="ti ti-check fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="row mb-4">
        @php
            $totalTugas = 0;
            $totalPengumpulan = 0;
            $totalBelumDinilai = 0;
            $totalBaru = 0; // pengumpulan yang belum dilihat (dikirim hari ini atau terbaru)

            foreach($kelas as $item) {
                $totalTugas += $item->tugas->count();
                foreach($item->tugas as $tgs) {
                    $totalPengumpulan  += $tgs->pengumpulan->count();
                    $totalBelumDinilai += $tgs->pengumpulan->whereNull('nilai')->count();
                    // "Baru" = dikirim dalam 24 jam terakhir & belum dinilai
                    $totalBaru += $tgs->pengumpulan
                        ->where('created_at', '>=', now()->subHours(24))
                        ->whereNull('nilai')
                        ->count();
                }
            }
        @endphp

        <div class="col-md-3 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="ti ti-clipboard-list"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $totalTugas }}</h3>
                        <small class="text-muted">Total Tugas</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="ti ti-send"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $totalPengumpulan }}</h3>
                        <small class="text-muted">Total Pengumpulan</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="ti ti-hourglass"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $totalBelumDinilai }}</h3>
                        <small class="text-muted">Belum Dinilai</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="ti ti-bell-ringing"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $totalBaru }}</h3>
                        <small class="text-muted">Pengumpulan Baru</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Banner notif global kalau ada pengumpulan baru --}}
    @if($totalBaru > 0)
        <div class="alert d-flex align-items-center gap-3 mb-4 rounded-3 shadow-sm"
             style="background:#fff5f5;border:1.5px solid rgba(229,57,53,0.25);" role="alert">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(229,57,53,0.12);
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="ti ti-bell-ringing text-danger fs-4"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="text-danger">Ada {{ $totalBaru }} pengumpulan baru!</strong><br>
                <small class="text-muted">Dikirim dalam 24 jam terakhir dan belum dinilai. Cek baris yang ditandai merah di bawah.</small>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Main Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            @php
                $hasTugas = false;
                foreach($kelas as $item) {
                    if($item->tugas->isNotEmpty()) { $hasTugas = true; break; }
                }
            @endphp

            @if(!$hasTugas)
                <div class="text-center py-5">
                    <i class="ti ti-clipboard-off" style="font-size:5rem;color:#e0e0e0;"></i>
                    <h5 class="mt-3 mb-2">Belum Ada Tugas</h5>
                    <p class="text-muted mb-4">Mulai dengan membuat tugas pertama untuk kelas Anda</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tugasTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th><i class="ti ti-chalkboard me-1"></i>Kelas</th>
                                <th><i class="ti ti-file-text me-1"></i>Judul Tugas</th>
                                <th><i class="ti ti-calendar me-1"></i>Deadline</th>
                                <th class="text-center">Pengumpulan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($kelas as $item)
                                @foreach ($item->tugas as $tugas)
                                @php
                                    $deadline   = \Carbon\Carbon::parse($tugas->deadline);
                                    $now        = \Carbon\Carbon::now();
                                    $diffDays   = $now->diffInDays($deadline, false);

                                    if ($diffDays < 0)       { $badgeClass = 'deadline-urgent'; $badgeText = 'Terlewat'; }
                                    elseif ($diffDays <= 2)  { $badgeClass = 'deadline-urgent'; $badgeText = 'Mendesak'; }
                                    elseif ($diffDays <= 7)  { $badgeClass = 'deadline-soon';   $badgeText = 'Segera'; }
                                    else                     { $badgeClass = 'deadline-normal';  $badgeText = 'Normal'; }

                                    $jumlahMasuk    = $tugas->pengumpulan->count();
                                    $belumDinilai   = $tugas->pengumpulan->whereNull('nilai')->count();
                                    $sudahDinilai   = $tugas->pengumpulan->whereNotNull('nilai')->count();

                                    // Pengumpulan baru = dikirim < 24 jam & belum dinilai
                                    $pengumpulanBaru = $tugas->pengumpulan
                                        ->where('created_at', '>=', now()->subHours(24))
                                        ->whereNull('nilai')
                                        ->count();
                                @endphp
                                <tr class="{{ $pengumpulanBaru > 0 ? 'has-new-submission' : '' }}">
                                    <td class="text-center fw-semibold text-muted">{{ $no++ }}</td>

                                    {{-- Kelas --}}
                                    <td>
                                        <div class="kelas-name">{{ $item->nama_kelas }}</div>
                                        <span class="badge bg-info-subtle text-info mapel-badge">
                                            {{ $item->mapel->nama_mapel }}
                                        </span>
                                    </td>

                                    {{-- Judul + notif baru --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-semibold">{{ $tugas->judul }}</span>
                                            @if($pengumpulanBaru > 0)
                                                <span class="notif-new">
                                                    <i class="bi bi-bell-fill"></i>
                                                    {{ $pengumpulanBaru }} baru
                                                </span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ Str::limit($tugas->perintah, 45) }}</small>
                                    </td>

                                    {{-- Deadline --}}
                                    <td>
                                        <span class="badge {{ $badgeClass }} text-white deadline-badge">
                                            {{ $badgeText }}
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $deadline->translatedFormat('d M Y, H:i') }}
                                        </small>
                                    </td>

                                    {{-- Pengumpulan counter --}}
                                    <td class="text-center">
                                        @if($jumlahMasuk > 0)
                                            <div class="d-flex flex-column align-items-center gap-1">
                                                <span class="badge bg-primary rounded-pill px-3">
                                                    {{ $jumlahMasuk }} masuk
                                                </span>
                                                @if($belumDinilai > 0)
                                                    <span class="badge bg-warning text-dark rounded-pill px-3">
                                                        {{ $belumDinilai }} belum dinilai
                                                    </span>
                                                @endif
                                                @if($sudahDinilai > 0)
                                                    <span class="badge bg-success rounded-pill px-3">
                                                        {{ $sudahDinilai }} dinilai
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted small">Belum ada</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        @if($pengumpulanBaru > 0)
                                            <span class="badge bg-danger">
                                                <i class="ti ti-bell me-1"></i>Ada Baru
                                            </span>
                                        @elseif($belumDinilai > 0)
                                            <span class="badge bg-warning text-dark">
                                                <i class="ti ti-clock me-1"></i>Perlu Dinilai
                                            </span>
                                        @elseif($jumlahMasuk > 0)
                                            <span class="badge bg-success">
                                                <i class="ti ti-check me-1"></i>Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="ti ti-minus me-1"></i>Kosong
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            <a href="{{ route('guru.tugas.pengumpulan', $tugas->id) }}"
                                               class="btn btn-sm btn-info btn-action"
                                               title="Lihat Pengumpulan">
                                                <i class="ti ti-folder-open me-1"></i>
                                                Pengumpulan
                                                @if($pengumpulanBaru > 0)
                                                    <span class="badge bg-white text-danger ms-1">
                                                        {{ $pengumpulanBaru }}
                                                    </span>
                                                @endif
                                            </a>
                                            <a href="{{ route('guru.tugas.edit', $tugas->id) }}"
                                               class="btn btn-sm btn-warning btn-action"
                                               title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('guru.tugas.destroy', $tugas->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus tugas {{ $tugas->judul }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger btn-action"
                                                        title="Hapus">
                                                    <i class="ti ti-trash"></i>
                                                </button>
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
<script>
    $(document).ready(function() {
        $('#tugasTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ tugas",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ total tugas)",
                paginate: {
                    first: "Pertama", last: "Terakhir",
                    next: "Selanjutnya", previous: "Sebelumnya"
                },
                zeroRecords: "Data tidak ditemukan"
            },
            pageLength: 10,
            order: [[3, 'asc']] // sort by deadline
        });
    });
</script>
@endpush