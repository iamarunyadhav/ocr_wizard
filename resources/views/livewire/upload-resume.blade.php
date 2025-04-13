<div>
    <div class="text-center">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Upload Your Resume</h2>
        <p class="text-gray-600 mb-6">Supported formats: PDF, DOCX (Max 10MB)</p>

        <!-- Simplified file input - remove drag/drop temporarily -->
        <div class="mb-6">
            <input type="file" wire:model="file" id="file" class="hidden">
            <label for="file" class="cursor-pointer inline-block bg-white border border-gray-300 rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Select File
            </label>
            @error('file') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        @if($file)
            <div class="flex items-center justify-between bg-gray-100 p-3 rounded-lg mb-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ $file->getClientOriginalName() }}</span>
                </div>
                <button wire:click="$set('file', null)" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <button wire:click="upload"
                    wire:loading.attr="disabled"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                <span wire:loading.remove>Process Resume</span>
                <span wire:loading>
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>
            </button>
        @endif
    </div>
</div>
