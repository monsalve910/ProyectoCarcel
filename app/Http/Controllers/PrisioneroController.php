<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrisioneroRequest;
use App\Http\Requests\UpdatePrisioneroRequest;
use App\Models\Prisionero;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrisioneroController extends Controller
{
    public function index(Request $request): View
    {
        $query = Prisionero::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('numero_identificacion', 'like', "%{$search}%")
                    ->orWhere('numero_celda', 'like', "%{$search}%");
            });
        }

        if ($request->has('estado')) {
            $query->where('estado', $request->input('estado') === '1');
        }

        $prisioneros = $query->orderBy('nombre')->paginate(15);

        return view('prisioneros.index', compact('prisioneros'));
    }

    public function create(): View
    {
        return view('prisioneros.create');
    }

    public function store(StorePrisioneroRequest $request): RedirectResponse
    {
        Prisionero::create($request->validated());

        return redirect()->route('prisioneros.index')
            ->with('success', 'Prisionero registrado exitosamente.');
    }

    public function show(Prisionero $prisionero): View
    {
        $prisionero->load(['visitas' => function ($query) {
            $query->orderBy('fecha_hora_entrada', 'desc')->limit(10);
        }]);

        return view('prisioneros.show', compact('prisionero'));
    }

    public function edit(Prisionero $prisionero): View
    {
        return view('prisioneros.edit', compact('prisionero'));
    }

    public function update(UpdatePrisioneroRequest $request, Prisionero $prisionero): RedirectResponse
    {
        $prisionero->update($request->validated());

        return redirect()->route('prisioneros.index')
            ->with('success', 'Prisionero actualizado exitosamente.');
    }

    public function destroy(Prisionero $prisionero): RedirectResponse
    {
        if ($prisionero->visitas()->exists()) {
            return redirect()->route('prisioneros.index')
                ->with('error', 'No se puede eliminar un prisionero con visitas registradas.');
        }

        $prisionero->delete();

        return redirect()->route('prisioneros.index')
            ->with('success', 'Prisionero eliminado exitosamente.');
    }
}
