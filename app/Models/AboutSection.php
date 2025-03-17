<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'background_media',
        'cta_text',
        'image',
        'title2',
        'sub_title2',
        'sub_descriotion2'
    ];
}
