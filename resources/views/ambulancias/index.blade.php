@extends('layouts.vertical', ['title' => 'Ambulancias'])

@section('css')
<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #34495e;
        --accent-color: #3498db;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --info-color: #3498db;
        --border-color: #dee2e6;
        --bg-light: #f8f9fa;
    }
    
    .page-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1.5rem;
        margin: -1rem -1rem 2rem -1rem;
        border-left: 4px solid var(--accent-color);
    }
    
    .page-header h2 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 600;
        letter-spacing: -0.5px;
    }
    
    .page-header .subtitle {
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
        opacity: 0.85;
    }
    
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background-color: white;
        border: 1px solid var(--border-color);
        border-radius: 4px;
    }
    
    .btn-new {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .btn-new:hover {
        background-color: #2980b9;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
    }
    
    .table-container {
        background-color: white;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
    
    .table-professional {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    .table-professional thead th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
        white-space: nowrap;
    }
    
    .table-professional tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }
    
    .table-professional tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table-professional tbody tr:hover {
        background-color: var(--bg-light);
    }
    
    .ambulance-id {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.95rem;
    }
    
    .badge-status {
        padding: 0.4rem 0.8rem;
        border-radius: 3px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-block;
    }
    
    .status-disponible {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .status-en-ruta,
    .status-en-servicio,
    .status-ocupada {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }
    
    .status-mantenimiento {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .status-fuera-de-servicio {
        background-color: #e2e3e5;
        color: #383d41;
        border: 1px solid #d6d8db;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 0.4rem 0.9rem;
        font-size: 0.85rem;
        font-weight: 500;
        border: none;
        border-radius: 3px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .btn-view {
        background-color: var(--info-color);
        color: white;
    }
    
    .btn-view:hover {
        background-color: #2980b9;
        color: white;
    }
    
    .btn-edit {
        background-color: var(--warning-color);
        color: white;
    }
    
    .btn-edit:hover {
        background-color: #e67e22;
        color: white;
    }
    
    .btn-delete {
        background-color: var(--danger-color);
        color: white;
    }
    
    .btn-delete:hover {
        background-color: #c0392b;
    }
    
    .pagination-container {
        padding: 1rem;
        background-color: white;
        border: 1px solid var(--border-color);
        border-top: none;
        border-radius: 0 0 4px 4px;
    }
    
    .hospital-name {
        color: var(--secondary-color);
        font-weight: 500;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid px-4 py-4">
    
    <div class="page-header">
        <h2 style="color: white;">Gestión de Ambulancias</h2>
        <p class="subtitle">Administración y seguimiento de unidades móviles</p>
    </div>

    <div class="action-bar">
        <div>
            <strong>Total de ambulancias:</strong> {{ $ambulancias->total() }}
        </div>
        <a href="{{ route('ambulancias.create') }}" class="btn-new">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Nueva Ambulancia
        </a>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-professional">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Nombre</th>
                        <th>Placas</th>
                        <th>Hospital Asignado</th>
                        <th style="width: 140px;">Estado</th>
                        <th style="width: 280px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ambulancias as $a)
                    <tr>
                        <td>
                            <span class="ambulance-id">#{{ str_pad($a->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <strong>{{ $a->nombre }}</strong>
                        </td>
                        <td>
                            <span style="font-family: monospace; font-size: 0.95rem;">
                                {{ strtoupper($a->placas) }}
                            </span>
                        </td>
                        <td>
                            <span class="hospital-name">
                                {{ $a->hospital->nombre ?? 'Sin asignar' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status status-{{ strtolower(str_replace(' ', '-', $a->estado)) }}">
                                {{ $a->estado }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('ambulancias.show', $a->id) }}" 
                                   class="btn-action btn-view"
                                   title="Ver detalles">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                    Ver
                                </a>
                                <a href="{{ route('ambulancias.edit', $a->id) }}" 
                                   class="btn-action btn-edit"
                                   title="Editar ambulancia">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                    Editar
                                </a>
                                <form action="{{ route('ambulancias.destroy', $a->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('¿Está seguro de eliminar esta ambulancia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-action btn-delete"
                                            title="Eliminar ambulancia">
                                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5" style="color: #6c757d;">
                            <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="opacity: 0.3; margin-bottom: 1rem;">
                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                            </svg>
                            <div>
                                <strong>No hay ambulancias registradas</strong>
                            </div>
                            <small>Haga clic en "Nueva Ambulancia" para agregar la primera</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($ambulancias->hasPages())
    <div class="pagination-container">
        {{ $ambulancias->links() }}
    </div>
    @endif

</div>

@endsection