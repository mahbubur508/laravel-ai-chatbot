# 🤖 Laravel AI Chatbot

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mahbub/laravel-ai-chatbot.svg?style=flat-square)](https://packagist.org/packages/mahbub/laravel-ai-chatbot)
[![Total Downloads](https://img.shields.io/packagist/dt/mahbub/laravel-ai-chatbot.svg?style=flat-square)](https://packagist.org/packages/mahbub/laravel-ai-chatbot)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

**A robust, flexible, and ultra-fast Laravel package for integrating AI Chatbots — with built-in database session history.**

Fully compatible with **OpenAI (ChatGPT)**, **Groq (Llama 3, Gemma)**, **OpenRouter**, and any other OpenAI-compatible API.

**[Features](#-features) • [Installation](#-installation) • [Usage](#-usage) • [API Reference](#-api-reference) • [License](#-license)**

---

## ✨ Features

| | |
|---|---|
| ⚡ **Multi-Provider Support** | Works with OpenAI, Groq, OpenRouter, and more — out of the box. |
| 💾 **Built-in Session History** | Auto-saves every user query and AI response to the database. |
| ⚙️ **Configurable System Prompts** | Easily set up different personalities for your chatbot. |
| 🛣️ **Pre-configured API Routes** | Ready-made endpoints for instant integration with React, Vue, or mobile apps. |

---

## 📦 Installation

### 1. Install via Composer

```bash
composer require mahbub/laravel-ai-chatbot
```

### 2. Publish the configuration file

```bash
php artisan vendor:publish --tag="ai-chatbot-config"
```

### 3. Publish & run the migrations

This creates the chat sessions and messages tables:

```bash
php artisan vendor:publish --tag="ai-chatbot-migrations"
php artisan migrate
```

### 4. Set your environment variables

Add the credentials for your preferred provider to your `.env` file.

**Option A — Official OpenAI (ChatGPT)**

```env
OPENAI_API_KEY=sk-proj-your-openai-api-key
```

**Option B — Groq (Free & Extremely Fast)**

```env
OPENAI_API_KEY=gsk_your-groq-api-key
AI_CHATBOT_API_URL=https://api.groq.com/openai/v1
AI_CHATBOT_MODEL=llama-3.3-70b-versatile
```

**Option C — OpenRouter (Multi-model Free Tier)**

```env
OPENAI_API_KEY=sk-or-v1-your-openrouter-key
AI_CHATBOT_API_URL=https://openrouter.ai/api/v1
AI_CHATBOT_MODEL=google/gemma-2-9b-it:free
```

---

## 🚀 Usage

### Using the Service (Backend Logic)

Resolve the `AiChatService` anywhere in your application — controllers, jobs, commands, etc. — to handle custom logic:

```php
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Mahbub\LaravelAiChatbot\Services\AiChatService;
use Mahbub\LaravelAiChatbot\Models\ChatSession;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(AiChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function __invoke(Request $request)
    {
        // 1. Get or create a chat session for the user
        $session = ChatSession::firstOrCreate([
            'session_id' => $request->get('session_id') ?? Str::uuid(),
        ]);

        // 2. Send the message and get the AI response (history saved automatically)
        $aiResponse = $this->chatService->sendMessage($session, $request->get('message'));

        return response()->json([
            'session_id' => $session->session_id,
            'response'   => $aiResponse,
        ]);
    }
}
```

---

## 🔌 API Reference

The package ships with a ready-to-use endpoint for instant frontend integration.

### Send a Message

```
POST /api/chatbot/send
```

**Request Body**

```json
{
    "session_id": "optional-uuid-string",
    "message": "Hello, who are you?"
}
```

**Response**

```json
{
    "success": true,
    "session_id": "generated-or-provided-uuid",
    "response": "Hello! I am your helpful AI assistant."
}
```

| Field | Type | Required | Description |
|---|---|:---:|---|
| `session_id` | `string` (UUID) | ❌ | Existing session to continue a conversation. Auto-generated if omitted. |
| `message` | `string` | ✅ | The user's message to send to the AI. |

---

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

Made with ❤️ by [Md. Mahbubur Rahman](https://github.com/mahbubur508) for the Laravel community