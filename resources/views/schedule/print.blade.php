<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horario - Impresion</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #1f2937; }
        h1 { font-size: 20px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #9ca3af; padding: 6px 8px; text-align: left; font-size: 12px; vertical-align: top; }
        th { background: #fee2e2; }
        .clase { margin-bottom: 4px; }
        .clase strong { display: block; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 16px;">
        <button onclick="window.print()">Imprimir</button>
    </div>

    <h1>Horario General</h1>

    @php
        $dias = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miercoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sabado', 7 => 'Domingo'];
        $horas = collect($grid)->flatMap(fn ($porHora) => array_keys($porHora))->unique()->sort()->values();
    @endphp

    <table>
        <thead>
            <tr>
                <th>Hora</th>
                @foreach ($dias as $diaNum => $diaNombre)
                    <th>{{ $diaNombre }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($horas as $hora)
                <tr>
                    <td><strong>{{ $hora }}</strong></td>
                    @foreach ($dias as $diaNum => $diaNombre)
                        <td>
                            @if (isset($grid[$diaNum][$hora]))
                                @foreach ($grid[$diaNum][$hora] as $class)
                                    <div class="clase">
                                        <strong>{{ $class->subject->sigla }}</strong>
                                        {{ $class->teacher->nombre_completo }}<br>
                                        {{ $class->classroom->codigo }} - {{ $class->group->nombre }}
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
