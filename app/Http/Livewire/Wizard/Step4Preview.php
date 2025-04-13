<?php

namespace App\Http\Livewire\Wizard;

use Livewire\Component;
use App\Models\Document;

class Step4Preview extends Component
{
    public $fields = [];
    public $isSaving = false;
    public $saveSuccess = false;

    protected $listeners = ['finalFieldsUpdated' => 'loadFields'];

    public function loadFields($fields)
    {
        $this->fields = $fields;
    }

    public function saveDocument()
    {
        $this->isSaving = true;

        try {
            Document::create([
                'context' => $this->fields['context'] ?? 'resume',
                'original_text' => $this->fields['original_text'] ?? '',
                'extracted_fields' => $this->fields,
                'metadata' => [
                    'processor' => config('services.ai.default'),
                    'ocr_engine' => config('services.ocr.default')
                ]
            ]);

            $this->saveSuccess = true;
        } finally {
            $this->isSaving = false;
        }
    }

    public function render()
    {
        return view('livewire.wizard.step4-preview');
    }
}
