<x-layouts.app>
    <div class="container mx-auto py-6">
        <!-- Progress indicator -->
        <div class="wizard-progress mb-8">
            @foreach([1 => 'Upload', 2 => 'Review', 3 => 'Suggestions', 4 => 'Preview'] as $step => $label)
                <div class="step {{ $currentStep >= $step ? 'active' : '' }}">
                    Step {{ $step }}: {{ $label }}
                </div>
            @endforeach
        </div>

        <!-- Step content -->
        <div class="wizard-content">
            @if($currentStep === 1)
                <livewire:wizard.step1-upload />
            @elseif($currentStep === 2)
                <livewire:wizard.step2-review
                    :fields="$documentData['fields'] ?? []"
                    :originalText="$documentData['originalText'] ?? ''"
                    :context="$documentData['context'] ?? ''" />
            @elseif($currentStep === 3)
                <livewire:wizard.step3-suggestions
                    :fields="$documentData['fields'] ?? []"
                    :context="$documentData['context'] ?? ''" />
            @elseif($currentStep === 4)
                <livewire:wizard.step4-preview
                    :fields="$documentData['final_fields'] ?? []" />
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .wizard-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .step {
            padding: 0.5rem 1rem;
            background: #e5e7eb;
            border-radius: 0.25rem;
            flex: 1;
            text-align: center;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }

        .step.active {
            background: #3b82f6;
            color: white;
            font-weight: 500;
        }

        .wizard-content {
            min-height: 400px;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>
    @endpush
</x-layouts.app>
