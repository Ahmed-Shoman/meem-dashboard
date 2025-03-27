<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'presenter',
        'image',
        'seasons',
        'episodes',
        'program_name',
        'is_active',
    ];

    public function episodes()
    {
        return $this->hasMany(AudioLibrary::class, 'program_id');
    }
}
