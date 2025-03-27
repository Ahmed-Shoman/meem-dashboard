<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioLibrary extends Model
{
    use HasFactory;

    protected $table = 'audio_library';

    protected $fillable = [
        'program_id', 
        'image',
        'sound',
        'sound_time',
        'category',
        'description',
        'sub_description',
        'is_active'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
