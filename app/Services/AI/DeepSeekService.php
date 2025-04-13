<?php

namespace App\Services\AI;

class DeepSeekService implements AIServiceInterface
{
    public function __construct(
        private string $apiKey,
        private PromptBuilder $promptBuilder
    ) {}

    public function extractFields(string $text, string $context): array
    {
        $prompt = $this->promptBuilder->build($context, $text);

        // Implementation for DeepSeek API
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://api.deepseek.com/v1/chat/completions', [
            'headers' => ['Authorization' => 'Bearer ' . $this->apiKey],
            'json' => [
                'model' => 'deepseek-vl',
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'temperature' => 0.3,
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        return json_decode($data['choices'][0]['message']['content'], true) ?? [];
    }
}
