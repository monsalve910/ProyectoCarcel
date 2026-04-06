<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Prisionero;

class PrisioneroPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isActive();
    }

    public function view(User $user, Prisionero $prisionero): bool
    {
        return $user->isActive();
    }

    public function create(User $user): bool
    {
        return $user->isActive();
    }

    public function update(User $user, Prisionero $prisionero): bool
    {
        return $user->isActive();
    }

    public function delete(User $user, Prisionero $prisionero): bool
    {
        return $user->isActive();
    }
}
