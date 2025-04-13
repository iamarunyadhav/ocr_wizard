<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Additional Suggestions</h2>

    <div class="mb-6 p-4 bg-gray-50 rounded-md">
        <h3 class="font-medium text-gray-700 mb-2">Document Context: <span class="capitalize">{{ $context }}</span></h3>
    </div>

    <div class="space-y-6">
        @foreach($suggestions as $suggestion)
            <div x-data="{ expanded: false }">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md cursor-pointer" @click="expanded = !expanded">
                    <h3 class="font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $suggestion) }}</h3>
                    <svg :class="{'transform rotate-180': expanded}" class="w-5 h-5 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <div x-show="expanded" x-transition class="mt-2 ml-4 p-3 bg-gray-50 rounded-md">
                    @if(in_array($suggestion, $selectedSuggestions))
                        <div class="space-y-4">
                            @foreach($fields[$suggestion] as $key => $value)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1 capitalize">{{ str_replace('_', ' ', $key) }}</label>
                                    <input type="text"
                                           wire:model="fields.{{ $suggestion }}.{{ $key }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <button wire:click="fetchSuggestionData('{{ $suggestion }}')"
                                class="px-3 py-1 text-sm font-medium text-indigo-600 hover:text-indigo-800"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Fetch {{ str_replace('_', ' ', $suggestion) }} Data</span>
                            <span wire:loading>Processing...</span>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 flex justify-between">
        <button wire:click="$emit('goToStep', 2)" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Back
        </button>
        <button wire:click="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Preview & Save
        </button>
    </div>
</div>
