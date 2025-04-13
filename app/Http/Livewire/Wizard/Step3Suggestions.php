<?php

namespace App\Http\Livewire\Wizard;

use Livewire\Component;
use App\Services\AI\AIServiceInterface;
use App\Services\AI\PromptBuilder;

class Step3Suggestions extends Component
{
    public $fields = [];
    public $suggestions = [];
    public $selectedSuggestions = [];
    public $isProcessing = false;
    public $context = '';

    protected $listeners = ['fieldsUpdated' => 'loadFields'];

    public function loadFields($fields)
    {
        if (is_array($fields)) {
            $this->fields = $fields['fields'] ?? [];
            $this->context = $fields['context'] ?? '';
            $this->suggestions = $this->getAvailableSuggestions();
        }
    }

    protected function getAvailableSuggestions()
    {
        $suggestionMap = [
            'resume' => ['certifications', 'languages', 'publications'],
            'property' => ['amenities', 'nearby_schools', 'tax_history'],
            'hotel' => ['cancellation_policy', 'room_amenities', 'check_in_instructions'],
            'education' => ['honors', 'thesis_title', 'extracurriculars']
        ];

        return $suggestionMap[$this->context] ?? [];
    }

    public function fetchSuggestionData($suggestion)
    {
        $this->isProcessing = true;

        try {
            $aiService = app(AIServiceInterface::class);
            $response = $aiService->extractFields($this->fields['original_text'] ?? '', $this->context, $suggestion);

            $this->fields[$suggestion] = $response;
            $this->selectedSuggestions[] = $suggestion;
        } finally {
            $this->isProcessing = false;
        }
    }

    public function submit()
    {
        $this->dispatch('finalFieldsUpdated', $this->fields);
        $this->dispatch('goToStep', 4);
    }

    public function render()
    {
        return view('livewire.wizard.step3-suggestions');
    }
}
