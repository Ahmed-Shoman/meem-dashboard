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
        'title2',
        'description2',
        'points'
    ];

    protected $casts = [
        'points' => 'array', 
    ];
}