<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioLibrary extends Model
{
    use HasFactory;

    protected $table = 'audio_library';

    protected $fillable = [
        'user_id',
        'program_id',
        'episode_type',
        'image',
        'sound',
        'sound_time',
        'category',
        'description',
        'sub_description',
        'is_active',
        'episode_number',
        'guest_name',
        'youtube_link',
        'apple_podcast_link',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sound_time' => 'string', // Explicit cast for sound_time
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Dynamic program relationship
    public function program()
    {
        return $this->getProgramAttribute();
    }

    // Accessor for program
    public function getProgramAttribute()
    {
        if ($this->episode_type === 'بودكاست') {
            return Program::find($this->program_id);
        } elseif ($this->episode_type === 'عالطاير') {
            return OnTheFly::find($this->program_id);
        }
        return null;
    }

    // Helper method to get program name
    public function getProgramNameAttribute(): string
    {
        return $this->program?->program_name ?? 'غير معروف';
    }

    // URL accessors
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    public function getSoundUrlAttribute(): ?string
    {
        return $this->sound ? asset('storage/'.$this->sound) : null;
    }
}