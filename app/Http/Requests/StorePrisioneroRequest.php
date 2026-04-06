<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrisioneroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isActive();
    }

    public function rules(): array
    {
        return [
            'numero_celda' => ['required', 'string', 'max:20'],
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'numero_identificacion' => ['required', 'string', 'max:50', 'unique:prisioneros,numero_identificacion'],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'delito' => ['required', 'string'],
            'fecha_ingreso' => ['required', 'date'],
            'fecha_salida_prevista' => ['nullable', 'date', 'after:fecha_ingreso'],
        ];
    }
}
