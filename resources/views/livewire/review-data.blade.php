<div>
    <div class="text-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Review Your Information</h2>
        <p class="text-gray-600">Please verify the extracted details</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" wire:model="resumeData.name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    @error('resumeData.name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="resumeData.email" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    @error('resumeData.email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" wire:model="resumeData.phone" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    @error('resumeData.phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                @if(!empty($resumeData['skills']))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Skills</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($resumeData['skills'] as $skill)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(!empty($resumeData['experience']))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Experience</label>
                        <div class="space-y-3">
                            @foreach($resumeData['experience'] as $exp)
                                <div class="border-l-4 border-indigo-200 pl-4 py-1">
                                    <p class="font-medium">{{ $exp['role'] ?? '' }}</p>
                                    <p class="text-sm text-gray-600">{{ $exp['company'] ?? '' }}</p>
                                    <p class="text-xs text-gray-500">{{ $exp['years'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-8 pt-5 border-t border-gray-200 flex justify-between">
                <button wire:click="$emit('previousStep')"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back
                </button>
                <button wire:click="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Continue to Submit
                </button>
            </div>
        </div>
    </div>
</div>
