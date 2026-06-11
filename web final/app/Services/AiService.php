<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiService
{
    private const SYSTEM_PROMPT = <<<'PROMPT'
You are LocalPro AI, a friendly and knowledgeable assistant for the LocalPro services marketplace. You help customers find the right local professionals, explain services, assist with booking decisions, answer questions about workers, and provide helpful advice about home services.

You have knowledge of these service categories:
Electrician, Plumber, Tutor, Cleaner, Carpenter, Painter, AC Technician, Driver.

When a user asks about a service, suggest relevant categories and explain what workers in that category can help with. Be concise, friendly, and helpful.
If unsure about specific worker availability, suggest they browse the Services page.

Respond in a conversational tone. Use bullet points only when listing multiple items.
Keep responses under 200 words unless detailed explanation is needed.
PROMPT;

    public function chat(array $messages): string
    {
        $provider = config('services.ai.provider', 'gemini');

        return $provider === 'anthropic'
            ? $this->chatAnthropic($messages)
            : $this->chatGemini($messages);
    }

    private function chatGemini(array $messages): string
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-2.5-flash');

        if (! $apiKey || $apiKey === 'your_new_key_here') {
            throw new \RuntimeException(
                'Gemini API key is missing. Set GEMINI_API_KEY in backend/.env'
            );
        }

        $contents = [];
        foreach ($messages as $message) {
            if (empty($message['content'])) {
                continue;
            }
            $contents[] = [
                'role' => $message['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => trim($message['content'])]],
            ];
        }

        while (! empty($contents) && $contents[0]['role'] === 'model') {
            array_shift($contents);
        }

        if (empty($contents)) {
            throw new \RuntimeException('No valid messages to send.');
        }

        $response = Http::timeout(60)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
            [
                'systemInstruction' => ['parts' => [['text' => self::SYSTEM_PROMPT]]],
                'contents' => $contents,
            ]
        );

        if ($response->failed()) {
            $message = $response->json('error.message') ?? 'AI service unavailable.';
            throw new \RuntimeException($message);
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (! $text) {
            throw new \RuntimeException('No response received from AI service.');
        }

        return $text;
    }

    private function chatAnthropic(array $messages): string
    {
        $apiKey = config('services.anthropic.key');

        if (! $apiKey) {
            throw new \RuntimeException('Anthropic API key is missing. Set ANTHROPIC_API_KEY in .env');
        }

        $response = Http::timeout(60)
            ->withHeaders([
                'x-api-key' => $apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => config('services.anthropic.model', 'claude-sonnet-4-20250514'),
                'max_tokens' => (int) config('services.anthropic.max_tokens', 1000),
                'system' => self::SYSTEM_PROMPT,
                'messages' => array_map(fn ($m) => [
                    'role' => $m['role'],
                    'content' => $m['content'],
                ], $messages),
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('AI service unavailable. Please try again.');
        }

        $text = $response->json('content.0.text');

        if (! $text) {
            throw new \RuntimeException('No response received from AI service.');
        }

        return $text;
    }
}
