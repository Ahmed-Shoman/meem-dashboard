<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_title',
        'description',
        'points',
        'title2',
        'description2',

    ];

    protected $casts = [
        'points' => 'array',
    ];
}
