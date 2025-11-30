<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte oficial SACID</title>
    <style>
        /* CONFIGURACIÓN GENERAL PARA IMPRESIÓN */
        @page {
            margin: 1cm;
            size: landscape; /* Opcional: Fuerza horizontal si el motor lo permite */
        }
        
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important; /* Fuerza impresión de fondos */
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; /* Fuentes seguras para PDF */
            font-size: 12px;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        /* HEADER */
        .header {
            width: 100%;
            border-bottom: 2px solid #1a237e;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: table; /* Hack para layout seguro en PDF antiguos */
        }

        .header-logo {
            display: table-cell;
            vertical-align: middle;
            width: 60px;
            font-size: 30px;
            color: #1a237e;
            font-weight: bold;
        }

        .header-content {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1a237e;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .subtitle {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }

        /* KPI / STATS - Diseño en Bloques */
        .stats-wrapper {
            width: 100%;
            margin-bottom: 30px;
            overflow: hidden; /* Clearfix */
        }

        .stat-box {
            float: left;
            width: 23%; /* 4 en linea con margen */
            margin-right: 2.66%;
            background: #f4f6f9;
            border-left: 4px solid #1a237e;
            padding: 15px;
            border-radius: 4px;
        }

        .stat-box:last-child {
            margin-right: 0;
        }

        .stat-box h3 {
            margin: 0;
            font-size: 28px;
            color: #1a237e;
        }

        .stat-box p {
            margin: 5px 0 0;
            font-size: 11px;
            text-transform: uppercase;
            color: #555;
            font-weight: 600;
        }

        /* INFO SECTION */
        .info-section {
            background: #eef2f7;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 25px;
            border: 1px solid #dae1e7;
            font-size: 11px;
        }
        
        .info-table {
            width: 100%;
        }
        
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        
        .label {
            font-weight: bold;
            color: #1a237e;
            width: 140px;
        }

        /* TABLA PRINCIPAL */
        .main-table-container {
            width: 100%;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px; /* Letra pequeña para que quepan columnas */
            table-layout: fixed; /* Ayuda a controlar anchos */
        }

        table.main-table thead {
            display: table-header-group; /* Repite cabecera en cada página nueva */
            background-color: #1a237e;
            color: #fff;
        }

        table.main-table th {
            padding: 10px 5px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            border: 1px solid #1a237e;
        }

        table.main-table tbody tr {
            page-break-inside: avoid; /* Intenta no cortar filas a la mitad */
        }

        table.main-table td {
            padding: 8px 5px;
            border: 1px solid #ddd;
            vertical-align: top;
            word-wrap: break-word; /* Rompe palabras largas */
        }

        table.main-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        /* BADGES & STATUS */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            color: #fff;
            white-space: nowrap;
        }

        /* Prioridades */
        .p-high { color: #dc2626; font-weight: bold; }
        .p-med { color: #d97706; font-weight: bold; }
        .p-low { color: #059669; font-weight: bold; }

        /* Estados (Fondos sólidos para mejor lectura) */
        .st-activo { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .st-pendiente { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .st-resuelto { background-color: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .st-cerrado { background-color: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }

        /* FOOTER */
        .footer {
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
        
        .page-number:before {
            content: "Página " counter(page);
        }

        /* Utilidad para anchos de columna específicos */
        .col-sm { width: 6%; }
        .col-md { width: 10%; }
        .col-lg { width: 15%; }
        .col-xl { width: 20%; }

    </style>
</head>
<body>

    <div class="header">
        <div class="header-logo">
            SACID
        </div>
        <div class="header-content">
            <h1>Reporte de Incidentes</h1>
            <p class="subtitle">Sistema de Asistencia Ciudadana por Drones</p>
            <p style="font-size: 11px; margin-top: 5px; color: #666;">Generado: {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="stats-wrapper">
        <div class="stat-box">
            <h3>{{ count($incidentes) }}</h3>
            <p>Total Registrados</p>
        </div>
        <div class="stat-box" style="border-color: #166534;">
            <h3>
                {{ count(array_filter($incidentes, function($i) { return isset($i['estado']) && strtolower($i['estado']) === 'activo'; })) }}
            </h3>
            <p>Incidentes Activos</p>
        </div>
        <div class="stat-box" style="border-color: #dc2626;">
            <h3>
                {{ count(array_filter($incidentes, function($i) { return isset($i['prioridad']) && strtolower($i['prioridad']) === 'alta'; })) }}
            </h3>
            <p>Prioridad Alta</p>
        </div>
        <div class="stat-box" style="border-color: #2563eb;">
            <h3>
                {{ count(array_filter($incidentes, function($i) { return !empty($i['hospital_asignado']); })) }}
            </h3>
            <p>Hospital Asignado</p>
        </div>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Departamento:</td>
                <td>Centro de Comando y Control de Drones</td>
                <td class="label">Usuario:</td>
                <td>Coordinador de turno</td>
            </tr>
            <tr>
                <td class="label">Alcance:</td>
                <td>Reporte completo de últimas 24 horas</td>
                <td class="label">Sistema:</td>
                <td>SACID v2.1 (Build 405)</td>
            </tr>
        </table>
    </div>

    <div class="main-table-container">
        <h3 style="color: #1a237e; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Detalle Operativo</h3>
        
        <table class="main-table">
            <thead>
                <tr>
                    <th class="col-md">Tipo</th>
                    <th class="col-xl">Ubicación</th>
                    <th class="col-sm">Hora</th>
                    <th class="col-sm">Prio.</th>
                    <th class="col-sm">Vic.</th>
                    <th class="col-md">Gravedad</th>
                    <th class="col-xl">Observaciones</th>
                    <th class="col-lg">Hospital</th>
                    <th class="col-md">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidentes as $i)
                <tr>
                    <td><strong>{{ $i['tipo'] }}</strong></td>
                    <td>
                        {{ $i['ubicacion'] }}
                        @if(isset($i['descripcion']))
                            <div style="font-size: 9px; color: #666; margin-top: 4px;">{{ Str::limit($i['descripcion'], 50) }}</div>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $i['hora'] }}</td>
                    <td style="text-align: center;">
                        @if(($i['prioridad'] ?? '') == 'alta') <span class="p-high">ALTA</span>
                        @elseif(($i['prioridad'] ?? '') == 'media') <span class="p-med">MED</span>
                        @else <span class="p-low">BAJA</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $i['numero_victimas'] ?? '0' }}</td>
                    <td>{{ $i['gravedad_heridos'] ?? '-' }}</td>
                    <td>{{ $i['observaciones'] ?? 'Sin observaciones registradas' }}</td>
                    <td>
                        @if(!empty($i['hospital_asignado']))
                            <strong>{{ $i['hospital_asignado'] }}</strong>
                        @else
                            <span style="color: #999; font-style: italic;">--</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @php $est = strtolower($i['estado'] ?? ''); @endphp
                        @if($est == 'activo') <span class="badge st-activo">Activo</span>
                        @elseif($est == 'pendiente') <span class="badge st-pendiente">Pendiente</span>
                        @elseif($est == 'resuelto') <span class="badge st-resuelto">Resuelto</span>
                        @else <span class="badge st-cerrado">{{ ucfirst($est) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>
            Documento Confidencial | Sistema de Asistencia Ciudadana por Drones © {{ date('Y') }}
            <br>
            Este reporte es para uso exclusivo del personal autorizado.
        </p>
    </div>

</body>
</html>