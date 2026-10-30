<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; }
        h1 { color: #1d4ed8; margin-bottom: 2px; }
        .meta { color: #555; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 3px; text-align: left; }
        th { background: #1d4ed8; color: #fff; }
    </style>
</head>
<body>
    <h1>Foro TI 2026 - Asistentes</h1>
    <div class="meta">
        Filtros: {{ $filtros }}<br>
        Total: {{ $asistentes->count() }} | Generado: {{ now()->format('d/m/Y H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th><th>Nombre</th><th>Edad</th><th>Matrícula</th><th>Carrera</th>
                <th>Cuatri</th><th>Taller</th><th>Correo</th><th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($asistentes as $i => $a)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $a->apellido_paterno }} {{ $a->apellido_materno }} {{ $a->nombre }}</td>
                <td>{{ $a->edad }}</td>
                <td>{{ $a->matricula }}</td>
                <td>{{ $a->carrera->nombre }}</td>
                <td>{{ $a->cuatrimestre }}</td>
                <td>{{ $a->taller?->nombre ?? 'Sin taller' }}</td>
                <td>{{ $a->correo }}</td>
                <td>{{ $a->telefono }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>