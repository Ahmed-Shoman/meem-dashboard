<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'bio', 'is_admin', 'role', 'social_media', 'program_id'
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'role' => 'array',
        'social_media' => 'array',
    ];

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
