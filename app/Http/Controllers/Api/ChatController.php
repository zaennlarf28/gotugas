<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Pesan kelas
    public function kelasMessages(Request $request, $kelasId)
    {
        $request->user()->kelas()->where('kelas.id', $kelasId)->firstOrFail();

        // Mark as read
        Message::where('kelas_id', $kelasId)
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::with('sender')
            ->where('kelas_id', $kelasId)
            ->whereNull('receiver_id')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'id'        => $m->id,
                'pesan'     => $m->pesan,
                'sender'    => $m->sender?->name,
                'sender_id' => $m->sender_id,
                'is_me'     => $m->sender_id === $request->user()->id,
                'waktu'     => $m->created_at->format('H:i'),
                'tanggal'   => $m->created_at->format('d M Y'),
            ]);

        return response()->json(['messages' => $messages]);
    }

    // Kirim pesan kelas
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
                'id'     => $message->id,
                'pesan'  => $message->pesan,
                'waktu'  => $message->created_at->format('H:i'),
            ],
        ], 201);
    }

    // Pesan DM
    public function dmMessages(Request $request, $userId)
    {
        Message::where('sender_id', $userId)
            ->where('receiver_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::with('sender')
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
            ->map(fn($m) => [
                'id'        => $m->id,
                'pesan'     => $m->pesan,
                'sender'    => $m->sender?->name,
                'sender_id' => $m->sender_id,
                'is_me'     => $m->sender_id === $request->user()->id,
                'waktu'     => $m->created_at->format('H:i'),
                'tanggal'   => $m->created_at->format('d M Y'),
            ]);

        return response()->json(['messages' => $messages]);
    }

    // Kirim DM
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
}