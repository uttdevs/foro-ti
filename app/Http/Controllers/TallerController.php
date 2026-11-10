<?php

namespace App\Http\Controllers;

use App\Models\AsistenteForo;
use App\Models\Taller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TallerController extends Controller
{
    /**
     * Muestra el formulario para ingresar la matrícula.
     */
    public function buscarMatricula()
    {
        return view('inscribir-taller');
    }

    /**
     * Valida la matrícula y, si el alumno está habilitado, lo manda a elegir taller.
     */
    public function verificarMatricula(Request $request)
    {
        $request->validate(
            ['matricula' => 'required|digits:8'],
            [
                'matricula.required' => 'Ingresa tu matrícula.',
                'matricula.digits'   => 'La matrícula debe tener exactamente 8 números.',
            ]
        );

        $asistente = AsistenteForo::where('matricula', $request->matricula)->first();

        if (! $asistente) {
            return back()->withInput()->withErrors([
                'matricula' => '¡No encontramos tu registro! ¿Ya llenaste el formulario de registro?',
            ]);
        }

        if ($asistente->taller_id) {
            $nombre = $asistente->taller->nombre ?? 'un taller';

            return back()->withInput()->withErrors([
                'matricula' => "Ya estás inscrito en el taller \"{$nombre}\". Solo puedes elegir uno.",
            ]);
        }

        if (! $asistente->habilitado) {
            return back()->withInput()->withErrors([
                'matricula' => 'Aún no puedes seleccionar taller. Acércate a pagar y el equipo te habilitará.',
            ]);
        }

        session(['asistente_id' => $asistente->id]);

        return redirect()->route('talleres');
    }

    /**
     * Muestra el SPA de selección de taller (requiere sesión activa).
     */
    public function index()
    {
        if (! session()->has('asistente_id')) {
            return redirect()->route('taller.buscar');
        }

        return view('spa');
    }

    /**
     * Devuelve la lista de talleres con lugares disponibles (JSON).
     */
    public function lista()
    {
        return response()->json($this->datos());
    }

    /**
     * Inscribe al alumno en el taller seleccionado.
     */
    public function inscribir(Request $request)
    {
        $asistenteId = session('asistente_id');

        if (! $asistenteId) {
            return response()->json([
                'mensaje'  => 'Tu sesión expiró. Vuelve a ingresar tu matrícula.',
                'redirect' => route('taller.buscar'),
            ], 409);
        }

        $asistente = AsistenteForo::find($asistenteId);

        if (! $asistente || ! $asistente->habilitado) {
            session()->forget('asistente_id');

            return response()->json([
                'mensaje'  => 'No tienes permiso para inscribirte. Contacta al equipo del foro.',
                'redirect' => route('taller.buscar'),
            ], 403);
        }

        if ($asistente->taller_id) {
            $nombre = $asistente->taller->nombre ?? 'un taller';

            return response()->json([
                'ok'      => true,
                'taller'  => $nombre,
                'lugares' => 0,
                'mensaje' => "Ya estás inscrito en \"{$nombre}\".",
            ]);
        }

        $request->validate(['taller_id' => 'required|exists:talleres,id']);

        $resultado = DB::transaction(function () use ($request, $asistente) {
            // Bloquea la fila del taller: dos personas a la vez no pueden pasarse del cupo
            $taller   = Taller::lockForUpdate()->findOrFail($request->taller_id);
            $ocupados = AsistenteForo::where('taller_id', $taller->id)->count();

            if ($ocupados >= $taller->cupo) {
                return null;
            }

            $asistente->update(['taller_id' => $taller->id]);

            return [
                'taller'  => $taller->nombre,
                'lugares' => $taller->cupo - $ocupados - 1,
            ];
        });

        if ($resultado === null) {
            return response()->json([
                'agotado'  => true,
                'mensaje'  => 'Ese taller se acaba de llenar. Elige otro.',
                'talleres' => $this->datos(),
            ], 409);
        }

        session()->forget('asistente_id');

        return response()->json([
            'ok'      => true,
            'taller'  => $resultado['taller'],
            'lugares' => $resultado['lugares'],
            'mensaje' => "¡Listo! Quedaste inscrito en {$resultado['taller']}.",
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
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
