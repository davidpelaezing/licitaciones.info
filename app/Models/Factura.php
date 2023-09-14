<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'facturas';

    /** Relaciones */
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class);
    }
}
