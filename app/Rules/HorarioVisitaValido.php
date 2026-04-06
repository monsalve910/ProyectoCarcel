<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HorarioVisitaValido implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $fecha = Carbon::parse($value);
            
            if ($fecha->dayOfWeek !== Carbon::SUNDAY) {
                $fail('Las visitas solo pueden programarse los días domingo.');
                return;
            }
            
            $hora = $fecha->hour;
            if ($hora < 14 || $hora >= 17) {
                $fail('Las visitas solo pueden programarse entre las 14:00 y las 17:00 horas.');
            }
        } catch (\Exception $e) {
            $fail('La fecha proporcionada no es válida.');
        }
    }
}
