<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Foro TI 2026</title>
    @viteReactRefresh
    @vite('resources/js/spa/main.jsx')
</head>
<body>
    <div id="root"></div>
</body>
</html>