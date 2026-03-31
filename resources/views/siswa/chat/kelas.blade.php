@extends('layouts.frontend')

@section('content')
<div class="container mt-4">
    <div class="mb-3">
        <a href="{{ route('siswa.kelas.show', $kelas->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-3">
        {{-- Sidebar kontak DM --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header fw-bold">
                    <i class="bi bi-people me-1"></i> Siswa di Kelas
                </div>
                <div class="list-group list-group-flush rounded-bottom-4">
                    @forelse($siswaDiKelas as $s)
                        <a href="{{ route('siswa.chat.dm', $s->id) }}"
                           class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                 style="width:32px;height:32px;font-size:0.8rem;">
                                {{ strtoupper(substr($s->name, 0, 1)) }}
                            </div>
                            <span>{{ $s->name }}</span>
                        </a>
                    @empty
                        <div class="p-3 text-muted small">Belum ada siswa lain.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Area chat kelas --}}
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header d-flex align-items-center gap-2 fw-bold">
                    <i class="bi bi-chat-dots text-primary"></i>
                    Diskusi Kelas — {{ $kelas->nama_kelas }}
                </div>

                {{-- Pesan --}}
                <div class="card-body p-3" id="chatBox"
                     style="height:420px; overflow-y:auto; display:flex; flex-direction:column; gap:8px;">
                    @foreach($messages as $msg)
                        @php $isMe = $msg->sender_id === Auth::id(); @endphp
                        <div class="d-flex {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="px-3 py-2 rounded-3 shadow-sm"
                                 style="max-width:70%; background: {{ $isMe ? '#0d6efd' : '#f1f3f5' }}; color: {{ $isMe ? '#fff' : '#000' }};">
                                @if(!$isMe)
                                    <div class="fw-bold small mb-1">{{ $msg->sender->name }}</div>
                                @endif
                                <div>{{ $msg->pesan }}</div>
                                <div class="text-end mt-1" style="font-size:0.7rem; opacity:0.7;">
                                    {{ $msg->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Form kirim --}}
                <div class="card-footer p-3">
                    <form action="{{ route('siswa.chat.kelas.send', $kelas->id) }}" method="POST"
                          class="d-flex gap-2" id="formChat">
                        @csrf
                        <input type="text" name="pesan" id="inputPesan"
                               class="form-control rounded-pill"
                               placeholder="Tulis pesan..." autocomplete="off" required>
                        <button type="submit" class="btn btn-primary rounded-pill px-3">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const chatBox = document.getElementById('chatBox');
    const myId = {{ Auth::id() }};
    let lastId = {{ $messages->last()?->id ?? 0 }};
    const pollUrl = "{{ route('siswa.chat.kelas.poll', $kelas->id) }}";

    // Scroll ke bawah
    function scrollBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    scrollBottom();

    // Render bubble baru
    function renderBubble(msg) {
        const isMe = msg.sender_id === myId;
        const div = document.createElement('div');
        div.className = `d-flex ${isMe ? 'justify-content-end' : 'justify-content-start'}`;
        div.innerHTML = `
            <div class="px-3 py-2 rounded-3 shadow-sm"
                 style="max-width:70%; background:${isMe ? '#0d6efd' : '#f1f3f5'}; color:${isMe ? '#fff' : '#000'};">
                ${!isMe ? `<div class="fw-bold small mb-1">${msg.sender}</div>` : ''}
                <div>${msg.pesan}</div>
                <div class="text-end mt-1" style="font-size:0.7rem; opacity:0.7;">${msg.waktu}</div>
            </div>
        `;
        chatBox.appendChild(div);
        scrollBottom();
    }

    // Polling tiap 3 detik
    setInterval(() => {
        fetch(`${pollUrl}?last_id=${lastId}`)
            .then(r => r.json())
            .then(msgs => {
                msgs.forEach(msg => {
                    renderBubble(msg);
                    lastId = msg.id;
                });
            });
    }, 3000);
</script>
@endpush