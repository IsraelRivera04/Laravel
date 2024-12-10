<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Juego;

class JuegosSeeder extends Seeder
{
    public function run()
    {
        // Juegos de mesa reales con datos reales
        $juegos = [
            [
                'nombre' => 'Catan',
                'descripcion' => 'Catan es un juego de mesa de estrategia en el que los jugadores compiten por colonizar una isla ficticia.',
                'edicion' => 'Edición 2015',
                'num_jugadores_min' => 3,
                'num_jugadores_max' => 4,
                'edad_recomendada' => 10,
                'duracion_aprox' => 60,
                'editor' => 'Kosmos',
                'disenador' => 'Klaus Teuber',
                'ano_publicacion' => 1995,
                'dureza' => 2.50,
                'precio' => 40.00,
                'rating' => 8.20,
                'imagen' => '',
                'stock' => 50,
            ],
            [
                'nombre' => 'Carcassonne',
                'descripcion' => 'Un juego de mesa donde los jugadores colocan piezas de terreno para formar paisajes medievales.',
                'edicion' => 'Edición 2014',
                'num_jugadores_min' => 2,
                'num_jugadores_max' => 5,
                'edad_recomendada' => 8,
                'duracion_aprox' => 35,
                'editor' => 'Hans im Glück',
                'disenador' => 'Klaus-Jürgen Wrede',
                'ano_publicacion' => 2000,
                'dureza' => 2.00,
                'precio' => 30.00,
                'rating' => 7.80,
                'imagen' => '',
                'stock' => 40,
            ],
            [
                'nombre' => 'Ticket to Ride',
                'descripcion' => 'Un juego de mesa de estrategia en el que los jugadores coleccionan cartas de trenes para reclamar rutas en un mapa.',
                'edicion' => 'Edición 2004',
                'num_jugadores_min' => 2,
                'num_jugadores_max' => 5,
                'edad_recomendada' => 8,
                'duracion_aprox' => 60,
                'editor' => 'Days of Wonder',
                'disenador' => 'Alan R. Moon',
                'ano_publicacion' => 2004,
                'dureza' => 2.00,
                'precio' => 45.00,
                'rating' => 8.50,
                'imagen' => '',
                'stock' => 30,
            ],
            [
                'nombre' => 'Pandemic',
                'descripcion' => 'Pandemic es un juego cooperativo en el que los jugadores trabajan juntos para detener la propagación de enfermedades mortales.',
                'edicion' => 'Edición 2008',
                'num_jugadores_min' => 2,
                'num_jugadores_max' => 4,
                'edad_recomendada' => 8,
                'duracion_aprox' => 45,
                'editor' => 'Z-Man Games',
                'disenador' => 'Matt Leacock',
                'ano_publicacion' => 2008,
                'dureza' => 3.00,
                'precio' => 35.00,
                'rating' => 8.70,
                'imagen' => '',
                'stock' => 20,
            ],
            [
                'nombre' => 'Azul',
                'descripcion' => 'Azul es un juego de estrategia y habilidad donde los jugadores deben colocar azulejos para completar patrones.',
                'edicion' => 'Edición 2017',
                'num_jugadores_min' => 2,
                'num_jugadores_max' => 4,
                'edad_recomendada' => 8,
                'duracion_aprox' => 30,
                'editor' => 'Plan B Games',
                'disenador' => 'Michael Kiesling',
                'ano_publicacion' => 2017,
                'dureza' => 2.50,
                'precio' => 25.00,
                'rating' => 8.30,
                'imagen' => '',
                'stock' => 25,
            ],
        ];

        // Insertar los juegos en la base de datos
        foreach ($juegos as $juego) {
            Juego::create($juego);
        }
    }
}
