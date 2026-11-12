<?php

use App\Models\Carrera;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Carrera::firstOrCreate([
            'nombre' => 'Público General / Externo',
        ]);
    }

    public function down(): void
    {
        Carrera::where('nombre', 'Público General / Externo')->delete();
    }
};
