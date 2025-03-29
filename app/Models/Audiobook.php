<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiobook extends Model
{
    use HasFactory;

    protected $fillable = [
        'presenter',
        'presenter_image',
        'instagram',
        'snapchat',
        'x',
        'image',
        'seasons',
        'episodes',
        'program_name',
        'is_active',
        'description',
    ];

    /**
     * Relationship: An audiobook has many episodes.
     */
    public function episodes()
    {
        return $this->hasMany(AudiobookEpisode::class);
    }
}
