<?php

namespace App\Http\Livewire\Wizard;

use Livewire\Component;
use App\DTOs\ExtractedFieldDTO;

class Step2Review extends Component
{
    public $fields = [];
    public $originalText = '';
    public $context = '';
    public $suggestedFields = [];

    protected $listeners = ['documentProcessed' => 'loadFields'];

    public function loadFields(ExtractedFieldDTO $dto)
    {
        $this->fields = $dto->extractedFields;
        $this->originalText = $dto->originalText;
        $this->context = $dto->context;
        $this->generateSuggestions();
    }

    public function generateSuggestions()
    {
        $suggestionMap = [
            'resume' => ['certifications', 'languages', 'publications'],
            'property' => ['amenities', 'nearby_schools', 'tax_history'],
            'hotel' => ['cancellation_policy', 'room_amenities', 'check_in_instructions'],
            'education' => ['honors', 'thesis_title', 'extracurriculars']
        ];

        $this->suggestedFields = $suggestionMap[$this->context] ?? [];
    }

    public function updateField($key, $value)
    {
        data_set($this->fields, $key, $value);
    }

    public function submit()
    {
        $this->dispatch('fieldsUpdated', [
            'fields' => $this->fields,
            'originalText' => $this->originalText,
            'context' => $this->context
        ]);
        $this->dispatch('goToStep', 3);
    }

    public function render()
    {
        return view('livewire.wizard.step2-review');
    }
}
