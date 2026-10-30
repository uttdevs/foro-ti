<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistentes_foro', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            $table->unsignedTinyInteger('edad');
            $table->string('matricula', 8)->unique();
            $table->foreignId('carrera_id')->constrained('carreras')->cascadeOnDelete();
            $table->unsignedTinyInteger('cuatrimestre');
            $table->foreignId('taller_id')->nullable()->constrained('talleres')->nullOnDelete();
            $table->string('correo', 100)->unique();
            $table->string('telefono', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistentes_foro');
    }
};
