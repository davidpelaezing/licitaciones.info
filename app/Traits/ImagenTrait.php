<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImagenTrait
{

    /**
     * sube una imagen y retorna un unique id 
     * @param string $ruta
     * @param file $file
     * @return string
     * @author David Peláez
     */
    public function subirImagen($ruta, $file): string
    {
        $nombre_unique = uniqid() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($ruta, $file, $nombre_unique);
        return $nombre_unique;
    }

    /**
     * elimina una imagen de la base de datos
     * @param string|Array $rutas
     * @return boolean
     * @author David Peláez
     */
    public function eliminarImagen($rutas): bool
    {
        return Storage::delete($rutas);
    }
}
