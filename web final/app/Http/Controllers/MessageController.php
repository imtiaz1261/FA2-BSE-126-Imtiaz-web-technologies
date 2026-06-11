<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private function conversationId($userA, $userB): string
    {
        $ids = [$userA, $userB];
        sort($ids);

        return implode('_', $ids);
    }

    public function index(Request $request, $peerId)
    {
        $currentUser = $request->user();

        User::findOrFail($peerId);

        $conversationId = $this->conversationId($currentUser->id, $peerId);

        return response()->json([
            'messages' => Message::where('conversation_id', $conversationId)
                ->with(['sender', 'receiver'])
                ->orderBy('created_at')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $currentUser = $request->user();

        $data = $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'text' => ['required', 'string'],
        ]);

        $conversationId = $this->conversationId($currentUser->id, $data['receiver_id']);

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $currentUser->id,
            'receiver_id' => $data['receiver_id'],
            'text' => $data['text'],
        ]);

        return response()->json([
            'message' => 'Message sent successfully.',
            'data' => $message->load(['sender', 'receiver']),
        ], 201);
    }
}
