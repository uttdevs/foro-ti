<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscripción al taller - Foro TI 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center px-4"
      style="background: radial-gradient(circle at 100% 0%, rgba(0,229,255,.35), transparent 32%), radial-gradient(circle at 0% 100%, rgba(217,70,239,.45), transparent 38%), #05060f;">

<div class="mx-auto max-w-md w-full text-white">

    <header class="flex items-center justify-between py-4">
        <a href="/" class="text-sm text-cyan-300 hover:text-fuchsia-300">← Inicio</a>
        <img src="/logo-foroti.png" alt="Foro TI 2026" class="h-16 w-auto object-contain"
             onerror="this.style.display='none'">
    </header>

    <div class="rounded-2xl border-2 border-cyan-300 bg-gradient-to-br from-[#102735] to-[#11102b] p-6 shadow-[0_0_24px_#22d3ee88]">

        <h1 class="text-2xl font-black text-center bg-gradient-to-r from-fuchsia-400 via-violet-400 to-cyan-300 bg-clip-text text-transparent">
            Inscripción al taller
        </h1>
        <p class="mt-2 text-center text-sm text-slate-300">
            Paso 2 de 2 · Ingresa tu matrícula para continuar
        </p>

        @if ($errors->any())
            @php $error = $errors->first('matricula'); @endphp
            <div class="mt-4 rounded-lg border border-red-400 bg-red-500/20 p-4 text-red-200 text-sm leading-6">
                {{ $error }}
                @if (str_contains($error, 'formulario'))
                    <div class="mt-3">
                        <a href="{{ route('registro') }}"
                           class="inline-block rounded-lg bg-cyan-400 px-4 py-2 font-black text-slate-950 hover:bg-fuchsia-400 text-xs">
                            Ir al formulario de registro →
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <form action="{{ route('taller.verificar') }}" method="POST" class="mt-5 space-y-3">
            @csrf

            <input type="text"
                   name="matricula"
                   placeholder="Matrícula (8 números)"
                   maxlength="8"
                   pattern="\d{8}"
                   inputmode="numeric"
                   oninput="this.value=this.value.replace(/\D/g,'')"
                   value="{{ old('matricula') }}"
                   class="w-full rounded-lg border border-cyan-400/50 bg-[#0c2032] px-4 py-3 text-white placeholder-slate-400 outline-none focus:border-fuchsia-400"
                   required autofocus>

            <button type="submit"
                    class="w-full rounded-lg bg-cyan-400 px-6 py-3 font-black text-slate-950 transition hover:bg-fuchsia-400">
                Continuar →
            </button>
        </form>

        <p class="mt-4 text-center text-xs text-slate-400">
            ¿Aún no te registras?
            <a href="{{ route('registro') }}" class="text-cyan-300 hover:text-fuchsia-300">Llena el formulario primero</a>
        </p>
    </div>

    <p class="mt-6 text-center text-xs text-slate-400">© 2026 Foro TI · Datos, IA e innovación digital</p>
</div>

</body>
</html>
