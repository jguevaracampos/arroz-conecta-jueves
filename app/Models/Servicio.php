<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'categoria',
        'descripcion',
        'precio',
        'unidad_precio',
        'departamento',
        'municipio',
        'contacto_telefono',
        'contacto_whatsapp',
        'imagen',
        'disponible',
    ];

    protected function casts(): array
    {
        return [
            'disponible' => 'boolean',
            'precio' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
