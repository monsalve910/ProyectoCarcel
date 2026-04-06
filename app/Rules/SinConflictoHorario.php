<?php

namespace App\Rules;

use App\Models\Visita;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SinConflictoHorario implements ValidationRule
{
    protected ?int $excludeId;
    protected int $prisioneroId;
    protected string $entrada;
    protected string $salida;

    public function __construct(int $prisioneroId, string $entrada, string $salida, ?int $excludeId = null)
    {
        $this->prisioneroId = $prisioneroId;
        $this->entrada = $entrada;
        $this->salida = $salida;
        $this->excludeId = $excludeId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $conflicto = Visita::conflictoHorario(
            $this->prisioneroId,
            $this->entrada,
            $this->salida,
            $this->excludeId
        )->exists();

        if ($conflicto) {
            $fail('Ya existe una visita programada para este prisionero en el rango de fecha y hora seleccionado.');
        }
    }
}
