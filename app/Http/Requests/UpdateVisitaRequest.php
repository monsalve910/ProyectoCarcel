<?php

namespace App\Http\Requests;

use App\Rules\HorarioVisitaValido;
use App\Rules\SinConflictoHorario;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVisitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isActive();
    }

    public function rules(): array
    {
        $visita = $this->route('visita');
        $prisioneroId = $this->input('prisionero_id', $visita?->prisionero_id);
        $fechaEntrada = $this->input('fecha_hora_entrada');
        $fechaSalida = $this->input('fecha_hora_salida');

        $rules = [
            'prisionero_id' => ['required', 'integer', 'exists:prisioneros,id'],
            'visitante_id' => ['required', 'integer', 'exists:visitantes,id'],
            'fecha_hora_entrada' => [
                'required',
                'date',
                new HorarioVisitaValido(),
            ],
            'fecha_hora_salida' => ['required', 'date', 'after:fecha_hora_entrada'],
            'estado' => [Rule::in(['pendiente', 'aprobada', 'rechazada', 'completada', 'cancelada'])],
            'observaciones' => ['nullable', 'string'],
        ];

        if ($prisioneroId && $fechaEntrada && $fechaSalida && $visita) {
            $rules['fecha_hora_entrada'][] = new SinConflictoHorario(
                (int) $prisioneroId,
                Carbon::parse($fechaEntrada)->toDateTimeString(),
                Carbon::parse($fechaSalida)->toDateTimeString(),
                $visita->id
            );
        }

        return $rules;
    }
}
