<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsistenteForoRequest;
use App\Models\Carrera;

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
        // No se guarda en la BD todavía: se guarda al elegir taller
        session(['pre_registro' => $request->validated()]);

        if ($request->expectsJson()) {
            return response()->json(['redirect' => route('talleres')]);
        }

        return redirect()->route('talleres');
    }
}