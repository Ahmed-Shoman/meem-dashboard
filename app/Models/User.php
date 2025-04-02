<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'bio', 'is_admin', 
        'role', 'social_media', 'assignable'
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'social_media' => 'array',
        'assignable' => 'array',
    ];

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function getAssignableProgram(): ?array
    {
        return $this->assignable;
    }

    public function setAssignableProgram(array $program): void
    {
        $assignable = $this->assignable ?? [];

        // Check if the program already exists and update it, or add it
        $found = false;
        foreach ($assignable as &$assign) {
            if ($assign['id'] === $program['id'] && $assign['assignable_type'] === $program['assignable_type']) {
                $assign['program_name'] = $program['program_name'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $assignable[] = [
                'assignable_type' => $program['assignable_type'],
                'id' => $program['id'],
                'program_name' => $program['program_name'],
            ];
        }

        $this->assignable = $assignable;
        $this->save();
    }
}