<div>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Progress Steps -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between">
                    @foreach([1 => 'Upload', 2 => 'Extract', 3 => 'Review', 4 => 'Submit'] as $step => $label)
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                {{ $currentStep >= $step ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                {{ $step }}
                            </div>
                            <span class="mt-2 text-sm {{ $currentStep >= $step ? 'text-indigo-600 font-medium' : 'text-gray-500' }}">
                                {{ $label }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Step Content -->
            <div class="p-6">
                @if($currentStep === 1)
                    <livewire:upload-resume />
                @elseif($currentStep === 2)
                    <livewire:extract-data :filePath="$resumeFile" />
                @elseif($currentStep === 3)
                    <livewire:review-data :data="$resumeData" />
                @elseif($currentStep === 4)
                    <livewire:submit-data :data="$resumeData" :filePath="$resumeFile" />
                @endif
            </div>
        </div>
    </div>
</div>
