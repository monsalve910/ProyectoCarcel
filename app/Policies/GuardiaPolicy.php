<?php

namespace App\Policies;

use App\Models\User;

class GuardiaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() && $user->isActive();
    }

    public function view(User $user, User $guardia): bool
    {
        return $user->isAdmin() && $user->isActive() && $guardia->isGuardia();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && $user->isActive();
    }

    public function update(User $user, User $guardia): bool
    {
        return $user->isAdmin() && $user->isActive() && $guardia->isGuardia();
    }

    public function delete(User $user, User $guardia): bool
    {
        return $user->isAdmin() && $user->isActive() && $guardia->isGuardia() && $guardia->id !== $user->id;
    }

    public function toggleActive(User $user, User $guardia): bool
    {
        return $user->isAdmin() && $user->isActive() && $guardia->isGuardia() && $guardia->id !== $user->id;
    }
}
