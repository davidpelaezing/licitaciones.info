<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'detalle_ordenes';

    /* Relaciones */
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /* Funciones */

    /**
     * verifica que el detalle pertenesca a una orden del usuario autenticado
     * @return bool
     * @author David Peláez
     */
    public function mePertenece()
    {
        return $this->orden->user_id === Auth::id();
    }
}
