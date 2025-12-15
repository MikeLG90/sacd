@extends('layouts.vertical', ['title' => 'Reporte de Incidentes'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
            <!-- Header con diseño más ejecutivo y profesional usando azul oscuro -->
            <div class="card-header" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); border: none; padding: 20px 28px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: white;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                        <h4 class="mb-0" style="color: white; font-weight: 600; font-size: 20px; letter-spacing: -0.5px;">Reporte de Incidentes</h4>
                    </div>
                    <a href="{{ route('reportes.incidentes.pdf') }}" class="btn btn-light btn-sm d-flex align-items-center gap-2" style="border-radius: 8px; padding: 9px 18px; font-weight: 500; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Exportar PDF
                    </a>
                </div>
            </div>
            
            <!-- Body con mejor espaciado y diseño limpio -->
            <div class="card-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="margin-bottom: 0;">
                        <thead style="background-color: #f8f9fb; border-bottom: 2px solid #e2e8f0;">
                            <tr>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; width: 60px;">ID</th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; min-width: 140px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #64748b;">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="12" y1="8" x2="12" y2="12"/>
                                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                                        </svg>
                                        Tipo
                                    </div>
                                </th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; max-width: 220px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #64748b;">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                        </svg>
                                        Descripción
                                    </div>
                                </th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; min-width: 150px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #64748b;">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        Ubicación
                                    </div>
                                </th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; min-width: 120px;">Coordenadas</th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; min-width: 150px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #64748b;">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                            <polyline points="9 22 9 12 15 12 15 22"/>
                                        </svg>
                                        Hospital
                                    </div>
                                </th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; width: 100px;">Prioridad</th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; width: 90px; text-align: center;">Víctimas</th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; width: 120px;">Gravedad</th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; max-width: 200px;">Observaciones</th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; width: 110px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #64748b;">
                                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                        </svg>
                                        Estado
                                    </div>
                                </th>
                                <th style="padding: 14px 20px; font-weight: 600; color: #334155; border: none; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; width: 100px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incidentes as $incidente)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.15s ease;">
                                <td style="padding: 16px 20px; font-weight: 600; color: #1e293b; font-size: 14px;">#{{ $incidente->id }}</td>
                                <td style="padding: 16px 20px; color: #475569; font-size: 14px;">{{ $incidente->tipo }}</td>
                                
                                <!-- Descripción con truncamiento elegante -->
                                <td style="padding: 16px 20px; color: #475569; font-size: 14px; max-width: 220px;">
                                    <div class="text-truncate-cell" 
                                         data-bs-toggle="tooltip" 
                                         data-bs-placement="top" 
                                         title="{{ $incidente->descripcion }}">
                                        {{ $incidente->descripcion }}
                                    </div>
                                </td>
                                
                                <td style="padding: 16px 20px; color: #475569; font-size: 14px;">{{ $incidente->ubicacion }}</td>
                                <td style="padding: 16px 20px; color: #64748b; font-size: 12px; font-family: 'Courier New', monospace;">
                                    <div style="line-height: 1.5;">
                                        {{ number_format($incidente->lat, 4) }}<br>
                                        {{ number_format($incidente->lng, 4) }}
                                    </div>
                                </td>
                                <td style="padding: 16px 20px; color: #475569; font-size: 14px;">{{ $incidente->hospital_asignado }}</td>
                                
                                <!-- Badges de prioridad con diseño profesional -->
                                <td style="padding: 16px 20px;">
                                    @if($incidente->prioridad === 'Alta')
                                        <span class="badge" style="background-color: #dc2626; color: white; font-size: 11px; padding: 5px 10px; border-radius: 6px; font-weight: 600; letter-spacing: 0.3px;">ALTA</span>
                                    @elseif($incidente->prioridad === 'Media')
                                        <span class="badge" style="background-color: #f59e0b; color: white; font-size: 11px; padding: 5px 10px; border-radius: 6px; font-weight: 600; letter-spacing: 0.3px;">MEDIA</span>
                                    @else
                                        <span class="badge" style="background-color: #0891b2; color: white; font-size: 11px; padding: 5px 10px; border-radius: 6px; font-weight: 600; letter-spacing: 0.3px;">BAJA</span>
                                    @endif
                                </td>
                                
                                <td style="padding: 16px 20px; color: #1e293b; text-align: center; font-weight: 600; font-size: 14px;">
                                    {{ $incidente->numero_victimas ?? '-' }}
                                </td>
                                <td style="padding: 16px 20px; color: #475569; font-size: 13px;">
                                    {{ $incidente->gravedad_heridos ?? '-' }}
                                </td>
                                
                                <!-- Observaciones con truncamiento -->
                                <td style="padding: 16px 20px; color: #475569; font-size: 13px; max-width: 200px;">
                                    <div class="text-truncate-cell" 
                                         data-bs-toggle="tooltip" 
                                         data-bs-placement="top" 
                                         title="{{ $incidente->observaciones ?? 'Sin observaciones' }}">
                                        {{ $incidente->observaciones ?? '-' }}
                                    </div>
                                </td>
                                
                                <!-- Estado con badges más profesionales -->
                                <td style="padding: 16px 20px;">
                                    @if($incidente->estado === 'Atendido')
                                        <span class="badge d-inline-flex align-items-center gap-1" style="background-color: #059669; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 11px;">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            Atendido
                                        </span>
                                    @elseif($incidente->estado === 'En proceso')
                                        <span class="badge d-inline-flex align-items-center gap-1" style="background-color: #d97706; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 11px;">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="12 6 12 12 16 14"/>
                                            </svg>
                                            En Proceso
                                        </span>
                                    @else
                                        <span class="badge d-inline-flex align-items-center gap-1" style="background-color: #64748b; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 11px;">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <circle cx="12" cy="12" r="10"/>
                                            </svg>
                                            Pendiente
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Botón de acción minimalista y ejecutivo -->
                                <td style="padding: 16px 20px; text-align: center;">
                                    <a href="{{ route('pdf.individual', $incidente->id) }}" 
                                       class="btn btn-sm btn-action d-inline-flex align-items-center gap-2" 
                                       style="background-color: #2563eb; color: white; border: none; border-radius: 6px; padding: 7px 14px; font-weight: 500; font-size: 12px; transition: all 0.2s ease;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                        </svg>
                                        PDF
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos profesionales y ejecutivos -->
<style>
    /* Hover effect para filas de tabla */
    .table tbody tr {
        transition: all 0.15s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8fafc;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    
    /* Botón de acción hover */
    .btn-action:hover {
        background-color: #1d4ed8 !important;
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
        transform: translateY(-1px);
    }
    
    .btn-action:active {
        transform: translateY(0);
    }
    
    /* Truncamiento de texto con elipsis */
    .text-truncate-cell {
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: help;
    }
    
    /* Tooltip personalizado y profesional */
    .tooltip-inner {
        max-width: 320px;
        text-align: left;
        padding: 10px 14px;
        background-color: #1e293b;
        border-radius: 6px;
        font-size: 12px;
        line-height: 1.5;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .tooltip.bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #1e293b;
    }
    
    /* Botón exportar hover */
    .btn-light:hover {
        background-color: #f1f5f9 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }
</style>

<!-- Script para inicializar tooltips de Bootstrap -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar todos los tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover',
                html: false,
                delay: { show: 300, hide: 100 }
            });
        });
    });
</script>
@endsection
