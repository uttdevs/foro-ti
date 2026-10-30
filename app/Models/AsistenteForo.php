<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenteForo extends Model
{
    protected $table = 'asistentes_foro';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'edad',
        'matricula',
        'carrera_id',
        'cuatrimestre',
        'taller_id',
        'correo',
        'telefono',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function taller()
    {
        return $this->belongsTo(Taller::class, 'taller_id');
    }
}