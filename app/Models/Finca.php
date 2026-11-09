<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finca extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'departamento',
        'municipio',
        'vereda',
        'direccion',
        'area_total',
        'propietario',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }
}
