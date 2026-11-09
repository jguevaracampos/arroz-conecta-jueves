<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapaFenologica extends Model
{
    use HasFactory;

    protected $table = 'etapas_fenologicas';

    protected $fillable = [
        'orden',
        'nombre',
        'rango_dias',
        'porcentaje_inicio',
        'porcentaje_fin',
        'descripcion',
        'recomendaciones',
    ];
}
