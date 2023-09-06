<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            'Electrónica',
            'Ropa',
            'Hogar y Jardín',
            'Deportes',
            'Salud y Belleza',
            'Juguetes',
            'Automóviles',
            'Electrodomésticos',
            'Libros',
            'Alimentos y Bebidas',
            'Muebles',
            'Música',
            'Electrónica de Consumo',
            'Bebés y Niños',
            'Joyas',
            'Arte y Manualidades',
            'Instrumentos Musicales',
            'Computadoras',
            'Viajes',
            'Cine y TV',
            'Animales y Mascotas',
            'Fotografía',
            'Juegos de Mesa',
            'Ropa Deportiva',
            'Calzado',
            'Camping y Senderismo',
            'Relojes',
            'Bolsos y Carteras',
            'Electrónica para el Hogar',
            'Miselaneas'
        ];

        // Inserta las categorías en la base de datos
        foreach ($categorias as $categoria) {
            Categoria::create([
                'nombre' => $categoria,
            ]);
        }
    }
}
