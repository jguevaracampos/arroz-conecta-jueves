<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicionSensor extends Model
{
    use HasFactory;

    protected $table = 'mediciones_sensor';

    protected $fillable = [
        'sensor_id',
        'lote_id',
        'humedad_suelo',
        'humedad_aire',
        'temperatura',
        'ph',
        'estado_humedad',
        'origen',
    ];

    protected function casts(): array
    {
        return [
            'humedad_suelo' => 'float',
            'humedad_aire' => 'float',
            'temperatura' => 'float',
            'ph' => 'float',
        ];
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
