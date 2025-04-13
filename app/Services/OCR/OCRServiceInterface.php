<?php

namespace App\Services\OCR;

interface OCRServiceInterface
{
    /**
     * Extract text content from a file
     *
     * @param string $filePath Path to the file to process
     * @return string Extracted text content
     * @throws \RuntimeException If extraction fails
     */
    public function extractText(string $filePath): string;
}
