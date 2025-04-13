<?php

namespace App\Livewire;

use Livewire\Component;

class ReviewData extends Component
{
    public $resumeData;

    protected $rules = [
        'resumeData.name' => 'required|string|max:255',
        'resumeData.email' => 'required|email',
        'resumeData.phone' => 'nullable|string',
    ];

    public function mount($data)
    {
        $this->resumeData = $data;
    }

    public function submit()
    {
        $this->validate();
        $this->emit('reviewCompleted');
    }

    public function render()
    {
        return view('livewire.review-data');
    }
}
