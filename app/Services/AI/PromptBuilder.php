<?php

namespace App\Services\AI;

class PromptBuilder
{
    private array $contextPrompts = [
        'resume' => "Extract structured fields from this resume text as JSON key-value pairs. Include: Name, Email, Phone, Experience (company, role, years), Education (institution, degree, year), Skills. Return only valid JSON.",
        'property' => "Extract property details from this document as JSON. Include: Address, Price, Bedrooms, Bathrooms, Square Footage, Property Type, Year Built, Features. Return only valid JSON.",
        'hotel' => "Extract hotel booking details from this document as JSON. Include: Guest Name, Check-in Date, Check-out Date, Room Type, Total Price, Booking Reference, Special Requests. Return only valid JSON.",
        'education' => "Extract educational institution details from this document as JSON. Include: Institution Name, Degree, Field of Study, Graduation Year, GPA, Honors, Relevant Courses. Return only valid JSON."
    ];

    public function build(string $context, string $text): string
    {
        $basePrompt = $this->contextPrompts[$context] ?? $this->contextPrompts['resume'];
        return "$basePrompt\n\nDocument Text:\n$text";
    }
}
