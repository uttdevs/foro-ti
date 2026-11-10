<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Taller;
use Illuminate\Database\Seeder;

class ForoSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            'Ingeniería en Mantenimiento Industrial',
            'Ingeniería en Mecatrónica',
            'Ingeniería en Alimentos',
            'Ingeniería en Agricultura Sustentable y Protegida',
            'Ingeniería Industrial',
            'Ingeniería en Tecnologías de la Información e Innovación Digital',
            'Licenciatura en Negocios y Mercadotecnia',
            'Licenciatura en Contaduría',
            'Licenciatura en Administración',
            'Ingeniería en Datos e Inteligencia Artificial',
            'Universidad Tecnológica Del Valle Del Mezquital',
        ];

        foreach ($carreras as $nombre) {
            Carrera::firstOrCreate(['nombre' => $nombre]);
        }

        $talleres = [
            ['clave' => 'analitica-predictiva', 'nombre' => 'Next-Gen Data: Analítica Predictiva y Machine Learning Cloud', 'cupo' => 20],
            ['clave' => 'laptops',              'nombre' => 'Mantenimiento y reparación de Laptops',                         'cupo' => 20],
            ['clave' => 'base-datos',           'nombre' => 'Bases de Datos en Entornos Empresariales',                     'cupo' => 20],
            ['clave' => 'nube-local',           'nombre' => 'Creación y Gestión de Nube Local',                              'cupo' => 20],
            ['clave' => 'chatbots',             'nombre' => 'Creación de Chatbots y asistentes virtuales',                  'cupo' => 20],
            ['clave' => 'spring-boot',          'nombre' => 'Creación de Microservicios Spring Boot',                        'cupo' => 20],
            ['clave' => 'mikrotik',             'nombre' => 'Despliegue de redes MikroTik con apoyo de IA',                 'cupo' => 20],
            ['clave' => 'ia',                   'nombre' => 'Inteligencia Artificial (IA)',                                 'cupo' => 20],
            ['clave' => 'modelado-3d',          'nombre' => 'Modelado e impresion 3D',                                      'cupo' => 20],
        ];

        foreach ($talleres as $taller) {
            Taller::firstOrCreate(['clave' => $taller['clave']], $taller);
        }
    }
}
