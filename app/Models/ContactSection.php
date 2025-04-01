<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSection extends Model
{
    protected $table = 'contact_sections';
    protected $fillable = ['title', 'subtitle', 'description'];
}