<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $correo = env('ADMIN_EMAIL');
        $clave = env('ADMIN_PASSWORD');

        $isInteractive = $this->command ? $this->command->getOutput()->isInteractive() : false;

        if ((!$correo || !$clave) && $isInteractive) {
            $correo = $this->command->ask('Correo del administrador');
            $clave  = $this->command->secret('Contraseña del administrador (mínimo 10 caracteres)');

            if (! $correo || strlen((string) $clave) < 10) {
                $this->command->error('Correo o contraseña no válidos. No se creó el administrador.');
                return;
            }
        }

        $correo = $correo ?: 'admin@gmail.com';
        $clave  = $clave ?: 'admin12345';

        User::updateOrCreate(
            ['email' => $correo],
            ['name' => 'Administrador', 'password' => Hash::make($clave)]
        );

        if ($this->command) {
            $this->command->info("Administrador listo: {$correo}");
        }
    }
}