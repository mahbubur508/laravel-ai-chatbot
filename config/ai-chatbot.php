<?php

return [
    'api_key' => env('OPENAI_API_KEY'),
    'api_url' => env('AI_CHATBOT_API_URL', 'https://api.openai.com/v1'), 
    'default_model' => env('AI_CHATBOT_MODEL', 'gpt-4o-mini'),
    'system_prompt' => 'You are a helpful and polite customer support AI assistant.',
    'route_prefix' => 'api/chatbot',
    'middleware' => ['api'],
];