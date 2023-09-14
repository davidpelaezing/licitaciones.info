<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'admin',
        'estado',
        'actividad'
    ];

    protected $appends = ['isActivo'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Hashea la password antes de insertar en la base de datos
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /* Funciones */

    /**
     * Cambia el estado, asigna el contrario del actual
     * @return boolean
     */
    public function cambiarEstado(): bool
    {
        return $this->update([
            'estado' => !$this->estado
        ]);
    }

    public function getIsActivoAttribute(): bool
    {
        if ($this->actividad) {
            $actividad = Carbon::parse($this->actividad);
            $diferencia_en_minutos = $actividad->diffInMinutes(Carbon::now());
            return $diferencia_en_minutos < 2;
        } else {
            return false;
        }
    }
}
