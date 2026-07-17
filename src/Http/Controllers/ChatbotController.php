<?php

namespace Mahbub\LaravelAiChatbot\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mahbub\LaravelAiChatbot\Models\ChatSession;
use Mahbub\LaravelAiChatbot\Services\AiChatService;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    protected $aiService;

    public function __construct(AiChatService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function handleChat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string',
            'session_token' => 'required|string',
        ]);

        $session = ChatSession::firstOrCreate([
            'session_token' => $request->session_token,
            'user_id' => auth()->id() ?? null
        ]);

        try {
            $reply = $this->aiService->sendMessage($session, $request->message);

            return response()->json([
                'success' => true,
                'reply' => $reply
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}