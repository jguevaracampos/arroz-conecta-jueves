<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariedadArroz extends Model
{
    use HasFactory;

    protected $table = 'variedades_arroz';

    protected $fillable = ['nombre', 'dias_ciclo', 'descripcion', 'rendimiento_estimado_ton'];

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }
}
