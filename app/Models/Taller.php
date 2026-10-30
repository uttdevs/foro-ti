<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    protected $table = 'talleres';
    protected $fillable = ['clave', 'nombre', 'cupo'];

    public function asistentes()
    {
        return $this->hasMany(AsistenteForo::class, 'taller_id');
    }
}