<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'bio',
        'is_admin',
        'role',
        'social_media',
        'assignable',
    ];

    protected $casts = [
        'social_media' => 'array',
        'assignable' => 'array',
        'is_admin' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // One-to-many relationship with episodes
    public function episodes()
    {
        return $this->hasMany(Episode::class, 'user_id');
    }

    // Many-to-many relationship with programs
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_user', 'user_id', 'program_id')->withTimestamps();
    }

    // adding auth function
    public function isAdmin(): mixed
    {

        return $this->is_admin;

    }
}
