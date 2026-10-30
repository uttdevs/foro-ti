@extends('admin.layout')
@section('titulo', 'Asistentes al Foro')
@section('contenido')
@php $in = 'p-2 rounded bg-slate-700'; @endphp

<div class="flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold text-blue-400">Asistentes al Foro ({{ $asistentes->total() }})</h1>
    <a href="{{ route('admin.foro.pdf', request()->query()) }}"
       class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded font-semibold">Descargar PDF</a>
</div>

<form method="GET" class="grid gap-2 md:grid-cols-6 bg-slate-800 p-4 rounded">
    <input name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, matrícula o correo" class="{{ $in }} md:col-span-2">
    <select name="carrera_id" class="{{ $in }}">
        <option value="">Todas las carreras</option>
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
    <div class="flex gap-2">
        <button class="bg-blue-600 hover:bg-blue-500 px-3 rounded flex-1">Filtrar</button>
        <a href="{{ route('admin.foro') }}" class="bg-slate-600 px-3 py-2 rounded">Limpiar</a>
    </div>
</form>

<div class="overflow-x-auto">
    <table class="w-full text-sm bg-slate-800 rounded">
        <thead class="bg-blue-700 text-left">
            <tr>
                <th class="p-2">Nombre</th><th class="p-2">Edad</th><th class="p-2">Matrícula</th>
                <th class="p-2">Carrera</th><th class="p-2">Cuatri</th><th class="p-2">Taller</th>
                <th class="p-2">Correo</th><th class="p-2">Teléfono</th><th class="p-2">Registro</th>
                <th class="p-2">Acciones</th>
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
            <tr><td colspan="10" class="p-4 text-center text-slate-400">No hay registros con esos filtros.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $asistentes->links() }}
@endsection