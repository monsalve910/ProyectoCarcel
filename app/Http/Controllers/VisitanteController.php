<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreVisitanteRequest;
use App\Http\Requests\UpdateVisitanteRequest;
use App\Models\Visitante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitanteController extends Controller
{
    public function index(Request $request): View
    {
        $query = Visitante::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('numero_identificacion', 'like', "%{$search}%");
            });
        }

        if ($request->has('estado')) {
            $query->where('estado', $request->input('estado') === '1');
        }

        $visitantes = $query->orderBy('nombre')->paginate(15);

        return view('visitantes.index', compact('visitantes'));
    }

    public function create(): View
    {
        return view('visitantes.create');
    }

    public function store(StoreVisitanteRequest $request): RedirectResponse
    {
        Visitante::create($request->validated());

        return redirect()->route('visitantes.index')
            ->with('success', 'Visitante registrado exitosamente.');
    }

    public function show(Visitante $visitante): View
    {
        $visitante->load(['visitas' => function ($query) {
            $query->orderBy('fecha_hora_entrada', 'desc')->limit(10);
        }]);

        return view('visitantes.show', compact('visitante'));
    }

    public function edit(Visitante $visitante): View
    {
        return view('visitantes.edit', compact('visitante'));
    }

    public function update(UpdateVisitanteRequest $request, Visitante $visitante): RedirectResponse
    {
        $visitante->update($request->validated());

        return redirect()->route('visitantes.index')
            ->with('success', 'Visitante actualizado exitosamente.');
    }

    public function destroy(Visitante $visitante): RedirectResponse
    {
        if ($visitante->visitas()->exists()) {
            return redirect()->route('visitantes.index')
                ->with('error', 'No se puede eliminar un visitante con visitas registradas.');
        }

        $visitante->delete();

        return redirect()->route('visitantes.index')
            ->with('success', 'Visitante eliminado exitosamente.');
    }
}
