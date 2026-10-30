<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('talleres', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 20);
            $table->string('nombre', 150);
            $table->unsignedInteger('cupo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talleres');
    }
};
