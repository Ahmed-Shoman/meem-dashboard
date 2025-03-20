<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cta_button_text',
        'images',
    ];

    protected $casts = [
        'images' => 'array', // Store images as an array
    ];
}