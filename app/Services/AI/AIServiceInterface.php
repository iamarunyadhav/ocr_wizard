<?php

namespace App\Services\AI;

interface AIServiceInterface
{
    public function extractFields(string $text, string $context): array;
}
