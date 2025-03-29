<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudiobookEpisode extends Model
{
    use HasFactory;

    protected $fillable = [
        'audiobook_id',
        'cover_image',
        'audio_file',
        'audio_duration',
        'category',
        'description',
        'short_description',
        'is_active',
    ];

    public function audiobook()
    {
        return $this->belongsTo(Audiobook::class);
    }
}
