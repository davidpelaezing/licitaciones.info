<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'tags';

    /* Relaciones */

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
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
}
