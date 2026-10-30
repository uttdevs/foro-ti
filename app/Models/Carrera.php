<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carreras';
    protected $fillable = ['nombre'];

    public function asistentes()
    {
        return $this->hasMany(AsistenteForo::class, 'carrera_id');
    }
}