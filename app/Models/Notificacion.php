<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'cultivo_id',
        'tipo',
        'titulo',
        'mensaje',
        'nivel',
        'leida',
        'fecha_evento',
    ];

    protected function casts(): array
    {
        return [
            'leida' => 'boolean',
            'fecha_evento' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }
}
