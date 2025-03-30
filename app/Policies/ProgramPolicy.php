<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return true; // التصفية تتم في الـ Resource
    }

    public function view(User $user, Program $program)
    {
        return $user->program_id === $program->id;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Program $program)
    {
        return $user->program_id === $program->id || $user->isAdmin();
    }

    public function delete(User $user, Program $program)
    {
        return $user->isAdmin();
    }
}
