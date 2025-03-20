<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'logos',
        'cta_text',

    ];

    protected $casts = [
        'logos' => 'array', // تخزين الشعارات كمصفوفة JSON
    ];
}
