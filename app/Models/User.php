<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'recovery_codes', 'telefono', 'departamento', 'municipio', 'vereda', 'direccion', 'avatar', 'rol', 'data_policy_accepted_at'])]
#[Hidden(['password', 'remember_token', 'recovery_codes'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'data_policy_accepted_at' => 'datetime',
            'password' => 'hashed',
            'recovery_codes' => 'encrypted:array',
        ];
    }

    public function fincas()
    {
        return $this->hasMany(Finca::class);
    }

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }
}
