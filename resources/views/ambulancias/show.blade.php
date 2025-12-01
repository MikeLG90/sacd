@extends('layouts.vertical', ['title' => 'Ver Ambulancia'])

@section('css')
<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #34495e;
        --accent-color: #3498db;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
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
    
    .detail-card {
        background-color: white;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        margin-bottom: 1.5rem;
    }
    
    .detail-header {
        background-color: var(--bg-light);
        padding: 1rem 1.5rem;
        border-bottom: 2px solid var(--accent-color);
    }
    
    .detail-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .detail-body {
        padding: 0;
    }
    
    .detail-item {
        display: flex;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        transition: background-color 0.2s ease;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-item:hover {
        background-color: var(--bg-light);
    }
    
    .detail-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: var(--secondary-color);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .detail-value {
        flex: 1;
        color: #333;
        font-size: 0.95rem;
    }
    
    .ambulance-id {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }
    
    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 3px;
        font-size: 0.8rem;
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
    
    .action-bar {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 2rem;
    }
    
    .btn-action {
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .btn-back {
        background-color: var(--secondary-color);
        color: white;
    }
    
    .btn-back:hover {
        background-color: #2c3e50;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-edit {
        background-color: var(--warning-color);
        color: white;
    }
    
    .btn-edit:hover {
        background-color: #e67e22;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background-color: var(--danger-color);
        color: white;
    }
    
    .btn-delete:hover {
        background-color: #c0392b;
        transform: translateY(-1px);
    }
    
    .icon {
        width: 16px;
        height: 16px;
    }
    
    .plates {
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-color);
        letter-spacing: 1px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    
    <div class="page-header">
        <h2 style="color: white;">Detalle de Ambulancia</h2>
        <p class="subtitle">Información completa de la unidad móvil</p>
    </div>

    <div class="action-bar">
        <a href="{{ route('ambulancias.index') }}" class="btn-action btn-back">
            <svg class="icon" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Volver al listado
        </a>
        
        <a href="{{ route('ambulancias.edit', $ambulancia->id) }}" class="btn-action btn-edit">
            <svg class="icon" fill="currentColor" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
            Editar
        </a>
        
        <form action="{{ route('ambulancias.destroy', $ambulancia->id) }}" 
              method="POST" 
              class="d-inline"
              onsubmit="return confirm('¿Está seguro de eliminar esta ambulancia?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action btn-delete">
                <svg class="icon" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
                Eliminar
            </button>
        </form>
    </div>

    <div class="detail-card">
        <div class="detail-header">
            <h3>Información General</h3>
        </div>
        <div class="detail-body">
            <div class="detail-item">
                <div class="detail-label">ID de Ambulancia</div>
                <div class="detail-value">
                    <span class="ambulance-id">#{{ str_pad($ambulancia->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Nombre</div>
                <div class="detail-value">{{ $ambulancia->nombre }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Placas</div>
                <div class="detail-value">
                    <span class="plates">{{ strtoupper($ambulancia->placas) }}</span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Hospital Asignado</div>
                <div class="detail-value">
                    <strong>{{ $ambulancia->hospital->nombre }}</strong>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Estado Actual</div>
                <div class="detail-value">
                    <span class="badge-status status-{{ strtolower(str_replace(' ', '-', $ambulancia->estado)) }}">
                        {{ $ambulancia->estado }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection