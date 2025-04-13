<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'ocr' => [
        'default' => env('OCR_SERVICE', 'tesseract'),
    ],

    'google_vision' => [
        'credentials' => env('GOOGLE_VISION_CREDENTIALS'),
    ],

    'ai' => [
        'default' => env('AI_SERVICE', 'gpt'),
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
    ],

    'deepseek' => [
        'api_key' => env('DEEPSEEK_API_KEY'),
    ],

    'default' => env('OCR_SERVICE', 'tesseract'),
    'max_file_size' => env('OCR_MAX_FILE_SIZE', 10485760), // 10MB
    'tesseract' => [
        'languages' => ['eng'],
        'psm' => 6,
    ],
    'google_vision' => [
        'credentials_path' => env('GOOGLE_APPLICATION_CREDENTIALS'),
    ],

];
