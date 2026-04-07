<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = [
        'prisionero_id',
        'visitante_id',
        'guardia_id',
        'fecha_hora_entrada',
        'fecha_hora_salida',
        'estado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora_entrada' => 'datetime',
            'fecha_hora_salida' => 'datetime',
        ];
    }

    public function prisionero(): BelongsTo
    {
        return $this->belongsTo(Prisionero::class);
    }

    public function visitante(): BelongsTo
    {
        return $this->belongsTo(Visitante::class);
    }

    public function guardia(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guardia_id');
    }

    public function scopeConflictoHorario($query, $prisioneroId, $entrada, $salida, $excludeId = null)
    {
        $query->where('prisionero_id', $prisioneroId)
            ->where(function ($q) use ($entrada, $salida) {
                $q->whereBetween('fecha_hora_entrada', [$entrada, $salida])
                    ->orWhereBetween('fecha_hora_salida', [$entrada, $salida])
                    ->orWhere(function ($q2) use ($entrada, $salida) {
                        $q2->where('fecha_hora_entrada', '<=', $entrada)
                            ->where('fecha_hora_salida', '>=', $salida);
                    });
            })
            ->whereNotIn('estado', ['cancelada', 'rechazada']);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query;
    }

    public function scopeEnRangoHorario($query, $fecha, $horaInicio, $horaFin)
    {
        $fechaHoraInicio = Carbon::parse($fecha . ' ' . $horaInicio);
        $fechaHoraFin = Carbon::parse($fecha . ' ' . $horaFin);

        return $query->whereBetween('fecha_hora_entrada', [$fechaHoraInicio, $fechaHoraFin]);
    }
}
