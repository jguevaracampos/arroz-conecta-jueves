<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsejoSemanal extends Model
{
    use HasFactory;

    protected $table = 'consejos_semanales';

    protected $fillable = [
        'titulo',
        'consejo',
        'autor',
        'etapa_relevante',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }
}
