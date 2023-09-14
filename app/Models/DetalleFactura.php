<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'detalle_facturas';

    /**
     * Relaciones
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
