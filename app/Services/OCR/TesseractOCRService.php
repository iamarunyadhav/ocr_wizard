<?php

namespace App\Services\OCR;

use thiagoalessio\TesseractOCR\TesseractOCR;
use RuntimeException;
use Illuminate\Support\Facades\Log;

class TesseractOCRService implements OCRServiceInterface
{
    protected array $supportedLanguages = ['eng'];

    public function extractText(string $filePath): string
    {
        $this->validateFile($filePath);

        try {
            $text = (new TesseractOCR($filePath))
                ->lang($this->supportedLanguages)
                ->psm(6) // Assume a single uniform block of text
                ->run();

            return $this->sanitizeOutput($text);
        } catch (\Exception $e) {
            Log::error('Tesseract OCR failed', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            throw new RuntimeException("Tesseract OCR failed: " . $e->getMessage());
        }
    }

    protected function validateFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException("File not found: {$filePath}");
        }

        // Check if file is an image (Tesseract works best with images)
        $mime = mime_content_type($filePath);
        if (!str_starts_with($mime, 'image/')) {
            Log::warning("Tesseract processing non-image file: {$mime}");
        }
    }

    protected function sanitizeOutput(string $text): string
    {
        // Normalize line endings
        $text = preg_replace('/\r\n|\r/', "\n", $text);

        // Remove excessive whitespace
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        // Ensure UTF-8 encoding
        return mb_convert_encoding(trim($text), 'UTF-8', 'UTF-8');
    }
}
