<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'episode_type',
        'episode_number',
        'guest_name',
        'youtube_link',
        'apple_podcast_link',
        'cover_image',
        'audio_file',
        'audio_duration',
        'category',
        'description',
        'short_description',
        'is_active',
    ];

    /**
     * Get the program that owns the episode.
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Get the user that owns the episode.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
