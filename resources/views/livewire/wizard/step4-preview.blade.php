<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Document Preview</h2>

    <div class="mb-6 p-4 bg-gray-50 rounded-md">
        <h3 class="font-medium text-gray-700 mb-2">Document Context: <span class="capitalize">{{ $fields['context'] ?? 'resume' }}</span></h3>
    </div>

    <div class="space-y-6">
        @foreach($fields as $key => $value)
            @if($key !== 'context' && $key !== 'original_text')
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1 capitalize">{{ str_replace('_', ' ', $key) }}</h3>

                    @if(is_array($value))
                        <div class="ml-4 space-y-2">
                            @foreach($value as $subKey => $subValue)
                                <div>
                                    <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $subKey) }}</p>
                                    <p class="text-gray-800">{{ $subValue }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-800">{{ $value }}</p>
                    @endif
                </div>
            @endif
        @endforeach
    </div>

    <div class="mt-8 flex justify-between">
        <button wire:click="$emit('goToStep', 3)" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Back
        </button>
        <button wire:click="saveDocument"
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                wire:loading.attr="disabled">
            <span wire:loading.remove>Save Document</span>
            <span wire:loading>Saving...</span>
        </button>
    </div>

    @if($saveSuccess)
        <div class="mt-4 p-4 bg-green-50 text-green-700 rounded-md">
            Document saved successfully!
        </div>
    @endif
</div>
