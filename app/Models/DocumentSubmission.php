<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentSubmission extends Model
{
    protected $fillable = [
        'type',
        'data',
        'raw_text',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
