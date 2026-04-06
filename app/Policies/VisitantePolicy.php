<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visitante;

class VisitantePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isActive();
    }

    public function view(User $user, Visitante $visitante): bool
    {
        return $user->isActive();
    }

    public function create(User $user): bool
    {
        return $user->isActive();
    }

    public function update(User $user, Visitante $visitante): bool
    {
        return $user->isActive();
    }

    public function delete(User $user, Visitante $visitante): bool
    {
        return $user->isActive();
    }
}
