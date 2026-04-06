<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prisionero extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_celda',
        'nombre',
        'apellido',
        'numero_identificacion',
        'fecha_nacimiento',
        'delito',
        'fecha_ingreso',
        'fecha_salida_prevista',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'fecha_ingreso' => 'date',
            'fecha_salida_prevista' => 'date',
            'estado' => 'boolean',
        ];
    }

    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
