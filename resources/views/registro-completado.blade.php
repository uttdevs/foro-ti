<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro completado - Foro TI 2026</title>
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

    <div class="rounded-2xl border-2 border-cyan-300 bg-gradient-to-br from-[#102735] to-[#11102b] p-8 shadow-[0_0_24px_#22d3ee88] text-center">

        <div class="text-6xl mb-4">✅</div>

        <h1 class="text-3xl font-black bg-gradient-to-r from-fuchsia-400 via-violet-400 to-cyan-300 bg-clip-text text-transparent">
            ¡Registro completado!
        </h1>

        <p class="mt-4 text-slate-300 text-sm leading-7">
            Tus datos quedaron guardados correctamente.<br>
            Para inscribirte a un taller deberás <strong class="text-cyan-300">realizar tu pago</strong>
            cuando lo hagas, el equipo te habilitará y podrás elegir tu taller.
        </p>

        <div class="mt-6 rounded-xl border border-cyan-400/30 bg-cyan-400/10 px-4 py-3 text-cyan-200 text-xs leading-6">
            💡 Guarda tu <strong>matrícula</strong>, la necesitarás para inscribirte al taller después de pagar.
        </div>

        <a href="{{ route('taller.buscar') }}"
           class="mt-6 inline-block w-full rounded-lg bg-cyan-400 px-6 py-3 font-black text-slate-950 transition hover:bg-fuchsia-400">
            Ya pagué → Inscribirme a un taller
        </a>

        <a href="/" class="mt-3 inline-block text-sm text-slate-400 hover:text-cyan-300">
            ← Volver al inicio
        </a>
    </div>

    <p class="mt-6 text-center text-xs text-slate-400">© 2026 Foro TI · Datos, IA e innovación digital</p>
</div>

</body>
</html>
