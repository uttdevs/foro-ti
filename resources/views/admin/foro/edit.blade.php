@extends('admin.layout')
@section('titulo', 'Editar asistente')
@section('contenido')
@php $in = 'w-full p-2 rounded bg-slate-700'; @endphp

<h1 class="text-2xl font-bold text-blue-400">Editar asistente</h1>

<form method="POST" action="{{ route('admin.foro.update', $asistente) }}"
      class="max-w-xl space-y-3 bg-slate-800 p-5 rounded-lg border border-blue-500">
    @csrf @method('PUT')

    @foreach ([['nombre','Nombre'],['apellido_paterno','Apellido paterno'],['apellido_materno','Apellido materno']] as [$campo, $etq])
        <input class="{{ $in }}" type="text" name="{{ $campo }}" placeholder="{{ $etq }}"
               value="{{ old($campo, $asistente->$campo) }}" required>
    @endforeach

    <input class="{{ $in }}" type="number" name="edad" placeholder="Edad" value="{{ old('edad', $asistente->edad) }}" required>

    <input class="{{ $in }}" type="text" name="matricula" placeholder="Matrícula (8 números)"
           maxlength="8" pattern="\d{8}" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')"
           value="{{ old('matricula', $asistente->matricula) }}" required>

    <select class="{{ $in }}" name="carrera_id" required>
        @foreach ($carreras as $c)
            <option value="{{ $c->id }}" @selected(old('carrera_id', $asistente->carrera_id) == $c->id)>{{ $c->nombre }}</option>
        @endforeach
    </select>

    <select class="{{ $in }}" name="cuatrimestre" required>
        @foreach ([1, 4, 7, 10] as $cuatri)
            <option value="{{ $cuatri }}" @selected(old('cuatrimestre', $asistente->cuatrimestre) == $cuatri)>Cuatrimestre {{ $cuatri }}</option>
        @endforeach
    </select>

    <select class="{{ $in }}" name="taller_id">
        <option value="">Sin taller</option>
        @foreach ($talleres as $t)
            @php $lleno = $t->asistentes_count >= $t->cupo && $t->id !== $asistente->taller_id; @endphp
            <option value="{{ $t->id }}" @selected(old('taller_id', $asistente->taller_id) == $t->id) @disabled($lleno)>
                {{ $t->nombre }} ({{ $t->asistentes_count }}/{{ $t->cupo }}){{ $lleno ? ' - LLENO' : '' }}
            </option>
        @endforeach
    </select>

    <input class="{{ $in }}" type="email" name="correo" placeholder="Correo"
           value="{{ old('correo', $asistente->correo) }}" required>

    <input class="{{ $in }}" type="tel" name="telefono" placeholder="Teléfono (10 números)"
           maxlength="10" pattern="\d{10}" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')"
           value="{{ old('telefono', $asistente->telefono) }}">

    <div class="flex gap-2">
        <button class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded font-semibold">Guardar cambios</button>
        <a href="{{ route('admin.foro') }}" class="bg-slate-600 px-4 py-2 rounded">Cancelar</a>
    </div>
</form>
@endsection