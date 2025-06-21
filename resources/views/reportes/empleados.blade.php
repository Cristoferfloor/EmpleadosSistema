<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Empleados</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body { 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 8pt;
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 5px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .title { 
            font-size: 12pt; 
            font-weight: bold; 
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 9pt;
            color: #555;
            margin-bottom: 5px;
        }
        .table-container {
            width: 100%;
            overflow: hidden;
        }
        .table { 
            width: 100%; 
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 7pt;
            table-layout: fixed;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 3px;
            text-align: left;
            word-wrap: break-word;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 5px;
            font-size: 7pt;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

       
        .col-num { width: 3%; }
        .col-codigo { width: 5%; }
        .col-nombres { width: 8%; }
        .col-apellidos { width: 8%; }
        .col-cedula { width: 6%; }
        .col-fecha { width: 6%; }
        .col-email { width: 8%; }
        .col-estado { width: 6%; }
        .col-ingreso { width: 6%; }
        .col-cargo { width: 8%; }
        .col-depto { width: 7%; }
        .col-provincia { width: 6%; }
        .col-sueldo { width: 5%; }
        .col-jornada { width: 5%; }
        .col-obs { width: 10%; }

       
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Módulo de Empleados</div>
        <div class="subtitle">REPORTE EMPLEADOS - Generado el: {{ date('d/m/Y') }}</div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-num">#</th>
                    <th class="col-codigo">Código</th>
                    <th class="col-nombres">Nombres</th>
                    <th class="col-apellidos">Apellidos</th>
                    <th class="col-cedula">Cédula</th>
                    <th class="col-fecha">Nacimiento</th>
                    <th class="col-email">Email</th>
                    <th class="col-estado">Estado</th>
                    <th class="col-ingreso">Ingreso</th>
                    <th class="col-cargo">Cargo</th>
                    <th class="col-depto">Departamento</th>
                    <th class="col-provincia">Provincia</th>
                    <th class="col-sueldo">Sueldo</th>
                    <th class="col-jornada">Jornada</th>
                    <th class="col-obs">Obs. Pers.</th>
                    <th class="col-obs">Obs. Lab.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $index => $empleado)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $empleado->codigo_empleado }}</td>
                    <td>{{ Str::limit($empleado->nombres, 15) }}</td>
                    <td>{{ Str::limit($empleado->apellidos, 15) }}</td>
                    <td>{{ $empleado->cedula }}</td>
                    <td>{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($empleado->email, 15) }}</td>
             <td style="white-space: normal; word-break: break-word; vertical-align: top;">
    {{ $empleado->estado }}
</td>
                    <td>{{ optional($empleado->datosLaborales)->fecha_ingreso ? \Carbon\Carbon::parse($empleado->datosLaborales->fecha_ingreso)->format('d/m/Y') : '' }}</td>
                    <td>{{ Str::limit(optional($empleado->datosLaborales)->cargo, 15) }}</td>
                    <td>{{ Str::limit(optional($empleado->datosLaborales)->departamento, 10) }}</td>
                    <td>{{ Str::limit(optional($empleado->datosLaborales->provincia)->nombre ?? 'N/A', 8) }}</td>
                    <td>${{ number_format(optional($empleado->datosLaborales)->sueldo ?? 0, 2) }}</td>
                    <td>
                        @if(optional($empleado->datosLaborales)->jornada_parcial)
                            Parcial
                        @else
                            Completa
                        @endif
                    </td>
                    <td>{{ Str::limit($empleado->observaciones_personales, 20) }}</td>
                    <td>{{ Str::limit(optional($empleado->datosLaborales)->observaciones_laborales, 20) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Reporte generado por el sistema - {{ config('app.name') }}<br>
        © 2025 Todos los derechos reservados por CristoferDev
    </div>
</body>
</html>
