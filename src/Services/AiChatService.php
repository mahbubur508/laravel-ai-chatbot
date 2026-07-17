<?php

namespace Mahbub\LaravelAiChatbot\Services;

use OpenAI;
use Mahbub\LaravelAiChatbot\Models\ChatSession;

class AiChatService
{
    protected $client;

    public function __construct()
    {
        $apiKey = config('ai-chatbot.api_key');
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('OpenAI API key is missing. Please check your .env file.');
        }

        $baseUrl = config('ai-chatbot.api_url') ?: 'https://api.openai.com/v1';

        $this->client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri($baseUrl)
            ->make();
    }

    public function sendMessage(ChatSession $session, string $userMessage): string
    {
        $session->messages()->create([
            'role' => 'user',
            'content' => $userMessage
        ]);

        $messages = [
            ['role' => 'system', 'content' => config('ai-chatbot.system_prompt')]
        ];

        foreach ($session->messages as $msg) {
            $messages[] = ['role' => $msg->role, 'content' => $msg->content];
        }

        $response = $this->client->chat()->create([
            'model' => config('ai-chatbot.default_model'),
            'messages' => $messages,
        ]);

        $aiResponse = $response->choices[0]->message->content;

        $session->messages()->create([
            'role' => 'assistant',
            'content' => $aiResponse
        ]);

        return $aiResponse;
    }
}