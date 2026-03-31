<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Chat kelas
   public function kelasIndex($kelasId)
{
    $kelas = Auth::user()->kelas()->where('kelas.id', $kelasId)->firstOrFail();

    // Mark pesan kelas sebagai sudah dibaca
    \App\Models\Message::where('kelas_id', $kelasId)
        ->where('sender_id', '!=', Auth::id())
        ->whereNull('receiver_id')
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    $messages = Message::with('sender')
        ->where('kelas_id', $kelasId)
        ->whereNull('receiver_id')
        ->orderBy('created_at', 'asc')
        ->get();

    $siswaDiKelas = $kelas->siswa()->where('users.id', '!=', Auth::id())->get();

    return view('siswa.chat.kelas', compact('kelas', 'messages', 'siswaDiKelas'));
}

    public function kelasSend(Request $request, $kelasId)
    {
        $request->validate(['pesan' => 'required|string|max:1000']);

        // Pastikan siswa tergabung di kelas
        Auth::user()->kelas()->where('kelas.id', $kelasId)->firstOrFail();

        Message::create([
            'sender_id' => Auth::id(),
            'kelas_id'  => $kelasId,
            'pesan'     => $request->pesan,
        ]);

        return back();
    }

    // Chat DM
    public function dmIndex($userId)
    {
        $lawan = User::findOrFail($userId);

        $messages = Message::with('sender')
            ->whereNull('kelas_id')
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->where('receiver_id', Auth::id())
                  ->whereNull('kelas_id');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Daftar kontak DM (siswa sekelas)
        $kelasSaya = Auth::user()->kelas()->with('siswa')->get();
        $kontak = collect();
        foreach ($kelasSaya as $kelas) {
            $kontak = $kontak->merge($kelas->siswa->where('id', '!=', Auth::id()));
        }
        $kontak = $kontak->unique('id');

        return view('siswa.chat.dm', compact('lawan', 'messages', 'kontak'));
    }

    public function dmSend(Request $request, $userId)
    {
        $request->validate(['pesan' => 'required|string|max:1000']);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $userId,
            'pesan'       => $request->pesan,
        ]);

        return back();
    }

    // Polling — ambil pesan baru (untuk auto-refresh)
    public function pollKelas(Request $request, $kelasId)
    {
        $lastId = $request->last_id ?? 0;

        $messages = Message::with('sender')
            ->where('kelas_id', $kelasId)
            ->whereNull('receiver_id')
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'pesan'      => $m->pesan,
                'sender'     => $m->sender->name,
                'sender_id'  => $m->sender_id,
                'waktu'      => $m->created_at->diffForHumans(),
                'is_me'      => $m->sender_id === Auth::id(),
            ]);

        return response()->json($messages);
    }

    public function pollDm(Request $request, $userId)
    {
        $lastId = $request->last_id ?? 0;

        $messages = Message::with('sender')
            ->whereNull('kelas_id')
            ->where('id', '>', $lastId)
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->where('receiver_id', Auth::id())
                  ->whereNull('kelas_id')->where('id', '>', request('last_id', 0));
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'id'        => $m->id,
                'pesan'     => $m->pesan,
                'sender'    => $m->sender->name,
                'sender_id' => $m->sender_id,
                'waktu'     => $m->created_at->diffForHumans(),
                'is_me'     => $m->sender_id === Auth::id(),
            ]);

        // Mark as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }
}