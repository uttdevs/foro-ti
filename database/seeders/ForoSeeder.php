<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Taller;
use Illuminate\Database\Seeder;

class ForoSeeder extends Seeder
{
    public function run(): void
    {
        // Carreras típicas de una universidad politécnica
        $carreras = [
            'Ingeniería en Tecnologías de la Información',
            'Ingeniería en Desarrollo de Software',
            'Ingeniería en Redes y Telecomunicaciones',
            'Ingeniería en Sistemas Computacionales',
            'Ingeniería en Animación y Efectos Visuales',
            'Licenciatura en Administración',
            'Ingeniería Industrial',
        ];

        foreach ($carreras as $nombre) {
            Carrera::firstOrCreate(['nombre' => $nombre]);
        }

        // Talleres de ejemplo
        $talleres = [
            ['clave' => 'T01', 'nombre' => 'Introducción a la IA Generativa',        'cupo' => 30],
            ['clave' => 'T02', 'nombre' => 'Ciberseguridad para Principiantes',       'cupo' => 25],
            ['clave' => 'T03', 'nombre' => 'Desarrollo Web con Laravel y React',      'cupo' => 30],
            ['clave' => 'T04', 'nombre' => 'Cloud Computing con AWS',                 'cupo' => 20],
            ['clave' => 'T05', 'nombre' => 'Desarrollo de Apps Móviles con Flutter',  'cupo' => 25],
        ];

        foreach ($talleres as $taller) {
            Taller::firstOrCreate(['clave' => $taller['clave']], $taller);
        }
    }
}
