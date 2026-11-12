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
        $asistente = AsistenteForo::create($request->validated() + [
            'habilitado' => false,
        ]);

        return redirect()->route('registro.completado')->with('matricula_registrada', $asistente->matricula);
    }
}
