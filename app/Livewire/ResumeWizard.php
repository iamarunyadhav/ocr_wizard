<?php

namespace App\Livewire;

use Livewire\Component;

class ResumeWizard extends Component
{
    public $currentStep = 1;
    public $resumeData = [];
    public $resumeFile;

    protected $listeners = [
        'fileUploaded' => 'handleFileUploaded',
        'dataExtracted' => 'handleDataExtracted',
        'reviewCompleted' => 'handleReviewCompleted',
        'previousStep' => 'goToPreviousStep'
    ];

    public function handleFileUploaded($filePath)
    {
        $this->resumeFile = $filePath;
        $this->currentStep = 2;
    }

    public function handleDataExtracted($data)
    {
        $this->resumeData = $data;
        $this->currentStep = 3;
    }

    public function handleReviewCompleted()
    {
        $this->currentStep = 4;
    }

    public function goToPreviousStep()
    {
        $this->currentStep--;
    }

    public function render()
    {
        return view('livewire.resume-wizard');
    }
}
