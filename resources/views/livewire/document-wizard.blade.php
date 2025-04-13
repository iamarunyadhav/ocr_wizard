<div>
    @if ($step === 1)
        <form wire:submit.prevent="upload">
            <label>Document Type:</label>
            <select wire:model="type" class="border p-2 mb-2">
                <option value="resume">Resume</option>
                <option value="property">Property</option>
                <option value="hotel">Hotel</option>
                <option value="education">Education</option>
                <option value="other">Other</option>
            </select>

            <input type="file" wire:model="document" class="mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
        </form>
    @elseif ($step === 2)
        <p class="mb-2">Raw Text Extracted:</p>
        <pre class="bg-gray-200 p-2 max-h-60 overflow-auto">{{ $rawText }}</pre>
        <button wire:click="extract" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Extract with AI</button>
    @elseif ($step === 3)
        <form wire:submit.prevent="submit">
            @foreach ($extractedData as $key => $value)
                <div class="mb-2">
                    <label class="block font-bold">{{ ucfirst($key) }}</label>
                    <input type="text" wire:model.defer="extractedData.{{ $key }}" class="w-full p-2 border rounded">
                </div>
            @endforeach

            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">Submit</button>
                <button type="button" wire:click="suggest('certifications')" class="bg-yellow-500 text-white px-4 py-2 rounded">Add Certifications</button>
            </div>
        </form>
    @elseif ($step === 4)
        <h2 class="text-xl font-bold text-green-600">Submitted successfully!</h2>
    @endif
</div>

