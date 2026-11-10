<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsistenteForoRequest;
use App\Models\Carrera;
use App\Models\AsistenteForo;

class FormularioController extends Controller
{
    public function index()
    {
        return view('registro', [
            'carreras' => Carrera::orderBy('nombre')->get(),
        ]);
    }

    public function guardarForo(AsistenteForoRequest $request)
    {
        $carrera = Carrera::find($request->carrera_id);
        $esForaneo = $carrera && str_contains(strtolower($carrera->nombre), 'valle del mezquital');

        $asistente = AsistenteForo::create($request->validated() + [
            'habilitado' => $esForaneo,
        ]);

        if ($esForaneo) {
            session(['asistente_id' => $asistente->id]);

            return redirect()->route('talleres');
        }

        return redirect()->route('registro.completado');
    }
}
