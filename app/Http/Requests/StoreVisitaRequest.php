<?php

namespace App\Http\Requests;

use App\Rules\HorarioVisitaValido;
use App\Rules\SinConflictoHorario;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreVisitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isActive();
    }

    public function rules(): array
    {
        $prisioneroId = $this->input('prisionero_id');
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
            'observaciones' => ['nullable', 'string'],
        ];

        if ($prisioneroId && $fechaEntrada && $fechaSalida) {
            $rules['fecha_hora_entrada'][] = new SinConflictoHorario(
                (int) $prisioneroId,
                Carbon::parse($fechaEntrada)->toDateTimeString(),
                Carbon::parse($fechaSalida)->toDateTimeString()
            );
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'prisionero_id.required' => 'Debe seleccionar un prisionero.',
            'prisionero_id.exists' => 'El prisionero seleccionado no existe.',
            'visitante_id.required' => 'Debe seleccionar un visitante.',
            'visitante_id.exists' => 'El visitante seleccionado no existe.',
            'fecha_hora_entrada.required' => 'Debe ingresar la fecha y hora de entrada.',
            'fecha_hora_salida.required' => 'Debe ingresar la fecha y hora de salida.',
            'fecha_hora_salida.after' => 'La fecha de salida debe ser posterior a la fecha de entrada.',
        ];
    }
}
