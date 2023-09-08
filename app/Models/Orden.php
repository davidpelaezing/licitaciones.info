<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * verifica que la orden este activa
     * @return bool
     * @author David Peláez
     */
    public function isActivo()
    {
        return $this->estado_id === 1;
    }
}
