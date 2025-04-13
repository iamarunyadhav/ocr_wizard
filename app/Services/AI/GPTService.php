<?php

namespace App\Services\AI;

use OpenAI\Client;

class GPTService implements AIServiceInterface
{
    public function __construct(
        private Client $client,
        private PromptBuilder $promptBuilder
    ) {}

    public function extractFields(string $text, string $context): array
    {
        $prompt = $this->promptBuilder->build($context, $text);

        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [['role' => 'user', 'content' => $prompt]],
            'temperature' => 0.3,
        ]);

        return json_decode($response->choices[0]->message->content, true) ?? [];
    }
}
