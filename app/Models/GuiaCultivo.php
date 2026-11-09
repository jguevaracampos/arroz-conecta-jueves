<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuiaCultivo extends Model
{
    use HasFactory;

    protected $table = 'guias_cultivo';

    protected $fillable = [
        'etapa',
        'titulo',
        'resumen',
        'contenido',
        'icono',
        'imagen',
        'consejos_clave',
    ];
}
