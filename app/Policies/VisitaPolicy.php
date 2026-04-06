<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visita;

class VisitaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isActive();
    }

    public function view(User $user, Visita $visita): bool
    {
        return $user->isActive();
    }

    public function create(User $user): bool
    {
        return $user->isActive();
    }

    public function update(User $user, Visita $visita): bool
    {
        return $user->isActive();
    }

    public function delete(User $user, Visita $visita): bool
    {
        return $user->isActive() && !in_array($visita->estado, ['aprobada', 'completada']);
    }

    public function approve(User $user, Visita $visita): bool
    {
        return $user->isActive() && $visita->estado === 'pendiente';
    }

    public function reject(User $user, Visita $visita): bool
    {
        return $user->isActive() && $visita->estado === 'pendiente';
    }

    public function complete(User $user, Visita $visita): bool
    {
        return $user->isActive() && $visita->estado === 'aprobada';
    }

    public function cancel(User $user, Visita $visita): bool
    {
        return $user->isActive() && !in_array($visita->estado, ['completada', 'cancelada']);
    }
}
