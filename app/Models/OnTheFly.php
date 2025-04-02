<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnTheFly extends Model
{
    use HasFactory;

    protected $table = 'on_the_fly';

    protected $fillable = [
        'presenter',
        'presenter_image',
        'image',
        'seasons',
        'episodes',
        'program_name',
        'is_active',
        'program_description',
        'instagram',
        'snapchat',
        'x',
    ];

    /**
     * Define the relationship between OnTheFly and AudioLibrary.
     * Assuming 'AudioLibrary' has a 'program_id' column linking to 'OnTheFly'.
     */

    public function episodes()
    {
        return $this->hasMany(AudioLibrary::class, 'program_id');
    }
}
