<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Incidentes - Sistema de Alerta Ciudadana</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1a1a1a;
            padding: 30px;
            background: #ffffff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #dc2626;
        }
        
        .header-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
        }
        
        .header h1 {
            color: #dc2626;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        
        .header .subtitle {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }
        
        .info-section {
            background: #f8fafc;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-left: 4px solid #3b82f6;
            border-radius: 4px;
        }
        
        .info-row {
            margin-bottom: 8px;
            font-size: 13px;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 700;
            color: #475569;
            display: inline-block;
            width: 140px;
        }
        
        .info-value {
            color: #1e293b;
        }
        
        .table-container {
            margin-top: 20px;
        }
        
        .table-header {
            margin-bottom: 12px;
            padding: 10px 0;
        }
        
        .table-header h2 {
            color: #1e293b;
            font-size: 18px;
            font-weight: 700;
            display: inline-block;
        }
        
        .badge {
            background: #dc2626;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            margin-left: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        thead {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }
        
        th {
            color: white;
            padding: 14px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #dc2626;
        }
        
        tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }
        
        tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        tbody tr:hover {
            background: #f1f5f9;
        }
        
        td {
            padding: 12px 16px;
            font-size: 13px;
            color: #334155;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .status-activo {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }
        
        .status-pendiente {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .status-resuelto {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        .status-cerrado {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 11px;
        }
        
        .footer-icon {
            width: 16px;
            height: 16px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 5px;
        }
        
        .summary-box {
            background: #eff6ff;
            border: 2px solid #3b82f6;
            padding: 15px;
            margin-top: 25px;
            border-radius: 6px;
        }
        
        .summary-box strong {
            color: #1e40af;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <svg class="header-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#dc2626" stroke-width="2"/>
            <path d="M12 8V12" stroke="#dc2626" stroke-width="2" stroke-linecap="round"/>
            <circle cx="12" cy="16" r="1" fill="#dc2626"/>
        </svg>
        <h1>Sistema de Alerta Ciudadana</h1>
        <div class="subtitle">Reporte de Incidentes Registrados</div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Fecha de Generación:</span>
            <span class="info-value">{{ date('d/m/Y H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tipo de Reporte:</span>
            <span class="info-value">Incidentes por Hospital Asignado</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de Registros:</span>
            <span class="info-value">{{ count($incidentes) }}</span>
        </div>
    </div>

    <!-- Table -->
<div class="table-container">
    <div class="table-header">
        <h2>Listado de Incidentes</h2>
        <span class="badge">{{ count($incidentes) }} Registros</span>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Hora</th>
                <th>Prioridad</th>
                <th>Víctimas</th>
                <th>Gravedad Heridos</th>
                <th>Observaciones</th>
                <th>Hospital Asignado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incidentes as $index => $i)
            <tr>
                <td>{{ $i['tipo'] }}</td>
                <td>{{ $i['descripcion'] ?? '-' }}</td>
                <td>{{ $i['ubicacion'] }}</td>
                <td>{{ $i['hora'] }}</td>
                <td>{{ $i['prioridad'] ?? '-' }}</td>
                <td>{{ $i['numero_victimas'] ?? '-' }}</td>
                <td>{{ $i['gravedad_heridos'] ?? '-' }}</td>
                <td>{{ $i['observaciones'] ?? '-' }}</td>
                <td><strong>{{ $i['hospital_asignado'] ?? 'No asignado' }}</strong></td>
                <td>
                    @if(strtolower($i['estado']) == 'activo')
                        <span class="status-badge status-activo">● Activo</span>
                    @elseif(strtolower($i['estado']) == 'pendiente')
                        <span class="status-badge status-pendiente">● Pendiente</span>
                    @elseif(strtolower($i['estado']) == 'resuelto')
                        <span class="status-badge status-resuelto">● Resuelto</span>
                    @else
                        <span class="status-badge status-cerrado">● {{ ucfirst($i['estado']) }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


    <!-- Summary Box -->
    <div class="summary-box">
        <strong>Nota:</strong> Este reporte fue generado automáticamente por el Sistema de Alerta Ciudadana. 
        Para más información, contacte al departamento de emergencias.
    </div>

    <!-- Footer -->
    <div class="footer">
        <svg class="footer-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#64748b" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Documento confidencial - Sistema de Alerta Ciudadana © {{ date('Y') }} - Generado el {{ date('d/m/Y') }}
    </div>
</body>
</html>
