<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiobook extends Model
{
    use HasFactory;

    protected $fillable = [
        'presenter',
        'image',
        'seasons',
        'episodes',
        'program_name',
        'audio',
        'audio_duration',
        'is_active',
        'description',
    ];

    // العلاقة مع الحلقات الصوتية
    public function episodes()
    {
        return $this->hasMany(AudiobookEpisode::class);
    }
}