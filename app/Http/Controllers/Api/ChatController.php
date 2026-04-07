<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ===== KELAS MESSAGES =====
    public function kelasMessages(Request $request, $kelasId)
    {
        $request->user()->kelas()->where('kelas.id', $kelasId)->firstOrFail();

        Message::where('kelas_id', $kelasId)
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::with(['sender', 'replyTo.sender'])
            ->where('kelas_id', $kelasId)
            ->whereNull('receiver_id')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => $this->formatMessage($m, $request->user()->id));

        return response()->json(['messages' => $messages]);
    }

    // ===== KIRIM PESAN KELAS =====
    public function kelasSend(Request $request, $kelasId)
    {
        $request->validate(['pesan' => 'required|string|max:1000']);
        $request->user()->kelas()->where('kelas.id', $kelasId)->firstOrFail();

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'kelas_id'  => $kelasId,
            'pesan'     => $request->pesan,
        ]);

        return response()->json([
            'message' => 'Pesan terkirim',
            'data'    => [
                'id'    => $message->id,
                'pesan' => $message->pesan,
                'waktu' => $message->created_at->format('H:i'),
            ],
        ], 201);
    }

    // ===== POLL KELAS =====
    public function pollKelas(Request $request, $kelasId)
    {
        $lastId = $request->last_id ?? 0;

        $messages = Message::with(['sender', 'replyTo.sender'])
            ->where('kelas_id', $kelasId)
            ->whereNull('receiver_id')
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => $this->formatMessage($m, $request->user()->id));

        // Mark as read
        Message::where('kelas_id', $kelasId)
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['messages' => $messages]);
    }

    // ===== BALAS PESAN KELAS =====
    public function balasPesanKelas(Request $request, $kelasId)
    {
        $request->validate([
            'pesan'    => 'required|string|max:1000',
            'reply_to' => 'required|exists:messages,id',
        ]);

        $request->user()->kelas()->where('kelas.id', $kelasId)->firstOrFail();

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'kelas_id'  => $kelasId,
            'pesan'     => $request->pesan,
            'reply_to'  => $request->reply_to,
        ]);

        return response()->json([
            'message' => 'Pesan terkirim',
            'data'    => [
                'id'    => $message->id,
                'pesan' => $message->pesan,
                'waktu' => $message->created_at->format('H:i'),
            ],
        ], 201);
    }

    // ===== DM MESSAGES =====
    public function dmMessages(Request $request, $userId)
    {
        Message::where('sender_id', $userId)
            ->where('receiver_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::with(['sender', 'replyTo.sender'])
            ->whereNull('kelas_id')
            ->where(function ($q) use ($userId, $request) {
                $q->where('sender_id', $request->user()->id)
                  ->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($userId, $request) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $request->user()->id)
                  ->whereNull('kelas_id');
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => $this->formatMessage($m, $request->user()->id));

        return response()->json(['messages' => $messages]);
    }

    // ===== KIRIM DM =====
    public function dmSend(Request $request, $userId)
    {
        $request->validate(['pesan' => 'required|string|max:1000']);

        $message = Message::create([
            'sender_id'   => $request->user()->id,
            'receiver_id' => $userId,
            'pesan'       => $request->pesan,
        ]);

        return response()->json([
            'message' => 'Pesan terkirim',
            'data'    => [
                'id'    => $message->id,
                'pesan' => $message->pesan,
                'waktu' => $message->created_at->format('H:i'),
            ],
        ], 201);
    }

    // ===== POLL DM =====
    public function pollDm(Request $request, $userId)
    {
        $lastId = $request->last_id ?? 0;

        $messages = Message::with(['sender', 'replyTo.sender'])
            ->whereNull('kelas_id')
            ->where('id', '>', $lastId)
            ->where(function ($q) use ($userId, $request) {
                $q->where('sender_id', $request->user()->id)
                  ->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($userId, $request) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $request->user()->id)
                  ->whereNull('kelas_id')
                  ->where('id', '>', request('last_id', 0));
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => $this->formatMessage($m, $request->user()->id));

        // Mark as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['messages' => $messages]);
    }

    // ===== BALAS DM =====
    public function balasPesanDm(Request $request, $userId)
    {
        $request->validate([
            'pesan'    => 'required|string|max:1000',
            'reply_to' => 'required|exists:messages,id',
        ]);

        $message = Message::create([
            'sender_id'   => $request->user()->id,
            'receiver_id' => $userId,
            'pesan'       => $request->pesan,
            'reply_to'    => $request->reply_to,
        ]);

        return response()->json([
            'message' => 'Pesan terkirim',
            'data'    => [
                'id'    => $message->id,
                'pesan' => $message->pesan,
                'waktu' => $message->created_at->format('H:i'),
            ],
        ], 201);
    }

    // ===== EDIT PESAN =====
    public function editPesan(Request $request, $id)
    {
        $request->validate(['pesan' => 'required|string|max:1000']);

        $message = Message::findOrFail($id);

        if ($message->sender_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $message->update(['pesan' => $request->pesan]);

        return response()->json([
            'message' => 'Pesan diperbarui',
            'data'    => [
                'id'    => $message->id,
                'pesan' => $message->pesan,
            ],
        ]);
    }

    // ===== HAPUS PESAN =====
    public function hapusPesan(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json(['message' => 'Pesan dihapus']);
    }

    // ===== HELPER FORMAT MESSAGE =====
    private function formatMessage($m, $userId): array
    {
        return [
            'id'        => $m->id,
            'pesan'     => $m->pesan,
            'sender'    => $m->sender?->name,
            'sender_id' => $m->sender_id,
            'is_me'     => $m->sender_id === $userId,
            'waktu'     => $m->created_at->format('H:i'),
            'tanggal'   => $m->created_at->format('d M Y'),
            'reply_to'  => $m->replyTo ? [
                'id'     => $m->replyTo->id,
                'pesan'  => $m->replyTo->pesan,
                'sender' => $m->replyTo->sender?->name,
            ] : null,
        ];
    }
}