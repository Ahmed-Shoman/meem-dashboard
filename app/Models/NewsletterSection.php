<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_title',
        'description',
        'image',
        'cta_button_text',
    ];
}
