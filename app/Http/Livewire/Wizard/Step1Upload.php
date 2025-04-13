<?php

namespace App\Http\Livewire\Wizard;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\DocumentExtractor;
use App\DTOs\ExtractedFieldDTO;

class Step1Upload extends Component
{
    use WithFileUploads;

    public $file;
    public $context = 'resume';
    public $availableContexts = [
        'resume' => 'Resume/CV',
        'property' => 'Property Document',
        'hotel' => 'Hotel Booking',
        'education' => 'Education Document'
    ];
    public $isUploading = false;
    public $error = null;

    protected $rules = [
        'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        'context' => 'required|in:resume,property,hotel,education'
    ];

    public function save()
{
    $this->validate();
    $this->isUploading = true;
    $this->error = null;

    try {
        $path = $this->file->store('documents');
        $extractor = app(DocumentExtractor::class);

        $result = $extractor->processDocument(storage_path("app/$path"), $this->context);

        if (!isset($result['original_text'])) {
            throw new \Exception("Document processing failed - no text extracted");
        }

        $this->dispatch('documentProcessed', [
            'fields' => $result['extracted_fields'] ?? [],
            'originalText' => $result['original_text'],
            'context' => $this->context,
            'file_path' => $path
        ]);

    } catch (\Exception $e) {
        $this->error = "Failed to process document: " . $e->getMessage();
        $this->isUploading = false;
        logger()->error('Document processing error', ['error' => $e->getMessage()]);
    }
}

    public function render()
    {
        return view('livewire.wizard.step1-upload');
    }
}
