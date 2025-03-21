<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProgram  extends Model
{
    use HasFactory;

    protected $table = 'new_programs';

    protected $fillable = [
        'title',
        'category',
        'image',
        'seasons',
        'episodes',
        'producer',
        'description',
    ];

    protected $casts = [
        'category' => 'array',
    ];
}