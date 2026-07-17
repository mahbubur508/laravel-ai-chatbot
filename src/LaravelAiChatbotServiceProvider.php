<?php

namespace Mahbub\LaravelAiChatbot;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAiChatbotServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-ai-chatbot')
            ->hasConfigFile('ai-chatbot')
            ->hasMigrations(['create_chat_sessions_table', 'create_chat_messages_table'])
            ->hasRoutes('api');
    }
}