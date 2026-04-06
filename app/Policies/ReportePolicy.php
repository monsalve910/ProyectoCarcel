<?php

namespace App\Policies;

use App\Models\User;

class ReportePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() && $user->isActive();
    }

    public function view(User $user): bool
    {
        return $user->isAdmin() && $user->isActive();
    }

    public function exportar(User $user): bool
    {
        return $user->isAdmin() && $user->isActive();
    }
}
