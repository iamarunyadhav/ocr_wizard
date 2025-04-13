<div>
    <div class="text-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Submit Your Resume</h2>
        <p class="text-gray-600">Final step to save your information</p>
    </div>

    @if($isSuccess)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="mt-3 text-lg font-medium text-gray-900">Success!</h3>
                <div class="mt-2 text-sm text-gray-500">
                    <p>Your resume information has been successfully saved.</p>
                </div>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Start Over
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Preview</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="font-medium text-gray-800">{{ $resumeData['name'] ?? '' }}</h4>
                        <p class="text-sm text-gray-600">{{ $resumeData['email'] ?? '' }} | {{ $resumeData['phone'] ?? '' }}</p>

                        @if(!empty($resumeData['skills']))
                            <div class="mt-3">
                                <h5 class="text-sm font-medium text-gray-700">Skills</h5>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($resumeData['skills'] as $skill)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-between">
                    <button wire:click="$emit('previousStep')"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Back
                    </button>
                    <button wire:click="submit" wire:loading.attr="disabled"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center">
                        <span wire:loading.remove>Submit Resume</span>
                        <span wire:loading>
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @error('submission') <p class="text-red-500 text-sm mt-4">{{ $message }}</p> @enderror
</div>
