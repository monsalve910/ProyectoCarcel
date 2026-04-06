<?php

namespace App\Providers;

use App\Models\Prisionero;
use App\Models\User;
use App\Models\Visita;
use App\Models\Visitante;
use App\Policies\GuardiaPolicy;
use App\Policies\PrisioneroPolicy;
use App\Policies\ReportePolicy;
use App\Policies\VisitaPolicy;
use App\Policies\VisitantePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Prisionero::class, PrisioneroPolicy::class);
        Gate::policy(Visitante::class, VisitantePolicy::class);
        Gate::policy(Visita::class, VisitaPolicy::class);
        Gate::policy(User::class, GuardiaPolicy::class);

        Gate::define('ver-reportes', function (User $user) {
            return $user->isAdmin() && $user->isActive();
        });

        Gate::define('gestionar-guardias', function (User $user) {
            return $user->isAdmin() && $user->isActive();
        });
    }
}
