<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OCR\OCRServiceInterface;
use App\Services\OCR\TesseractOCRService;
use App\Services\OCR\GoogleVisionOCRService;
use App\Services\AI\AIServiceInterface;
use App\Services\AI\GPTService;
use App\Services\AI\DeepSeekService;
use App\Services\AI\PromptBuilder;
use OpenAI\Client as OpenAIClient;

class ServiceBinderProvider extends ServiceProvider
{
    public function register()
    {
        // OCR Service Binding
        $this->app->bind(OCRServiceInterface::class, function ($app) {
            return match(config('services.ocr.default')) {
                'google_vision' => new GoogleVisionOCRService(
                    config('services.google_vision.credentials')
                ),
                default => new TesseractOCRService(),
            };
        });

        // AI Service Binding
        $this->app->bind(AIServiceInterface::class, function ($app) {
            return match(config('services.ai.default')) {
                'gpt' => new GPTService(
                    $app->make(OpenAIClient::class),
                    $app->make(PromptBuilder::class)
                ),
                'deepseek' => new DeepSeekService(
                    config('services.deepseek.api_key'),
                    $app->make(PromptBuilder::class)
                ),
                default => throw new \RuntimeException('No AI service configured'),
            };
        });

        // OpenAI Client
        $this->app->singleton(OpenAIClient::class, function () {
            return \OpenAI::client(config('services.openai.api_key'));
        });

        $this->app->bind(OCRServiceInterface::class, function ($app) {
            return match (config('ocr.default')) {
                'google_vision' => new GoogleVisionOCRService(),
                default => new TesseractOCRService(),
            };
        });
    }

    public function boot()
    {
        //
    }
}
