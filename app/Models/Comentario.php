<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    /* Relaciones */

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
