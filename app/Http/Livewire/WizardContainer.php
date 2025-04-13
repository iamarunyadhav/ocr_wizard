<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\DTOs\ExtractedFieldDTO;

class WizardContainer extends Component
{
    public $currentStep = 1;
    public $documentData = [];

    protected $listeners = [
        'goToStep' => 'setCurrentStep',
        'documentProcessed' => 'handleDocumentProcessed',
        'fieldsUpdated' => 'handleFieldsUpdated',
        'finalFieldsUpdated' => 'handleFinalFieldsUpdated'
    ];

    public function setCurrentStep($step)
    {
        $this->currentStep = $step;
    }

    public function handleDocumentProcessed($data)
    {
        $this->validate([
            'data.fields' => 'array',
            'data.originalText' => 'required|string',
            'data.context' => 'required|string'
        ]);

        $this->documentData = [
            'fields' => $data['fields'],
            'originalText' => $data['originalText'],
            'context' => $data['context'],
            'file_path' => $data['file_path'] ?? null
        ];

        $this->currentStep = 2;
    }

    // public function handleDocumentProcessed(ExtractedFieldDTO $dto)
    // {
    //     $this->documentData = [
    //         'fields' => $dto->extractedFields,
    //         'originalText' => $dto->originalText,
    //         'context' => $dto->context
    //     ];
    //     $this->currentStep = 2;
    // }

    public function handleFieldsUpdated($fields)
    {
        $this->documentData['fields'] = $fields;
        $this->currentStep = 3;
    }

    public function handleFinalFieldsUpdated($fields)
    {
        $this->documentData['final_fields'] = $fields;
        $this->currentStep = 4;
    }

    public function render()
    {
        return view('livewire.wizard-container');
    }
}
