@extends('layouts.frontend')

@section('content')
<div class="container mt-4">
    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-3">
        {{-- Sidebar kontak --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header fw-bold">
                    <i class="bi bi-chat-left-text me-1"></i> Pesan
                </div>
                <div class="list-group list-group-flush rounded-bottom-4">
                    @forelse($kontak as $k)
                        <a href="{{ route('siswa.chat.dm', $k->id) }}"
                           class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2
                                  {{ $k->id == $lawan->id ? 'active' : '' }}">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                 style="width:32px;height:32px;font-size:0.8rem;">
                                {{ strtoupper(substr($k->name, 0, 1)) }}
                            </div>
                            <span>{{ $k->name }}</span>
                        </a>
                    @empty
                        <div class="p-3 text-muted small">Belum ada kontak.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Area DM --}}
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header d-flex align-items-center gap-2 fw-bold">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                         style="width:32px;height:32px;">
                        {{ strtoupper(substr($lawan->name, 0, 1)) }}
                    </div>
                    {{ $lawan->name }}
                </div>

                <div class="card-body p-3" id="chatBox"
                     style="height:420px; overflow-y:auto; display:flex; flex-direction:column; gap:8px;">
                    @foreach($messages as $msg)
                        @php $isMe = $msg->sender_id === Auth::id(); @endphp
                        <div class="d-flex {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="px-3 py-2 rounded-3 shadow-sm"
                                 style="max-width:70%; background:{{ $isMe ? '#0d6efd' : '#f1f3f5' }}; color:{{ $isMe ? '#fff' : '#000' }};">
                                <div>{{ $msg->pesan }}</div>
                                <div class="text-end mt-1" style="font-size:0.7rem; opacity:0.7;">
                                    {{ $msg->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card-footer p-3">
                    <form action="{{ route('siswa.chat.dm.send', $lawan->id) }}" method="POST"
                          class="d-flex gap-2">
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
    const pollUrl = "{{ route('siswa.chat.dm.poll', $lawan->id) }}";

    function scrollBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    scrollBottom();

    function renderBubble(msg) {
        const isMe = msg.sender_id === myId;
        const div = document.createElement('div');
        div.className = `d-flex ${isMe ? 'justify-content-end' : 'justify-content-start'}`;
        div.innerHTML = `
            <div class="px-3 py-2 rounded-3 shadow-sm"
                 style="max-width:70%; background:${isMe ? '#0d6efd' : '#f1f3f5'}; color:${isMe ? '#fff' : '#000'};">
                <div>${msg.pesan}</div>
                <div class="text-end mt-1" style="font-size:0.7rem; opacity:0.7;">${msg.waktu}</div>
            </div>
        `;
        chatBox.appendChild(div);
        scrollBottom();
    }

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