<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Orden extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'ordenes';

    /* Relaciones */
    public function detalles()
    {
        return $this->hasMany(DetalleOrden::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    /* Funciones */

    /**
     * Cambia el estado de la orden
     * @param int $estado_id
     * @return boolean
     * @author David Peláez
     */
    public function cambiarEstado($estado_id): bool
    {
        return $this->update([
            'estado_id' => $estado_id
        ]);
    }

    /**
     * verifica que la orden este activa
     * @return bool
     * @author David Peláez
     */
    public function isActivo(): bool
    {
        return $this->estado_id === 1;
    }

    /**
     * verifica que el detalle pertenesca a una orden del usuario autenticado
     * @return bool
     * @author David Peláez
     */
    public function mePertenece(): bool
    {
        return $this->user_id === Auth::id();
    }
}
