<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resume;

class SubmitData extends Component
{
    public $resumeData;
    public $filePath;
    public $isSubmitting = false;
    public $isSuccess = false;

    public function mount($data, $filePath)
    {
        $this->resumeData = $data;
        $this->filePath = $filePath;
    }

    public function submit()
    {
        $this->isSubmitting = true;

        try {
            Resume::create([
                'name' => $this->resumeData['name'] ?? '',
                'email' => $this->resumeData['email'] ?? '',
                'phone' => $this->resumeData['phone'] ?? '',
                'skills' => $this->resumeData['skills'] ?? [],
                'experience' => $this->resumeData['experience'] ?? [],
                'education' => $this->resumeData['education'] ?? [],
                'raw_data' => $this->resumeData,
                'file_path' => $this->filePath,
            ]);

            $this->isSuccess = true;
        } catch (\Exception $e) {
            $this->addError('submission', 'Submission failed: ' . $e->getMessage());
            $this->isSubmitting = false;
        }
    }

    public function render()
    {
        return view('livewire.submit-data');
    }
}
