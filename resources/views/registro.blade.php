<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Foro TI 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        select option { background: #0c2032; color: #fff; }
    </style>
</head>
@php
    $campo = 'w-full rounded-lg border border-cyan-400/50 bg-[#0c2032] px-4 py-3 text-white placeholder-slate-400 outline-none focus:border-fuchsia-400';
@endphp
<body class="min-h-screen px-4 py-6 text-white"
      style="background: radial-gradient(circle at 100% 0%, rgba(0,229,255,.35), transparent 32%), radial-gradient(circle at 0% 100%, rgba(217,70,239,.45), transparent 38%), #05060f;">
<div class="mx-auto max-w-xl">

    <header class="flex items-center justify-between py-2">
        <a href="/" class="text-sm text-cyan-300 hover:text-fuchsia-300">← Volver al inicio</a>
        <img src="/logo-foroti.png" alt="Foro TI 2026" class="h-16 w-auto object-contain"
             onerror="this.style.display='none'">
    </header>

    <h1 class="mt-4 text-center text-3xl font-black sm:text-4xl">
        <span class="bg-gradient-to-r from-fuchsia-400 via-violet-400 to-cyan-300 bg-clip-text text-transparent">
            Registro Foro TI 2026
        </span>
    </h1>
    <p class="mt-2 text-center text-sm text-slate-300">Paso 1 de 2 · Tus datos. Después eliges tu taller.</p>

    @if ($errors->any())
        <div class="mt-5 rounded-lg border border-red-400 bg-red-500/20 p-3 text-red-200">
            <ul class="list-disc pl-5 text-sm">
                @foreach (collect($errors->all())->unique() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formulario-foro" action="{{ route('foro.guardar') }}" method="POST"
          class="mt-5 space-y-3 rounded-2xl border-2 border-cyan-300 bg-gradient-to-br from-[#102735] to-[#11102b] p-5 shadow-[0_0_24px_#22d3ee88]">
        @csrf

        <input class="{{ $campo }}" type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" required>
        <input class="{{ $campo }}" type="text" name="apellido_paterno" placeholder="Apellido paterno" value="{{ old('apellido_paterno') }}" required>
        <input class="{{ $campo }}" type="text" name="apellido_materno" placeholder="Apellido materno" value="{{ old('apellido_materno') }}" required>
        <input class="{{ $campo }}" type="number" name="edad" placeholder="Edad" min="15" max="99" value="{{ old('edad') }}" required>

        <input class="{{ $campo }}" type="text" name="matricula" placeholder="Matrícula (8 números)"
               maxlength="8" pattern="\d{8}" inputmode="numeric"
               oninput="this.value=this.value.replace(/\D/g,'')"
               value="{{ old('matricula') }}" required>

        <select class="{{ $campo }}" name="carrera_id" required>
            <option value="">Selecciona tu carrera</option>
            @foreach ($carreras as $carrera)
                <option value="{{ $carrera->id }}" @selected(old('carrera_id') == $carrera->id)>{{ $carrera->nombre }}</option>
            @endforeach
        </select>

        <select class="{{ $campo }}" name="cuatrimestre" required>
            <option value="">Cuatrimestre</option>
            @foreach ([1, 4, 7, 10] as $cuatri)
                <option value="{{ $cuatri }}" @selected(old('cuatrimestre') == $cuatri)>{{ $cuatri }}</option>
            @endforeach
        </select>

        <input class="{{ $campo }}" type="email" name="correo" placeholder="Correo (con @)" value="{{ old('correo') }}" required>

        <input class="{{ $campo }}" type="tel" name="telefono" placeholder="Teléfono (10 números)"
               maxlength="10" pattern="\d{10}" inputmode="numeric"
               oninput="this.value=this.value.replace(/\D/g,'')"
               value="{{ old('telefono') }}">

        <button type="submit"
                class="w-full rounded-lg bg-cyan-400 px-6 py-3 font-black text-slate-950 transition hover:bg-fuchsia-400">
            Continuar y elegir taller →
        </button>
    </form>

    <p class="mt-6 text-center text-xs text-slate-400">© 2026 Foro TI · Datos, IA e innovación digital</p>
</div>
</body>
</html>
