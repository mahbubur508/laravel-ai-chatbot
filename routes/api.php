<?php

use Illuminate\Support\Facades\Route;
use Mahbub\LaravelAiChatbot\Http\Controllers\ChatbotController;

Route::prefix(config('ai-chatbot.route_prefix'))
    ->middleware(config('ai-chatbot.middleware'))
    ->group(function () {
        Route::post('/send', [ChatbotController::class, 'handleChat']);
    });