<?php

namespace App\Http\Controllers;

use App\Models\AiConversation;
use App\Services\AiService;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    public function __construct(private AiService $aiService) {}

    public function history(Request $request)
    {
        $sessionId = $this->sessionId($request);

        $history = AiConversation::where('user_id', $request->user()->id)
            ->where('session_id', $sessionId)
            ->orderBy('created_at')
            ->get();

        $suggestedPrompts = $this->suggestedPrompts($request->user()->role);

        return response()->json([
            'history' => $history,
            'suggested_prompts' => $suggestedPrompts,
            'session_id' => $sessionId,
        ]);
    }

    public function chat(Request $request)
    {
        $data = $request->validate([
            'message' => ['required_without:messages', 'string', 'max:1000'],
            'messages' => ['sometimes', 'array'],
            'messages.*.role' => ['required_with:messages', 'in:user,assistant'],
            'messages.*.content' => ['required_with:messages', 'string'],
            'session_id' => ['nullable', 'string', 'max:100'],
        ]);

        $user = $request->user();
        $sessionId = $this->sessionId($request);

        if (! empty($data['message'])) {
            AiConversation::create([
                'user_id' => $user->id,
                'session_id' => $sessionId,
                'role' => 'user',
                'content' => $data['message'],
            ]);
        }

        $history = AiConversation::where('user_id', $user->id)
            ->where('session_id', $sessionId)
            ->orderBy('created_at')
            ->take(10)
            ->get()
            ->map(fn ($m) => ['role' => $m->role, 'content' => $m->content])
            ->toArray();

        if (empty($history) && ! empty($data['messages'])) {
            $history = $data['messages'];
        }

        try {
            $aiReply = $this->aiService->chat($history);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }

        AiConversation::create([
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'role' => 'assistant',
            'content' => $aiReply,
        ]);

        return response()->json([
            'reply' => $aiReply,
            'timestamp' => now()->format('h:i A'),
        ]);
    }

    public function clearHistory(Request $request)
    {
        $sessionId = $request->query('session_id') ?? $this->sessionId($request);

        AiConversation::where('user_id', $request->user()->id)
            ->where('session_id', $sessionId)
            ->delete();

        return response()->json(['status' => 'cleared']);
    }

    private function sessionId(Request $request): string
    {
        return $request->input('session_id')
            ?? $request->header('X-AI-Session')
            ?? 'default';
    }

    private function suggestedPrompts(string $role): array
    {
        if ($role === 'worker') {
            return [
                'How should I price my electrical services?',
                'Tips for getting better customer reviews',
                'How do I respond to booking requests quickly?',
                'What makes a great worker profile?',
            ];
        }

        return [
            'Find me an electrician for home wiring',
            'What services do plumbers offer?',
            'Help me choose between two workers',
            'How do I book a service?',
            "What's a fair price for AC repair?",
            "I need urgent help — who's available now?",
        ];
    }
}
