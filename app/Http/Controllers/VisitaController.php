<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitaRequest;
use App\Http\Requests\UpdateVisitaRequest;
use App\Models\Prisionero;
use App\Models\User;
use App\Models\Visita;
use App\Models\Visitante;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Visita::with(['prisionero', 'visitante', 'guardia']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('prisionero', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%");
            })->orWhereHas('visitante', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%");
            });
        }

        if ($request->has('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->has('fecha_desde')) {
            $query->whereDate('fecha_hora_entrada', '>=', $request->input('fecha_desde'));
        }

        if ($request->has('fecha_hasta')) {
            $query->whereDate('fecha_hora_entrada', '<=', $request->input('fecha_hasta'));
        }

        $visitas = $query->orderBy('fecha_hora_entrada', 'desc')->paginate(15);

        return view('visitas.index', compact('visitas'));
    }

    public function create(): View
    {
        $prisioneros = Prisionero::where('estado', true)->orderBy('nombre')->get();
        $visitantes = Visitante::where('estado', true)->orderBy('nombre')->get();

        return view('visitas.create', compact('prisioneros', 'visitantes'));
    }

    public function store(StoreVisitaRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['guardia_id'] = $request->user()->id;
        $validated['estado'] = 'pendiente';

        Visita::create($validated);

        return redirect()->route('visitas.index')
            ->with('success', 'Visita registrada exitosamente. Pendiente de aprobación.');
    }

    public function show(Visita $visita): View
    {
        $visita->load(['prisionero', 'visitante', 'guardia']);

        return view('visitas.show', compact('visita'));
    }

    public function edit(Visita $visita): View
    {
        $prisioneros = Prisionero::where('estado', true)->orderBy('nombre')->get();
        $visitantes = Visitante::where('estado', true)->orderBy('nombre')->get();

        return view('visitas.edit', compact('visita', 'prisioneros', 'visitantes'));
    }

    public function update(UpdateVisitaRequest $request, Visita $visita): RedirectResponse
    {
        $visita->update($request->validated());

        return redirect()->route('visitas.index')
            ->with('success', 'Visita actualizada exitosamente.');
    }

    public function destroy(Visita $visita): RedirectResponse
    {
        if (in_array($visita->estado, ['aprobada', 'completada'])) {
            return redirect()->route('visitas.index')
                ->with('error', 'No se puede eliminar una visita aprobada o completada.');
        }

        $visita->delete();

        return redirect()->route('visitas.index')
            ->with('success', 'Visita eliminada exitosamente.');
    }

    public function approve(Visita $visita): RedirectResponse
    {
        if ($visita->estado !== 'pendiente') {
            return redirect()->route('visitas.index')
                ->with('error', 'Solo se pueden aprobar visitas pendientes.');
        }

        $visita->update(['estado' => 'aprobada']);

        return redirect()->route('visitas.index')
            ->with('success', 'Visita aprobada exitosamente.');
    }

    public function reject(Visita $visita): RedirectResponse
    {
        if ($visita->estado !== 'pendiente') {
            return redirect()->route('visitas.index')
                ->with('error', 'Solo se pueden rechazar visitas pendientes.');
        }

        $visita->update(['estado' => 'rechazada']);

        return redirect()->route('visitas.index')
            ->with('success', 'Visita rechazada.');
    }

    public function complete(Visita $visita): RedirectResponse
    {
        if ($visita->estado !== 'aprobada') {
            return redirect()->route('visitas.index')
                ->with('error', 'Solo se pueden completar visitas aprobadas.');
        }

        $visita->update([
            'estado' => 'completada',
            'fecha_hora_salida' => now(),
        ]);

        return redirect()->route('visitas.index')
            ->with('success', 'Visita completada exitosamente.');
    }

    public function cancel(Visita $visita): RedirectResponse
    {
        if (in_array($visita->estado, ['completada', 'cancelada'])) {
            return redirect()->route('visitas.index')
                ->with('error', 'No se puede cancelar esta visita.');
        }

        $visita->update(['estado' => 'cancelada']);

        return redirect()->route('visitas.index')
            ->with('success', 'Visita cancelada.');
    }
}
