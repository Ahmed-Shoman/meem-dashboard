<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'content',
        'date',
        'image',
        'author_name',
        'author_bio',
        'author_profile_picture',
        'author_instagram',
        'author_snapchat',
        'author_x_twitter',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
