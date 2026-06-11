<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class WorkerChatController extends Controller
{
    public function conversations(Request $request)
    {
        $user = $request->user();

        $messages = Message::where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        $conversations = $messages->groupBy(function ($msg) use ($user) {
            return $msg->sender_id === $user->id ? $msg->receiver_id : $msg->sender_id;
        })->map(function ($msgs) use ($user) {
            $latest = $msgs->first();
            $peer = $latest->sender_id === $user->id ? $latest->receiver : $latest->sender;
            $unread = $msgs->where('receiver_id', $user->id)->where('is_read', false)->count();

            return [
                'peer' => $peer,
                'latest_message' => $latest,
                'unread_count' => $unread,
            ];
        })->values();

        $unreadTotal = Message::where('receiver_id', $user->id)->where('is_read', false)->count();

        return response()->json([
            'conversations' => $conversations,
            'unread_total' => $unreadTotal,
        ]);
    }

    public function markRead(Request $request, User $customer)
    {
        Message::where('sender_id', $customer->id)
            ->where('receiver_id', $request->user()->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['message' => 'Messages marked as read.']);
    }
}
