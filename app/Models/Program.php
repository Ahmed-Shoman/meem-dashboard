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
        'audio_time',
        'is_active',
        'program_description',
        'audio'
       ];

    public function episodes()
    {
        return $this->hasMany(AudioLibrary::class, 'program_id');
    }
}