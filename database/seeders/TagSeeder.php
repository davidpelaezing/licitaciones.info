<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            "Tecnología",
            "Moda",
            "Hogar",
            "Deportes",
            "Salud",
            "Juguetes",
            "Automóviles",
            "Electrodomésticos",
            "Literatura",
            "Alimentos",
            "Belleza",
            "Juegos",
            "Música",
            "Electrónica",
            "Viajes",
            "Cine",
            "Animales",
            "Fotografía",
            "Juegos de Mesa",
            "Ropa Deportiva",
            "Calzado",
            "Camping",
            "Relojes",
            "Bolsos",
            "Cocina",
            "Jardinería",
            "Electrónica de Consumo",
            "Joyería",
            "Arte",
            "Herramientas",
        ];

        // Inserta las categorías en la base de datos
        foreach ($tags as $tag) {
            Tag::create([
                'nombre' => $tag,
            ]);
        }
    }
}
