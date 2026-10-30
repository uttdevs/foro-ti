<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Admin - Foro TI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center">
<form method="POST" action="{{ route('login.post') }}" class="bg-slate-800 p-6 rounded-lg w-80 space-y-3">
    @csrf
    <h1 class="text-xl font-bold text-blue-400">Acceso administrador</h1>
    @error('email') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
    <input class="w-full p-2 rounded bg-slate-700" type="email" name="email" placeholder="Correo" value="{{ old('email') }}" required>
    <input class="w-full p-2 rounded bg-slate-700" type="password" name="password" placeholder="Contraseña" required>
    <button class="w-full bg-blue-600 p-2 rounded">Entrar</button>
</form>
</body>
</html>