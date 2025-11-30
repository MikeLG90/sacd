<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Expediente de Incidente #{{ $incidente->id }}</title>
    <style>
        /* ESTILOS BASE (Mismos colores para consistencia de marca) */
        @page {
            margin: 1cm;
            margin-top: 1.5cm;
            size: portrait; /* Vertical es mejor para fichas individuales */
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        /* UTILIDADES */
        .w-100 { width: 100%; }
        .w-50 { width: 50%; float: left; }
        .clearfix:after { content: ""; display: table; clear: both; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .uppercase { text-transform: uppercase; }
        .bold { font-weight: bold; }
        
        /* COLORES DE ESTADO */
        .bg-blue { background-color: #1a237e; color: white; }
        .bg-gray { background-color: #f4f6f9; }
        .text-primary { color: #1a237e; }
        
        /* HEADER */
        .header {
            border-bottom: 2px solid #1a237e;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-logo {
            font-size: 24px;
            font-weight: bold;
            color: #1a237e;
            float: left;
        }
        .header-meta {
            float: right;
            text-align: right;
        }

        /* CAJA DE ESTADO PRINCIPAL */
        .status-banner {
            padding: 10px;
            border: 1px solid #ddd;
            border-left-width: 5px;
            margin-bottom: 20px;
            background: #fff;
        }
        
        /* Bordes dinámicos según prioridad */
        .priority-alta { border-left-color: #dc2626; }
        .priority-media { border-left-color: #d97706; }
        .priority-baja { border-left-color: #059669; }

        /* SECCIONES */
        .section-title {
            background-color: #eef2f7;
            color: #1a237e;
            padding: 8px 10px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            border-bottom: 1px solid #dae1e7;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        /* TABLAS DE DATOS (Key-Value) */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .data-table td {
            padding: 6px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }
        .data-label {
            width: 35%;
            font-weight: bold;
            color: #555;
            background: #fff;
        }
        .data-value {
            color: #000;
        }

        /* CAJA DE DESCRIPCIÓN GRANDE */
        .narrative-box {
            border: 1px solid #eee;
            background: #fdfdfd;
            padding: 10px;
            min-height: 80px;
            text-align: justify;
        }

        /* FOOTER Y FIRMAS */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 9px;
            text-align: center;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .signatures {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .sign-box {
            width: 40%;
            float: left;
            margin-right: 10%;
            border-top: 1px solid #333;
            padding-top: 5px;
            text-align: center;
        }
        .sign-box:last-child { margin-right: 0; float: right; }

    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header clearfix">
        <div class="header-logo">
            SACD
            <div style="font-size: 10px; font-weight: normal; color: #666; margin-top: 5px;">Sistema de Asistencia Ciudadana por Drones</div>
        </div>
        <div class="header-meta">
            <div style="font-size: 18px; font-weight: bold;">EXPEDIENTE #{{ str_pad($incidente->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div style="font-size: 10px; color: #666;">Generado: {{ date('d/m/Y H:i:s') }}</div>
        </div>
    </div>

    <!-- BANNER DE ESTADO -->
    @php
        $prioClass = match(strtolower($incidente->prioridad ?? '')) {
            'alta' => 'priority-alta',
            'media' => 'priority-media',
            default => 'priority-baja'
        };
        
        $estadoColor = match(strtolower($incidente->estado ?? '')) {
            'activo' => '#166534', // Verde oscuro
            'pendiente' => '#92400e', // Naranja oscuro
            'resuelto' => '#1e40af', // Azul oscuro
            default => '#374151'
        };
    @endphp

    <div class="status-banner {{ $prioClass }} clearfix">
        <div class="w-50">
            <span style="display:block; font-size: 10px; color: #666; text-transform:uppercase;">Prioridad</span>
            <span style="font-size: 14px; font-weight: bold; text-transform:uppercase; color: #333;">
                {{ $incidente->prioridad ?? 'NO DEFINIDA' }}
            </span>
        </div>
        <div class="w-50 text-right">
            <span style="display:block; font-size: 10px; color: #666; text-transform:uppercase;">Estado Actual</span>
            <span style="font-size: 14px; font-weight: bold; text-transform:uppercase; color: {{ $estadoColor }};">
                {{ $incidente->estado ?? 'DESCONOCIDO' }}
            </span>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL - DOS COLUMNAS -->
    <div class="clearfix">
        <!-- Columna Izquierda: Datos del Evento -->
        <div class="w-50" style="padding-right: 15px; box-sizing: border-box;">
            <div class="section-title">Detalles del Evento</div>
            <table class="data-table">
                <tr>
                    <td class="data-label">Tipo de Incidente:</td>
                    <td class="data-value bold">{{ $incidente->tipo }}</td>
                </tr>
                <tr>
                    <td class="data-label">Fecha y Hora:</td>
                    <td class="data-value">{{ date('d/m/Y - H:i', strtotime($incidente->hora)) }}</td>
                </tr>
                <tr>
                    <td class="data-label">Ubicación:</td>
                    <td class="data-value">{{ $incidente->ubicacion }}</td>
                </tr>
                <!-- Ejemplo de campo opcional si tienes coordenadas -->
                @if(isset($incidente->latitud))
                <tr>
                    <td class="data-label">Coordenadas:</td>
                    <td class="data-value" style="font-family: monospace;">
                        {{ $incidente->latitud }}, {{ $incidente->longitud }}
                    </td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Columna Derecha: Datos Operativos -->
        <div class="w-50" style="padding-left: 15px; box-sizing: border-box;">
            <div class="section-title">Datos Operativos</div>
            <table class="data-table">
                <tr>
                    <td class="data-label">Víctimas:</td>
                    <td class="data-value">{{ $incidente->numero_victimas ?? '0' }}</td>
                </tr>
                <tr>
                    <td class="data-label">Gravedad:</td>
                    <td class="data-value">{{ $incidente->gravedad_heridos ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="data-label">Hospital:</td>
                    <td class="data-value bold">
                        @if($incidente->hospital_asignado)
                            {{ $incidente->hospital_asignado }}
                        @else
                            <span style="color: #999;">-- Sin asignar --</span>
                        @endif
                    </td>
                </tr>
                 <!-- Campo ficticio para darle realismo al sistema de drones -->
                <tr>
                    <td class="data-label">Tiempo Respuesta:</td>
                    <td class="data-value">00:12:45 (Estimado)</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- NARRATIVA Y DESCRIPCIÓN -->
    <div class="section-title">Descripción Detallada</div>
    <div class="narrative-box">
        {{ $incidente->descripcion ?? 'No se ha proporcionado una descripción detallada para este incidente.' }}
    </div>

    <div class="section-title">Observaciones del Operador</div>
    <div class="narrative-box">
        {{ $incidente->observaciones ?? 'Sin observaciones adicionales registradas en el sistema.' }}
    </div>

    <!-- SECCIÓN DE FIRMAS -->
    <div class="signatures clearfix">
        <div class="sign-box">
            <br><br>
            <strong>Operador de Dron</strong><br>
            <span style="font-size: 10px;">Firma del Responsable</span>
        </div>
        <div class="sign-box">
            <br><br>
            <strong>Coordinador de Emergencias</strong><br>
            <span style="font-size: 10px;">Visto Bueno</span>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Este documento es un reporte oficial generado por el Sistema de Asistencia Ciudadana por Drones (SACD).
        <br>
        Cualquier alteración o uso indebido de este documento será sancionado.
        <br>
        Página 1 de 1
    </div>

</body>
</html>