<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'context',
        'original_text',
        'extracted_fields',
        'metadata'
    ];

    protected $casts = [
        'extracted_fields' => 'array',
        'metadata' => 'array'
    ];
}
