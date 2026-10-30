<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsistenteForoRequest;
use App\Models\AsistenteForo;
use App\Models\Carrera;
use App\Models\Taller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalForo'  => AsistenteForo::count(),
            'sinTaller'  => AsistenteForo::whereNull('taller_id')->count(),
            'talleres'   => Taller::withCount('asistentes')->orderBy('id')->get(),
            'porCarrera' => Carrera::withCount('asistentes')->orderByDesc('asistentes_count')->get(),
        ]);
    }

    public function foro(Request $request)
    {
        return view('admin.foro.index', [
            'asistentes' => $this->asistentesFiltrados($request)->latest()->paginate(20)->withQueryString(),
            'carreras'   => Carrera::orderBy('nombre')->get(),
            'talleres'   => Taller::orderBy('id')->get(),
        ]);
    }

    public function foroEditar(AsistenteForo $asistente)
    {
        return view('admin.foro.edit', [
            'asistente' => $asistente,
            'carreras'  => Carrera::orderBy('nombre')->get(),
            'talleres'  => Taller::withCount('asistentes')->orderBy('id')->get(),
        ]);
    }

    public function foroActualizar(AsistenteForoRequest $request, AsistenteForo $asistente)
    {
        $datos = $request->validated();

        return DB::transaction(function () use ($datos, $asistente) {
            // Si cambia de taller, respeta el cupo
            if (! empty($datos['taller_id']) && (int) $datos['taller_id'] !== (int) $asistente->taller_id) {
                $taller = Taller::lockForUpdate()->findOrFail($datos['taller_id']);

                if (AsistenteForo::where('taller_id', $taller->id)->count() >= $taller->cupo) {
                    return back()->withInput()->withErrors([
                        'taller_id' => "El taller \"{$taller->nombre}\" ya está lleno.",
                    ]);
                }
            }

            $asistente->update($datos);

            return redirect()->route('admin.foro')->with('ok', 'Registro actualizado.');
        });
    }

    public function foroEliminar(AsistenteForo $asistente)
    {
        $asistente->delete(); // su lugar en el taller se libera solo
        return back()->with('ok', 'Registro eliminado.');
    }

    public function foroPdf(Request $request)
    {
        $asistentes = $this->asistentesFiltrados($request)
            ->orderBy('apellido_paterno')->orderBy('apellido_materno')->get();

        $partes = [];
        if ($request->filled('carrera_id'))   $partes[] = 'Carrera: ' . Carrera::find($request->carrera_id)?->nombre;
        if ($request->filled('cuatrimestre')) $partes[] = 'Cuatrimestre: ' . $request->cuatrimestre;
        if ($request->filled('taller_id'))    $partes[] = 'Taller: ' . ($request->taller_id === 'ninguno' ? 'Sin taller' : Taller::find($request->taller_id)?->nombre);
        if ($request->filled('buscar'))       $partes[] = 'Búsqueda: "' . $request->buscar . '"';
        $filtros = $partes ? implode(' | ', $partes) : 'Sin filtros (todos los registros)';

        return Pdf::loadView('admin.pdf.foro', compact('asistentes', 'filtros'))
            ->setPaper('letter', 'landscape')
            ->download('asistentes-foro-ti-2026.pdf');
    }

    private function asistentesFiltrados(Request $r)
    {
        return AsistenteForo::with(['carrera', 'taller'])
            ->when($r->filled('buscar'), function ($q) use ($r) {
                $t = '%' . $r->buscar . '%';
                $q->where(function ($w) use ($t) {
                    $w->whereRaw("CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) LIKE ?", [$t])
                      ->orWhere('matricula', 'like', $t)
                      ->orWhere('correo', 'like', $t);
                });
            })
            ->when($r->filled('carrera_id'), fn ($q) => $q->where('carrera_id', $r->carrera_id))
            ->when($r->filled('cuatrimestre'), fn ($q) => $q->where('cuatrimestre', $r->cuatrimestre))
            ->when($r->filled('taller_id'), fn ($q) => $r->taller_id === 'ninguno'
                ? $q->whereNull('taller_id')
                : $q->where('taller_id', $r->taller_id));
    }
}