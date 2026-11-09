<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensores';

    protected $fillable = [
        'user_id',
        'lote_id',
        'codigo_sensor',
        'nombre',
        'tipo',
        'estado',
        'bateria_porcentaje',
        'ultima_conexion',
    ];

    protected function casts(): array
    {
        return [
            'ultima_conexion' => 'datetime',
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

    public function mediciones()
    {
        return $this->hasMany(MedicionSensor::class)->latest();
    }

    public function ultimaMedicion()
    {
        return $this->hasOne(MedicionSensor::class)->latestOfMany();
    }
}
