<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') - Admin Foro TI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen">
<nav class="bg-slate-800 border-b border-slate-700 px-6 py-3 flex flex-wrap items-center gap-5">
    <span class="font-bold text-blue-400">Foro TI 2026</span>
    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-300">Inicio</a>
    <a href="{{ route('admin.foro') }}" class="hover:text-blue-300">Asistentes</a>
    <form method="POST" action="{{ route('logout') }}" class="ml-auto">
        @csrf
        <button class="bg-red-600 hover:bg-red-500 px-3 py-1 rounded text-sm">Cerrar sesión</button>
    </form>
</nav>

<main class="max-w-7xl mx-auto p-6 space-y-4">
    @if (session('ok'))
        <div class="bg-green-500/20 border border-green-500 text-green-300 p-3 rounded">{{ session('ok') }}</div>
    @endif
    @if ($errors->any())
        <div class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach (collect($errors->all())->unique() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('contenido')
</main>
</body>
</html>