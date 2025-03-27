<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_title',
        'plan_name',
        'plan_description',
        'plan_price',
        'plan_details',
        'faqs',
        'listen_now_title',
        'listen_now_text',
        'platform_links',
        'listen_now_image',
        'feature_list'
    ];

    protected $casts = [
        'plan_details' => 'array',
        'faqs' => 'array',
        'platform_links' => 'array',
        'feature_list'=>'array',
    ];
}
