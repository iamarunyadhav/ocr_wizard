<?php

namespace App\Services\OCR;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use RuntimeException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleVisionOCRService implements OCRServiceInterface
{
    protected string $credentialsPath;
    protected int $maxFileSize = 10485760; // 10MB

    public function __construct()
    {
        $this->credentialsPath = config('services.google_cloud.key_file');

        if (!file_exists($this->credentialsPath)) {
            throw new RuntimeException(
                "Google Vision credentials not found at: {$this->credentialsPath}"
            );
        }
    }

    public function extractText(string $filePath): string
    {
        $this->validateFile($filePath);

        try {
            $client = new ImageAnnotatorClient([
                'credentials' => $this->credentialsPath,
                'transportConfig' => [
                    'grpc' => [
                        'stubOpts' => [
                            'grpc.max_receive_message_length' => $this->maxFileSize
                        ]
                    ]
                ]
            ]);

            $image = file_get_contents($filePath);
            $response = $client->documentTextDetection($image);
            $annotation = $response->getFullTextAnnotation();
            $client->close();

            if (!$annotation) {
                Log::warning('Google Vision returned no text annotation');
                return '';
            }

            $text = $annotation->getText();
            return $this->sanitizeOutput($text);
        } catch (\Exception $e) {
            Log::error('Google Vision OCR failed', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            throw new RuntimeException("Google Vision OCR failed: " . $e->getMessage());
        }
    }

    protected function validateFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException("File not found: {$filePath}");
        }

        if (filesize($filePath) > $this->maxFileSize) {
            throw new RuntimeException(
                "File size exceeds maximum limit of " .
                ($this->maxFileSize / 1024 / 1024) . "MB"
            );
        }
    }

    protected function sanitizeOutput(string $text): string
    {
        // Remove non-UTF-8 characters
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

        // Remove any remaining invalid characters
        return iconv('UTF-8', 'UTF-8//IGNORE', $text);
    }
}
