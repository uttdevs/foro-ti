@extends('admin.layout')
@section('titulo', 'Asistentes al Foro')
@section('contenido')
@php $in = 'p-2 rounded bg-slate-700'; @endphp

<div class="flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold text-blue-400">Asistentes al Foro ({{ $asistentes->total() }})</h1>
    <a href="{{ route('admin.foro.pdf', request()->query()) }}"
       class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded font-semibold">Descargar PDF</a>
</div>

<form method="GET" class="grid gap-2 md:grid-cols-7 bg-slate-800 p-4 rounded">
    <input name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, matrícula o correo" class="{{ $in }} md:col-span-2">
    <select name="carrera_id" class="{{ $in }}">
        <option value="">Todas las carreras / universidades</option>
        @foreach ($carreras as $c)
            <option value="{{ $c->id }}" @selected(request('carrera_id') == $c->id)>{{ $c->nombre }}</option>
        @endforeach
    </select>
    <select name="cuatrimestre" class="{{ $in }}">
        <option value="">Todos los cuatrimestres</option>
        @foreach ([1, 4, 7, 10] as $cuatri)
            <option value="{{ $cuatri }}" @selected(request('cuatrimestre') == $cuatri)>Cuatrimestre {{ $cuatri }}</option>
        @endforeach
    </select>
    <select name="taller_id" class="{{ $in }}">
        <option value="">Todos los talleres</option>
        <option value="ninguno" @selected(request('taller_id') === 'ninguno')>Sin taller</option>
        @foreach ($talleres as $t)
            <option value="{{ $t->id }}" @selected(request('taller_id') == $t->id)>{{ $t->nombre }}</option>
        @endforeach
    </select>
    <select name="habilitado" class="{{ $in }}">
        <option value="">Todos (pago)</option>
        <option value="1" @selected(request('habilitado') === '1')>Pagaron ✓</option>
        <option value="0" @selected(request('habilitado') === '0')>No han pagado</option>
    </select>
    <div class="flex gap-2">
        <button class="bg-blue-600 hover:bg-blue-500 px-3 rounded flex-1">Filtrar</button>
        <a href="{{ route('admin.foro') }}" class="bg-slate-600 px-3 py-2 rounded">Limpiar</a>
    </div>
</form>

{{-- Vista Móvil (Tarjetas para celular) --}}
<div class="block md:hidden space-y-3">
    @forelse ($asistentes as $a)
        <div class="bg-slate-800 border border-slate-700 rounded-lg p-4 space-y-3 shadow-sm">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <h3 class="font-bold text-white text-base">
                        {{ $a->apellido_paterno }} {{ $a->apellido_materno }} {{ $a->nombre }}
                    </h3>
                    <p class="text-xs text-blue-400 font-mono mt-0.5">
                        Matrícula: <strong class="text-white">{{ $a->matricula }}</strong> · {{ $a->edad }} años
                    </p>
                </div>

                {{-- Toggle habilitado --}}
                <div class="flex flex-col items-center">
                    <span class="text-[10px] uppercase font-bold text-slate-400 mb-1">
                        {{ $a->habilitado ? 'Pagó' : 'No pagó' }}
                    </span>
                    <form method="POST" action="{{ route('admin.foro.habilitado', $a) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                                title="{{ $a->habilitado ? 'Quitar acceso al taller' : 'Dar acceso al taller' }}"
                                class="relative inline-flex h-7 w-12 shrink-0 items-center rounded-full transition-colors focus:outline-none {{ $a->habilitado ? 'bg-green-500' : 'bg-slate-600' }}">
                            <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform {{ $a->habilitado ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-slate-900/60 p-2.5 rounded text-xs space-y-1 text-slate-300">
                <p><strong>Uni/Carrera:</strong> {{ $a->carrera->nombre }} (C-{{ $a->cuatrimestre }})</p>
                <p>
                    <strong>Taller:</strong> 
                    @if ($a->taller)
                        <span class="text-green-400 font-semibold">{{ $a->taller->nombre }}</span>
                    @else
                        <span class="text-yellow-400">Sin taller aún</span>
                    @endif
                </p>
                <p class="text-[11px] text-slate-400 truncate">📧 {{ $a->correo }} · 📞 {{ $a->telefono ?? 'S/N' }}</p>
            </div>

            <div class="flex items-center justify-between pt-1 border-t border-slate-700/60 text-xs">
                <span class="text-slate-400 text-[11px]">{{ $a->created_at?->format('d/m H:i') }}</span>
                <div class="flex gap-2">
                    <a href="{{ route('admin.foro.edit', $a) }}" class="bg-blue-600 px-3 py-1 rounded text-white font-medium">Editar</a>
                    <form method="POST" action="{{ route('admin.foro.destroy', $a) }}" onsubmit="return confirm('¿Eliminar este registro?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-600/80 px-2.5 py-1 rounded text-white">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="p-6 text-center text-slate-400 bg-slate-800 rounded">No hay registros con esos filtros.</div>
    @endforelse
</div>

{{-- Vista Desktop (Tabla clásica) --}}
<div class="hidden md:block overflow-x-auto">
    <table class="w-full text-sm bg-slate-800 rounded">
        <thead class="bg-blue-700 text-left">
            <tr>
                <th class="p-2">Nombre</th><th class="p-2">Edad</th><th class="p-2">Matrícula</th>
                <th class="p-2">Carrera / Universidad</th><th class="p-2">Cuatri</th><th class="p-2">Taller</th>
                <th class="p-2">Correo</th><th class="p-2">Teléfono</th><th class="p-2">Registro</th>
                <th class="p-2 text-center">Pagó</th><th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($asistentes as $a)
            <tr class="border-t border-slate-700">
                <td class="p-2">{{ $a->apellido_paterno }} {{ $a->apellido_materno }} {{ $a->nombre }}</td>
                <td class="p-2">{{ $a->edad }}</td>
                <td class="p-2">{{ $a->matricula }}</td>
                <td class="p-2">{{ $a->carrera->nombre }}</td>
                <td class="p-2">{{ $a->cuatrimestre }}</td>
                <td class="p-2">
                    @if ($a->taller)
                        {{ $a->taller->nombre }}
                    @else
                        <span class="text-yellow-400">Sin taller</span>
                    @endif
                </td>
                <td class="p-2">{{ $a->correo }}</td>
                <td class="p-2">{{ $a->telefono }}</td>
                <td class="p-2">{{ $a->created_at?->format('d/m/Y H:i') }}</td>

                {{-- Toggle habilitado --}}
                <td class="p-2 text-center">
                    <form method="POST" action="{{ route('admin.foro.habilitado', $a) }}" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                title="{{ $a->habilitado ? 'Quitar acceso al taller' : 'Dar acceso al taller' }}"
                                class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition-colors focus:outline-none {{ $a->habilitado ? 'bg-green-500' : 'bg-slate-600' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform {{ $a->habilitado ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </form>
                </td>

                <td class="p-2 flex gap-2">
                    <a href="{{ route('admin.foro.edit', $a) }}" class="bg-blue-600 px-2 py-1 rounded">Editar</a>
                    <form method="POST" action="{{ route('admin.foro.destroy', $a) }}"
                          onsubmit="return confirm('¿Eliminar este registro?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-600 px-2 py-1 rounded">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="11" class="p-4 text-center text-slate-400">No hay registros con esos filtros.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $asistentes->links() }}
@endsection
