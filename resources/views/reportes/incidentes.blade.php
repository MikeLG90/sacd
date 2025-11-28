@extends('layouts.vertical', ['title' => 'Reporte de Incidentes'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg border-0" style="border-radius: 16px; overflow: hidden;">
            <div class="card-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 24px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: white;">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        <h4 class="mb-0" style="color: white; font-weight: 700; font-size: 24px;">Listado de Incidentes</h4>
                    </div>
                    <a href="{{ route('reportes.incidentes.pdf') }}" class="btn btn-light btn-sm d-flex align-items-center gap-2" style="border-radius: 8px; padding: 10px 20px; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="12" y1="18" x2="12" y2="12"/>
                            <line x1="9" y1="15" x2="15" y2="15"/>
                        </svg>
                        Exportar PDF
                    </a>
                </div>
            </div>
            <div class="card-body" style="padding: 24px;">
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap table-centered mb-0">
                        <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px;">
<tr>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">
        <div class="d-flex align-items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/>
            </svg>
            ID
        </div>
    </th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">
        <div class="d-flex align-items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            Tipo de Incidente
        </div>
    </th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">
        <div class="d-flex align-items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 3h18v18H3z"/>
            </svg>
            Descripción
        </div>
    </th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">
        <div class="d-flex align-items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
            Ubicación
        </div>
    </th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">Lat / Lng</th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">
        <div class="d-flex align-items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            Hospital Asignado
        </div>
    </th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">Prioridad</th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;"># Víctimas</th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">Gravedad Heridos</th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">Observaciones</th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">
        <div class="d-flex align-items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            Estado
        </div>
    </th>
    <th style="padding: 16px; font-weight: 700; color: #495057; border: none;">
        <div class="d-flex align-items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="1"/>
                <circle cx="12" cy="5" r="1"/>
                <circle cx="12" cy="19" r="1"/>
            </svg>
            Acciones
        </div>
    </th>
</tr>

                        </thead>
<tbody>
@foreach($incidentes as $incidente)
<tr style="border-bottom: 1px solid #e9ecef; transition: all 0.2s ease;">
    <td style="padding: 16px; font-weight: 600; color: #495057;">{{ $incidente->id }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->tipo }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->descripcion }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->ubicacion }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->lat }}, {{ $incidente->lng }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->hospital_asignado }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->prioridad }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->numero_victimas ?? 'N/A' }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->gravedad_heridos ?? 'N/A' }}</td>
    <td style="padding: 16px; color: #6c757d;">{{ $incidente->observaciones ?? 'N/A' }}</td>
    <td style="padding: 16px;">
        @if($incidente->estado === 'Atendido')
            <span class="badge d-inline-flex align-items-center gap-1" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ $incidente->estado }}
            </span>
        @elseif($incidente->estado === 'En proceso')
            <span class="badge d-inline-flex align-items-center gap-1" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                {{ $incidente->estado }}
            </span>
        @else
            <span class="badge d-inline-flex align-items-center gap-1" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                {{ $incidente->estado }}
            </span>
        @endif
    </td>
    <td style="padding: 16px;">
        <a href="{{ route('pdf.individual', $incidente->id) }}" class="btn btn-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; border: none; border-radius: 8px; padding: 8px 16px; font-weight: 600; box-shadow: 0 2px 6px rgba(0,123,255,0.3); transition: all 0.2s ease;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

<style>
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection
