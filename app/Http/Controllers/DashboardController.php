<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\Prisionero;
use App\Models\User;
use App\Models\Visita;
use App\Models\Visitante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function adminDashboard(): View
    {
        $stats = [
            'total_prisioneros' => Prisionero::count(),
            'prisioneros_activos' => Prisionero::where('estado', true)->count(),
            'total_visitantes' => Visitante::count(),
            'visitantes_activos' => Visitante::where('estado', true)->count(),
            'total_guardias' => User::where('role', 'guardia')->count(),
            'guardias_activos' => User::where('role', 'guardia')->where('is_active', true)->count(),
            'visitas_hoy' => Visita::whereDate('fecha_hora_entrada', today())->count(),
            'visitas_semana' => Visita::whereBetween('fecha_hora_entrada', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'visitas_mes' => Visita::whereMonth('fecha_hora_entrada', now()->month)->count(),
            'visitas_pendientes' => Visita::where('estado', 'pendiente')->count(),
        ];

        $recentVisitas = Visita::with(['prisionero', 'visitante'])
            ->orderBy('fecha_hora_entrada', 'desc')
            ->limit(5)
            ->get();

        $recentLogins = LoginLog::with('user')
            ->orderBy('login_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentVisitas', 'recentLogins'));
    }

    public function guardiaDashboard(): View
    {
        $stats = [
            'visitas_hoy' => Visita::whereDate('fecha_hora_entrada', today())->count(),
            'visitas_pendientes' => Visita::where('estado', 'pendiente')->count(),
            'visitas_aprobadas' => Visita::where('estado', 'aprobada')->count(),
            'visitas_semana' => Visita::whereBetween('fecha_hora_entrada', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'mis_visitas_hoy' => Visita::where('guardia_id', Auth::id())
                ->whereDate('fecha_hora_entrada', today())
                ->count(),
        ];

        $recentVisitas = Visita::with(['prisionero', 'visitante'])
            ->where('guardia_id', Auth::id())
            ->orderBy('fecha_hora_entrada', 'desc')
            ->limit(5)
            ->get();

        return view('guardia.dashboard', compact('stats', 'recentVisitas'));
    }
}
