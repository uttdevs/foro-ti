@extends('admin.layout')
@section('titulo', 'Panel')
@section('contenido')
<h1 class="text-2xl font-bold text-blue-400">Panel de administración</h1>

<div class="grid gap-4 md:grid-cols-3">
    <a href="{{ route('admin.foro') }}" class="block bg-slate-800 border border-blue-500 p-5 rounded-lg hover:bg-slate-700">
        <p class="text-slate-400">Asistentes al Foro</p>
        <p class="text-4xl font-bold text-blue-400">{{ $totalForo }}</p>
    </a>
    <div class="bg-slate-800 border border-green-500 p-5 rounded-lg">
        <p class="text-slate-400">Con taller</p>
        <p class="text-4xl font-bold text-green-400">{{ $totalForo - $sinTaller }}</p>
    </div>
    <a href="{{ route('admin.foro', ['taller_id' => 'ninguno']) }}" class="block bg-slate-800 border border-yellow-500 p-5 rounded-lg hover:bg-slate-700">
        <p class="text-slate-400">Sin taller</p>
        <p class="text-4xl font-bold text-yellow-400">{{ $sinTaller }}</p>
    </a>
</div>

<div class="bg-slate-800 p-5 rounded-lg space-y-3">
    <h2 class="font-semibold">Ocupación por taller</h2>
    @foreach ($talleres as $t)
        @php
            $pct = $t->cupo > 0 ? min(100, round($t->asistentes_count / $t->cupo * 100)) : 0;
            $lleno = $t->asistentes_count >= $t->cupo;
        @endphp
        <a href="{{ route('admin.foro', ['taller_id' => $t->id]) }}" class="block hover:bg-slate-700 rounded p-2">
            <div class="flex justify-between text-sm">
                <span>{{ $t->nombre }}</span>
                <span class="{{ $lleno ? 'text-red-400 font-bold' : 'text-slate-300' }}">
                    {{ $t->asistentes_count }}/{{ $t->cupo }}{{ $lleno ? ' · LLENO' : '' }}
                </span>
            </div>
            <div class="mt-1 h-2 rounded bg-slate-700">
              <div class="h-2 rounded {{ $lleno ? 'bg-red-500' : ($pct >= 85 ? 'bg-yellow-400' : 'bg-green-500') }}" @style(['width: ' . $pct . '%'])></div>
            </div>
        </a>
    @endforeach
</div>

<div class="bg-slate-800 p-5 rounded-lg">
    <h2 class="font-semibold mb-2">Asistentes por carrera</h2>
    <ul class="list-disc pl-5">
        @foreach ($porCarrera as $c)
            <li>{{ $c->nombre }}: {{ $c->asistentes_count }}</li>
        @endforeach
    </ul>
</div>
@endsection