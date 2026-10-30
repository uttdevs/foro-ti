<?php

namespace App\Http\Controllers;

use App\Mail\InscripcionConfirmada;
use App\Models\AsistenteForo;
use App\Models\Taller;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TallerController extends Controller
{
    public function index()
    {
        if (! session()->has('pre_registro')) {
            return redirect()->route('registro');
        }

        return view('spa');
    }

    public function lista()
    {
        return response()->json($this->datos());
    }

    public function inscribir(Request $request)
    {
        $datos = session('pre_registro');

        if (! $datos) {
            return response()->json([
                'mensaje'  => 'Tu sesión expiró. Vuelve a llenar el formulario.',
                'redirect' => route('registro'),
            ], 409);
        }

        $request->validate(['taller_id' => 'required|exists:talleres,id']);

        try {
            $resultado = DB::transaction(function () use ($request, $datos) {
                // Bloquea la fila del taller: dos personas a la vez no pueden pasarse del cupo
                $taller = Taller::lockForUpdate()->findOrFail($request->taller_id);
                $ocupados = AsistenteForo::where('taller_id', $taller->id)->count();

                if ($ocupados >= $taller->cupo) {
                    return null;
                }

                $asistente = AsistenteForo::create($datos + ['taller_id' => $taller->id]);

                return [
                    'asistente' => $asistente,
                    'taller'    => $taller->nombre,
                    'lugares'   => $taller->cupo - $ocupados - 1,
                ];
            });
        } catch (UniqueConstraintViolationException $e) {
            session()->forget('pre_registro');

            return response()->json([
                'mensaje'  => 'Esa matrícula o correo ya está registrada.',
                'redirect' => route('registro'),
            ], 422);
        }

        if ($resultado === null) {
            return response()->json([
                'agotado'  => true,
                'mensaje'  => 'Ese taller se acaba de llenar. Elige otro.',
                'talleres' => $this->datos(),
            ], 409);
        }

        session()->forget('pre_registro');

        // Correo de confirmación: se envía después de responder y nunca rompe la inscripción
        $asistente = $resultado['asistente']->load(['carrera', 'taller']);

        dispatch(function () use ($asistente) {
            try {
                Mail::to($asistente->correo)->send(new InscripcionConfirmada($asistente));
            } catch (\Throwable $e) {
                report($e);
            }
        })->afterResponse();

        return response()->json([
            'ok'      => true,
            'taller'  => $resultado['taller'],
            'lugares' => $resultado['lugares'],
            'mensaje' => "¡Listo! Quedaste inscrito en {$resultado['taller']}.",
        ]);
    }

    private function datos()
    {
        return Taller::withCount('asistentes')->orderBy('id')->get()->map(fn ($t) => [
            'id'      => $t->id,
            'clave'   => $t->clave,
            'nombre'  => $t->nombre,
            'cupo'    => $t->cupo,
            'lugares' => max(0, $t->cupo - $t->asistentes_count),
        ])->values();
    }
}