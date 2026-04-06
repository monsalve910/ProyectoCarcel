<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVisitanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isActive();
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'numero_identificacion' => [
                'required',
                'string',
                'max:50',
                Rule::unique('visitantes', 'numero_identificacion')->ignore($this->route('visitante'))
            ],
            'telefono' => ['nullable', 'string', 'max:20'],
            'parentesco' => ['required', 'string', 'max:50'],
            'direccion' => ['nullable', 'string'],
            'estado' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'numero_identificacion.unique' => 'Ya existe un visitante registrado con este número de identificación.',
        ];
    }
}
