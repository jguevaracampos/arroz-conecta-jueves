<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'finca_id',
        'nombre',
        'area_hectareas',
        'tipo_arroz',
        'variedad_arroz_id',
        'variedad_nombre',
        'fecha_siembra',
        'estado',
        'notas',
    ];

    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    public function variedad()
    {
        return $this->belongsTo(VariedadArroz::class, 'variedad_arroz_id');
    }

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }

    public function sensores()
    {
        return $this->hasMany(Sensor::class);
    }
}
