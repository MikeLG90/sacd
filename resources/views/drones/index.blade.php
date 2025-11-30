@extends('layouts.vertical', ['title' => 'Gestión de Drones'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg border-0" style="border-radius: 16px; overflow: hidden;">
            <!-- Header -->
            <div class="card-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 24px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: white;">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        <h4 class="mb-0" style="color: white; font-weight: 700; font-size: 24px;">Listado de Drones</h4>
                    </div>
                </div>
            </div>

            <!-- Tabla -->
            <div class="card-body" style="padding: 24px;">
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap table-centered mb-0">
                        <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px;">
                            <tr>
                                <th style="padding: 16px; font-weight: 700; color: #495057;">ID</th>
                                <th style="padding: 16px; font-weight: 700; color: #495057;">Nombre</th>
                                <th style="padding: 16px; font-weight: 700; color: #495057;">Modelo</th>
                                <th style="padding: 16px; font-weight: 700; color: #495057;">Estado</th>
                                <th style="padding: 16px; font-weight: 700; color: #495057;">Lat / Lng</th>
                                <th style="padding: 16px; font-weight: 700; color: #495057;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drones as $dron)
                            <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.2s ease;">
                                <td style="padding: 16px; font-weight: 600; color: #495057;">{{ $dron->id }}</td>
                                <td style="padding: 16px; color: #6c757d;">{{ $dron->nombre }}</td>
                                <td style="padding: 16px; color: #6c757d;">{{ $dron->modelo }}</td>
                                <td style="padding: 16px;">
                                    @if($dron->estado === 'Ocupado')
                                        <span class="badge d-inline-flex align-items-center gap-1" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                            {{ $dron->estado }}
                                        </span>
                                    @elseif($dron->estado === 'Mantenimiento')
                                        <span class="badge d-inline-flex align-items-center gap-1" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                            {{ $dron->estado }}
                                        </span>
                                    @else
                                        <span class="badge d-inline-flex align-items-center gap-1" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                            {{ $dron->estatus }}
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 16px; color: #6c757d;">{{ $dron->lat }}, {{ $dron->lng }}</td>
                                <td style="padding: 16px; display: flex; gap: 8px; flex-wrap: wrap;">

                                    <!-- Botón Nuevo Incidente -->
                                    <a href="{{ route('incidentes.create') }}?dron_id={{ $dron->id }}" class="btn btn-sm d-inline-flex align-items-center gap-2"
                                       style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 8px; padding: 8px 16px; font-weight: 600; box-shadow: 0 2px 6px rgba(220,50,50,0.3); transition: all 0.2s ease;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 5v14M5 12h14"/>
                                        </svg>
                                        Nuevo Incidente
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
