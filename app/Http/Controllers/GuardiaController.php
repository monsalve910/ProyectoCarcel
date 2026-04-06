<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuardiaRequest;
use App\Http\Requests\UpdateGuardiaRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class GuardiaController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'guardia');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('estado')) {
            $query->where('is_active', $request->input('estado') === '1');
        }

        $guardias = $query->orderBy('name')->paginate(15);

        return view('guardias.index', compact('guardias'));
    }

    public function create(): View
    {
        return view('guardias.create');
    }

    public function store(StoreGuardiaRequest $request): RedirectResponse
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'guardia',
            'is_active' => true,
        ]);

        return redirect()->route('guardias.index')
            ->with('success', 'Guardia registrado exitosamente.');
    }

    public function show(User $guardia): View
    {
        if (!$guardia->isGuardia()) {
            abort(403);
        }

        $guardia->load(['visitas' => function ($query) {
            $query->orderBy('fecha_hora_entrada', 'desc')->limit(10);
        }, 'loginLogs' => function ($query) {
            $query->orderBy('login_at', 'desc')->limit(10);
        }]);

        return view('guardias.show', compact('guardia'));
    }

    public function edit(User $guardia): View
    {
        if (!$guardia->isGuardia()) {
            abort(403);
        }

        return view('guardias.edit', compact('guardia'));
    }

    public function update(UpdateGuardiaRequest $request, User $guardia): RedirectResponse
    {
        if (!$guardia->isGuardia()) {
            abort(403);
        }

        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $guardia->update($data);

        return redirect()->route('guardias.index')
            ->with('success', 'Guardia actualizado exitosamente.');
    }

    public function destroy(User $guardia): RedirectResponse
    {
        if (!$guardia->isGuardia()) {
            abort(403);
        }

        if ($guardia->id === Auth::id()) {
            return redirect()->route('guardias.index')
                ->with('error', 'No puede eliminarse a sí mismo.');
        }

        if ($guardia->visitas()->exists()) {
            return redirect()->route('guardias.index')
                ->with('error', 'No se puede eliminar un guardia con visitas registradas.');
        }

        $guardia->delete();

        return redirect()->route('guardias.index')
            ->with('success', 'Guardia eliminado exitosamente.');
    }

    public function toggleActive(User $guardia): RedirectResponse
    {
        if (!$guardia->isGuardia()) {
            abort(403);
        }

        if ($guardia->id === Auth::id()) {
            return redirect()->route('guardias.index')
                ->with('error', 'No puede desactivarse a sí mismo.');
        }

        $guardia->update(['is_active' => !$guardia->is_active]);

        $message = $guardia->is_active ? 'Guardia activado exitosamente.' : 'Guardia desactivado exitosamente.';

        return redirect()->route('guardias.index')
            ->with('success', $message);
    }
}
