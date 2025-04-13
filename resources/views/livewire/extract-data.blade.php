<div>
    <div class="text-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Extracting Resume Data</h2>
        <p class="text-gray-600">We'll automatically extract information from your resume</p>
    </div>

    @if(!$extractedText && !$isProcessing)
        <div class="text-center py-8">
            <button wire:click="extractText"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                Start Extraction
            </button>
        </div>
    @endif

    @if($isProcessing)
        <div class="text-center py-12">
            <div class="inline-flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-medium text-gray-700">Processing your resume...</span>
            </div>
            <p class="mt-2 text-gray-500">This may take a few moments</p>
        </div>
    @endif

    @if($extractedData)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Extracted Information</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" wire:model="extractedData.name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" wire:model="extractedData.email" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" wire:model="extractedData.phone" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    @if(!empty($extractedData['skills']))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Skills</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($extractedData['skills'] as $skill)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                @if(!empty($suggestions))
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Additional Suggestions</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($suggestions as $suggestion)
                                <button wire:click="addSuggestion('{{ $suggestion }}')"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200">
                                    + {{ $suggestion }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8 pt-5 border-t border-gray-200">
                    <button wire:click="submitData"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Continue to Review
                    </button>
                </div>
            </div>
        </div>
    @endif

    @error('extraction') <p class="text-red-500 text-sm mt-4">{{ $message }}</p> @enderror
    @error('ai') <p class="text-red-500 text-sm mt-4">{{ $message }}</p> @enderror
</div>
