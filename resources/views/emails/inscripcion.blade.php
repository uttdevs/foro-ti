@php
    $jueves = [
        ['08:00 - 09:00', 'Registro y firma', null],
        ['09:00 - 09:30', 'Inauguración', null],
        ['09:30 - 10:30', 'Conferencia magistral', 'Dr. Eduardo Berra Villaseñor'],
        ['10:30 - 11:00', 'Presentación de proyectos', null],
        ['11:00 - 11:30', 'Break', null],
        ['11:30 - 13:00', 'Mesas de trabajo simultáneas', null],
        ['13:00 - 14:00', 'Comida', null],
        ['14:30 - 18:00', 'Mesas de trabajo', null],
    ];
    $viernes = [
        ['09:00 - 10:00', 'Inicio del evento', null],
       ['11:00 - 13:00', 'Torneo de videojuegos', 'FIFA · KOF · Street Fighter'],
        ['13:00', 'Premiación', null],
    ];
@endphp
<!DOCTYPE html>
<html lang="es">
<body style="margin:0;padding:0;background:#05060f;font-family:Arial,Helvetica,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#05060f;padding:24px 12px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#0f2233;border:2px solid #22d3ee;border-radius:16px;color:#ffffff;">
      <tr>
        <td style="padding:28px 28px 8px;text-align:center;">
          <h1 style="margin:0;font-size:24px;color:#67e8f9;">¡Registro confirmado!</h1>
          <p style="margin:8px 0 0;color:#cbd5e1;font-size:14px;">Foro TI 2026 · Datos, IA e Innovación Digital</p>
        </td>
      </tr>
      <tr>
        <td style="padding:16px 28px;font-size:15px;line-height:1.6;color:#e2e8f0;">
          <p style="margin:0 0 12px;">
            Hola <strong>{{ $asistente->nombre }}</strong>, tu registro al Foro TI 2026
            y tu inscripción al taller quedaron completos.
          </p>

          <table width="100%" cellpadding="8" cellspacing="0" style="font-size:14px;background:#12102b;border-radius:10px;">
            <tr><td style="color:#94a3b8;width:38%;">Nombre</td><td>{{ $asistente->nombre }} {{ $asistente->apellido_paterno }} {{ $asistente->apellido_materno }}</td></tr>
            <tr><td style="color:#94a3b8;">Matrícula</td><td>{{ $asistente->matricula }}</td></tr>
            <tr><td style="color:#94a3b8;">Carrera</td><td>{{ $asistente->carrera?->nombre }}</td></tr>
            <tr><td style="color:#94a3b8;">Cuatrimestre</td><td>{{ $asistente->cuatrimestre }}</td></tr>
            <tr><td style="color:#94a3b8;">Taller</td><td style="color:#e879f9;font-weight:bold;">{{ $asistente->taller?->nombre ?? 'Por definir' }}</td></tr>
          </table>

          <p style="margin:16px 0 4px;">
            <strong>Lugar:</strong> Universidad Tecnológica de Tecamachalco, Tecamachalco, Puebla.
          </p>

          <h2 style="margin:20px 0 8px;font-size:17px;color:#67e8f9;">Agenda del día</h2>

          <p style="margin:0 0 6px;font-weight:bold;color:#22d3ee;">Jueves 26 de noviembre</p>
          <table width="100%" cellpadding="6" cellspacing="0" style="font-size:13px;background:#12102b;border-radius:10px;">
            @foreach ($jueves as [$hora, $actividad, $detalle])
              <tr>
                <td style="color:#94a3b8;width:34%;vertical-align:top;white-space:nowrap;">{{ $hora }}</td>
                <td style="vertical-align:top;">
                  {{ $actividad }}
                  @if ($detalle)
                    <br><span style="color:#94a3b8;font-size:12px;">{{ $detalle }}</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </table>

          <p style="margin:16px 0 6px;font-weight:bold;color:#e879f9;">Viernes 27 de noviembre</p>
          <table width="100%" cellpadding="6" cellspacing="0" style="font-size:13px;background:#12102b;border-radius:10px;">
           @foreach ($viernes as [$hora, $actividad, $detalle])
  <tr>
    <td style="color:#94a3b8;width:34%;vertical-align:top;white-space:nowrap;">{{ $hora }}</td>
    <td style="vertical-align:top;">
      {{ $actividad }}
      @if ($detalle)
        <br><span style="color:#94a3b8;font-size:12px;">{{ $detalle }}</span>
      @endif
    </td>
  </tr>
@endforeach
          </table>

          <p style="margin:16px 0 0;">Guarda este correo como comprobante de tu registro.</p>
        </td>
      </tr>
      <tr>
        <td style="padding:12px 28px 24px;text-align:center;font-size:12px;color:#64748b;">
          © 2026 Foro TI · Este es un mensaje automático, no respondas a este correo.
        </td>
      </tr>
    </table>
  </td></tr>
</table>
</body>
</html>