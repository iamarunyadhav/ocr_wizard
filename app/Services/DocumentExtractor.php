<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use App\Services\OCR\OCRServiceInterface;
use App\Services\AI\AIServiceInterface;
use Illuminate\Support\Facades\Log;
use App\DTOs\ExtractedFieldDTO;

class DocumentExtractor
{
    protected Parser $pdfParser;
    protected OCRServiceInterface $ocrService;
    protected AIServiceInterface $aiService;

    public function __construct(
        Parser $pdfParser,
        OCRServiceInterface $ocrService,
        AIServiceInterface $aiService
    ) {
        $this->pdfParser = $pdfParser;
        $this->ocrService = $ocrService;
        $this->aiService = $aiService;
    }

    public function processDocument(string $filePath, string $context): array
    {
        try {
            // First try PDF text extraction
            $text = $this->extractTextFromPdf($filePath);

            // If PDF text extraction fails or returns empty, try OCR
            if (empty(trim($text))) {
                Log::info('PDF text extraction failed, falling back to OCR');
                $text = $this->ocrService->extractText($filePath);
            }

            // Clean and validate the extracted text
            $text = $this->sanitizeText($text);

            // Extract fields using AI service
            $extractedFields = $this->aiService->extractFields($text, $context);

            return [
                'original_text' => $text,
                'extracted_fields' => new ExtractedFieldDTO($extractedFields)
            ];
        } catch (\Exception $e) {
            Log::error('Document processing failed', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            throw new \RuntimeException("Failed to process document: " . $e->getMessage());
        }
    }

    protected function extractTextFromPdf(string $filePath): string
    {
        try {
            $pdf = $this->pdfParser->parseFile($filePath);
            return $pdf->getText() ?? '';
        } catch (\Exception $e) {
            Log::warning('PDF parsing failed', ['error' => $e->getMessage()]);
            return '';
        }
    }

    protected function sanitizeText(string $text): string
    {
        // Remove non-printable characters except newlines and tabs
        $text = preg_replace('/[^\x20-\x7E\x0A\x09]/', '', $text);

        // Convert to UTF-8 and ignore invalid sequences
        $text = iconv('UTF-8', 'UTF-8//IGNORE', $text);

        // Normalize line endings
        return preg_replace('/\r\n|\r/', "\n", $text);
    }
}
