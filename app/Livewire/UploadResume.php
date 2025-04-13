<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class UploadResume extends Component
{
    use WithFileUploads;

    #[Rule('required|file|mimes:pdf,docx|max:10240')]
    public $file;

    public $isUploading = false;

    public function upload()
    {
        $this->validate();

        $this->isUploading = true;

        try {
            $path = $this->file->store('resumes', 'public');
            $this->dispatch('fileUploaded', path: $path);
        } catch (\Exception $e) {
            $this->addError('file', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->isUploading = false;
        }
    }

    public function render()
    {
        return view('livewire.upload-resume');
    }
}
