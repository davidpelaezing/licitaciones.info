<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'productos';

    /* Relaciones */

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
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

    /**
     * Actualiza la url de la imagen
     * @return boolean
     */
    public function actualizarImagen($ruta): bool
    {
        return $this->update([
            'imagen_url' => $ruta
        ]);
    }

    public function scopeWhereCategoria($query, $categoria_id)
    {
        if ($categoria_id) {
            return $query->where('categoria_id', $categoria_id);
        }
    }

    public function scopeOrderPrecio($query, $order)
    {
        if ($order) {
            return $query->orderBy('precio', $order);
        }
    }
}
