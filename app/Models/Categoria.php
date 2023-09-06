<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'categorias';

    /* Relaciones */

    public function productos()
    {
        $this->hasMany(Producto::class);
    }

    /* Funciones */

    /**
     * Cambia el estado de la categoria, asigna el contrario del actual
     * @return boolean
     */
    public function cambiarEstado(): bool
    {
        return $this->update([
            'estado' => !$this->estado
        ]);
    }
}
