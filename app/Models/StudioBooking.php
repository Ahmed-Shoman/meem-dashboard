<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description1',
        'description2',
        'studio_images',
        'equipment_list',
        'cta_button_text',
    ];

    protected $casts = [
        'studio_images' => 'array',
        'equipment_list' => 'array',
    ];
}
