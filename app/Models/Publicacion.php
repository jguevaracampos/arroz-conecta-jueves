<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'user_id',
        'categoria',
        'titulo',
        'contenido',
        'imagen',
        'likes_count',
        'reportada',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->latest();
    }

    public function reacciones()
    {
        return $this->hasMany(Reaccion::class);
    }

    public function isLikedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->reacciones()->where('user_id', $user->id)->exists();
    }
}
