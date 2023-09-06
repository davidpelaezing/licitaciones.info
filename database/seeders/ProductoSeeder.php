<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = [
            [
                "nombre" => "Teléfono celular Nokia 3310",
                "descripcion" => "El legendario Nokia 3310, famoso por su resistencia y durabilidad, es un teléfono móvil clásico que marcó una era."
            ],

            [
                "nombre" => "Cámara analógica Canon AE-1",
                "descripcion" => "La Canon AE-1 fue una de las cámaras réflex de 35 mm más populares en las décadas de 1970 y 1980, conocida por su calidad de imagen."
            ],

            [
                "nombre" => "Radio de válvulas vintage",
                "descripcion" => "Este antiguo radio de válvulas de la década de 1950 es una joya de la historia de la tecnología de audio."
            ],

            [
                "nombre" => "Máquina de escribir Smith Corona",
                "descripcion" => "La Smith Corona es una máquina de escribir clásica que se usaba ampliamente antes de la llegada de las computadoras."
            ],

            [
                "nombre" => "Tocadiscos Pioneer PL-120",
                "descripcion" => "El tocadiscos Pioneer PL-120 es un equipo de alta fidelidad que permitía disfrutar de vinilos con una calidad excepcional."
            ],

            [
                "nombre" => "Televisor blanco y negro",
                "descripcion" => "Este televisor en blanco y negro fue un elemento común en los hogares antes de la introducción de los televisores a color."
            ],

            [
                "nombre" => "Walkman Sony",
                "descripcion" => "El Walkman de Sony revolucionó la música portátil en la década de 1980, permitiendo a las personas escuchar cassettes mientras se desplazaban."
            ],

            [
                "nombre" => "Máquina de coser Singer",
                "descripcion" => "La máquina de coser Singer es un clásico de la costura y ha estado presente en los hogares durante generaciones."
            ],

            [
                "nombre" => "Computadora Apple Macintosh",
                "descripcion" => "El Macintosh original de Apple fue una de las primeras computadoras personales con una interfaz gráfica de usuario."
            ],

            [
                "nombre" => "Consola de videojuegos Atari 2600",
                "descripcion" => "La Atari 2600 fue una de las primeras consolas de videojuegos domésticas y una pionera en la industria."
            ],

            [
                "nombre" => "Reproductor de cassette Sony",
                "descripcion" => "Este reproductor de cassette Sony era esencial para aquellos que querían escuchar música en cassettes."
            ],

            [
                "nombre" => "Máquina de escribir electrónica IBM Selectric",
                "descripcion" => "La IBM Selectric fue una máquina de escribir avanzada en su época y una herramienta común en oficinas."
            ],

            [
                "nombre" => "Calculadora HP 12C",
                "descripcion" => "La calculadora financiera HP 12C es un dispositivo clásico utilizado en el mundo de las finanzas."
            ],

            [
                "nombre" => "Cámara de película Kodak Instamatic",
                "descripcion" => "La Kodak Instamatic fue una cámara popular para la fotografía de película en la década de 1960."
            ],

            [
                "nombre" => "Reproductor de CD Sony Discman",
                "descripcion" => "El Sony Discman permitía a las personas llevar su música en formato CD a cualquier lugar."
            ],

            [
                "nombre" => "Máquina de escribir portátil",
                "descripcion" => "Esta máquina de escribir portátil era ideal para trabajadores móviles antes de la era digital."
            ],

            [
                "nombre" => "Teléfono fijo de disco",
                "descripcion" => "Este teléfono fijo con disco rotativo era común en los hogares antes de la llegada de los teléfonos inalámbricos."
            ],

            [
                "nombre" => "Cámara de película Polaroid Land",
                "descripcion" => "La cámara Polaroid Land permitía tomar fotos instantáneas en la década de 1970."
            ],

            [
                "nombre" => "Máquina de escribir Olivetti",
                "descripcion" => "Las máquinas de escribir Olivetti eran conocidas por su diseño elegante y su calidad de escritura."
            ],

            [
                "nombre" => "Reproductor de vinilos Philips",
                "descripcion" => "El reproductor de vinilos Philips brindaba una experiencia musical auténtica con discos de vinilo."
            ],

            [
                "nombre" => "Computadora Commodore 64",
                "descripcion" => "El Commodore 64 fue una de las primeras computadoras personales populares con una amplia biblioteca de juegos."
            ],

            [
                "nombre" => "Máquina de fax",
                "descripcion" => "Las máquinas de fax eran comunes en entornos comerciales para enviar documentos por fax."
            ],

            [
                "nombre" => "Cámara de película Minolta",
                "descripcion" => "Las cámaras Minolta eran conocidas por su calidad de imagen y versatilidad."
            ],

            [
                "nombre" => "Teléfono público de cabina",
                "descripcion" => "Las cabinas telefónicas públicas solían ser el lugar para realizar llamadas en la calle."
            ],

            [
                "nombre" => "Radiograbadora boombox",
                "descripcion" => "Los radiograbadoras boombox eran populares en la década de 1980 y permitían escuchar música en cualquier lugar."
            ],

            [
                "nombre" => "Máquina de escribir eléctrica",
                "descripcion" => "Las máquinas de escribir eléctricas eran una actualización moderna de las máquinas de escribir manuales."
            ],

            [
                "nombre" => "Reproductor de cintas VHS",
                "descripcion" => "Los reproductores de cintas VHS permitían ver películas y grabar programas de televisión."
            ],

            [
                "nombre" => "Calculadora científica Casio",
                "descripcion" => "Las calculadoras científicas Casio eran utilizadas por estudiantes y profesionales para cálculos avanzados."
            ],

            [
                "nombre" => "Cámara de película Yashica",
                "descripcion" => "Las cámaras Yashica eran conocidas por su calidad óptica y diseño."
            ],

            [
                "nombre" => "Televisor CRT",
                "descripcion" => "Los televisores CRT eran la tecnología estándar antes de la llegada de las pantallas planas."
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create([
                'categoria_id' => rand(1, 30),
                "nombre" => $producto["nombre"],
                "descripcion" => $producto["descripcion"],
                'precio' => rand(10, 1000),
            ]);
        }
    }
}
