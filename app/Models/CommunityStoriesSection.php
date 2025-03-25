<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityStoriesSection extends Model
{
    protected $table = 'community_stories_section';

    protected $fillable = [
        'main_title',
        'links',
        'description',
    ];

    protected $casts = [
        'links' => 'array',
    ];
}