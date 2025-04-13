<?php

namespace App\DTOs;

class ExtractedFieldDTO
{
    public function __construct(
        public readonly string $originalText,
        public readonly array $extractedFields,
        public readonly string $context
    ) {}
}
