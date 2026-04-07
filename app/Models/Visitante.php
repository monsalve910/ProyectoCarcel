<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visitante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'numero_identificacion',
        'telefono',
        'parentesco',
        'direccion',
        'estado',
    ];

    protected function casts(): array
    {
        return [
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
