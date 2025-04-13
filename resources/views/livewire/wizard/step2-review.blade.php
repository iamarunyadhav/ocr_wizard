<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Review Extracted Data</h2>

    <div class="mb-6 p-4 bg-gray-50 rounded-md">
        <h3 class="font-medium text-gray-700 mb-2">Document Context: <span class="capitalize">{{ $context }}</span></h3>
    </div>

    <div class="space-y-6">
        @foreach($fields as $key => $value)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 capitalize">{{ str_replace('_', ' ', $key) }}</label>

                @if(is_array($value))
                    <div class="space-y-4 ml-4">
                        @foreach($value as $subKey => $subValue)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 capitalize">{{ str_replace('_', ' ', $subKey) }}</label>
                                <input type="text"
                                       wire:model="fields.{{ $key }}.{{ $subKey }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        @endforeach
                    </div>
                @else
                    <input type="text"
                           wire:model="fields.{{ $key }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @endif
            </div>
        @endforeach
    </div>

    @if(count($suggestedFields) > 0)
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Optional Fields (Available in Next Step)</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($suggestedFields as $field)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                        {{ str_replace('_', ' ', $field) }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-8 flex justify-end">
        <button wire:click="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Continue to Suggestions
        </button>
    </div>
</div>
