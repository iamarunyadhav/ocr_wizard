<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;

class ExtractData extends Component
{
    public $filePath;
    public $extractedText;
    public $extractedData = [];
    public $isProcessing = false;
    public $suggestions = [];

    public function mount($filePath)
    {
        $this->filePath = $filePath;
    }

    public function extractText()
    {
        $this->isProcessing = true;

        try {
            $extension = pathinfo($this->filePath, PATHINFO_EXTENSION);

            if ($extension === 'pdf') {
                $parser = new PdfParser();
                $pdf = $parser->parseFile(storage_path('app/public/' . $this->filePath));
                $this->extractedText = $pdf->getText();
            } elseif ($extension === 'docx') {
                $phpWord = WordIOFactory::load(storage_path('app/public/' . $this->filePath));
                $this->extractedText = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getElements')) {
                            foreach ($element->getElements() as $childElement) {
                                if (method_exists($childElement, 'getText')) {
                                    $this->extractedText .= $childElement->getText() . ' ';
                                }
                            }
                        } elseif (method_exists($element, 'getText')) {
                            $this->extractedText .= $element->getText() . ' ';
                        }
                    }
                }
            }

            $this->processWithAI();
        } catch (\Exception $e) {
            $this->addError('extraction', 'Extraction failed: ' . $e->getMessage());
            $this->isProcessing = false;
        }
    }

    public function processWithAI()
    {
        try {
            // Using OpenAI API (you can replace with DeepSeek API)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Extract structured fields from resume text as JSON key-value pairs (Name, Email, Phone, Skills, Experience, Education). Return only valid JSON.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $this->extractedText
                    ]
                ],
                'temperature' => 0.3
            ]);

            $data = json_decode($response->json()['choices'][0]['message']['content'], true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $this->extractedData = $data;
                $this->generateSuggestions();
            } else {
                $this->addError('ai', 'AI processing failed to return valid JSON');
            }
        } catch (\Exception $e) {
            $this->addError('ai', 'AI processing failed: ' . $e->getMessage());
        }

        $this->isProcessing = false;
    }

    public function generateSuggestions()
    {
        $this->suggestions = [
            'Certifications',
            'Languages',
            'Projects',
            'Publications',
            'Volunteer Experience'
        ];
    }

    public function addSuggestion($field)
    {
        $this->emit('addField', $field);
    }

    public function submitData()
    {
        $this->emit('dataExtracted', $this->extractedData);
    }

    public function render()
    {
        return view('livewire.extract-data');
    }
}
