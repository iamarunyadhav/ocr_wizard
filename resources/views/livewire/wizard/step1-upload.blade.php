<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Upload Document</h2>

    <form wire:submit.prevent="save">
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Document Type</label>
            <select wire:model="context" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($availableContexts as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Upload File (PDF/DOCX)</label>
            <input type="file" wire:model="file" class="block w-full text-sm text-gray-500
                  file:mr-4 file:py-2 file:px-4
                  file:rounded-md file:border-0
                  file:text-sm file:font-semibold
                  file:bg-indigo-50 file:text-indigo-700
                  hover:file:bg-indigo-100">
            @error('file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @if($error)
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-md">
                {{ $error }}
            </div>
        @endif

        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:loading.attr="disabled">
            <span wire:loading.remove>Process Document</span>
            <span wire:loading>Processing...</span>
        </button>
    </form>

    @if($isUploading)
        <div class="mt-6 p-4 bg-blue-50 rounded-md">
            <div class="flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-blue-700">Extracting data from your document...</span>
            </div>
        </div>
    @endif
</div>
