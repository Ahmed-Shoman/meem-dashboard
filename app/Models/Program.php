<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'program_name',
        'presenter',
        'presenter_image',
        'image',
        'seasons',
        'episodes',
        'is_active',
        'type',
        'description',
        'instagram',
        'snapchat',
        'x',
    ];

    public function episodes()
    {
        return $this->hasMany(Episode::class, 'program_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
