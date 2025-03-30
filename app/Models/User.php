<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'bio', 'program_id', 'is_admin'
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    // التحقق مما إذا كان المستخدم Admin
    public function isAdmin()
    {
        return $this->is_admin;
    }

    // العلاقة مع البرنامج
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
