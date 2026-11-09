<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lote_id',
        'variedad_arroz_id',
        'nombre_cultivo',
        'variedad_nombre',
        'fecha_siembra',
        'fecha_estimada_cosecha',
        'area_sembrada',
        'etapa_actual',
        'progreso_porcentaje',
        'dias_transcurridos',
        'estado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_siembra' => 'date',
            'fecha_estimada_cosecha' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function variedad()
    {
        return $this->belongsTo(VariedadArroz::class, 'variedad_arroz_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

    /**
     * Recalcular días transcurridos y etapa fenológica según la fecha de siembra
     */
    public function recalcularProgreso(): void
    {
        if (! $this->fecha_siembra) {
            return;
        }

        $siembra = Carbon::parse($this->fecha_siembra);
        $hoy = Carbon::today();
        $dias = max(0, $siembra->diffInDays($hoy, false));
        $this->dias_transcurridos = $dias;

        $duracionTotal = $this->variedad?->dias_ciclo ?? 125;
        $porcentaje = min(100, (int) round(($dias / $duracionTotal) * 100));
        $this->progreso_porcentaje = $porcentaje;

        if (! $this->fecha_estimada_cosecha) {
            $this->fecha_estimada_cosecha = $siembra->copy()->addDays($duracionTotal);
        }

        // Determinar etapa fenológica del arroz:
        // 0-15: Germinación y Emergencia
        // 16-45: Macollamiento
        // 46-75: Embuche / Iniciación Panicular
        // 76-100: Floración
        // >100: Maduración
        if ($dias <= 15) {
            $this->etapa_actual = 'Germinación';
        } elseif ($dias <= 45) {
            $this->etapa_actual = 'Macollamiento';
        } elseif ($dias <= 75) {
            $this->etapa_actual = 'Embuche';
        } elseif ($dias <= 100) {
            $this->etapa_actual = 'Floración';
        } else {
            $this->etapa_actual = 'Maduración';
        }
    }
}
