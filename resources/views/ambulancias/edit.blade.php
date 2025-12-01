@extends('layouts.vertical', ['title' => 'Editar Ambulancia'])

@section('css')
<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #34495e;
        --accent-color: #3498db;
        --success-color: #27ae60;
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
    
    .form-container {
        background-color: white;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        margin-bottom: 1.5rem;
    }
    
    .form-header {
        background-color: var(--bg-light);
        padding: 1rem 1.5rem;
        border-bottom: 2px solid var(--accent-color);
    }
    
    .form-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-body {
        padding: 2rem 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--secondary-color);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.5rem;
    }
    
    .form-group label .required {
        color: #e74c3c;
        margin-left: 0.25rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    
    .form-control:hover:not(:focus) {
        border-color: #adb5bd;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        padding: 1.5rem;
        background-color: var(--bg-light);
        border-top: 1px solid var(--border-color);
    }
    
    .btn-submit {
        padding: 0.75rem 2rem;
        font-size: 0.95rem;
        font-weight: 600;
        background-color: var(--success-color);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-submit:hover {
        background-color: #229954;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
    }
    
    .btn-cancel {
        padding: 0.75rem 2rem;
        font-size: 0.95rem;
        font-weight: 600;
        background-color: var(--secondary-color);
        color: white;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .btn-cancel:hover {
        background-color: #2c3e50;
        color: white;
        transform: translateY(-1px);
    }
    
    .icon {
        width: 16px;
        height: 16px;
    }
    
    .help-text {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid px-4 py-4">
    
    <div class="page-header">
        <h2 style="color: white;">Editar Ambulancia</h2>
        <p class="subtitle">Actualizar información de la unidad móvil</p>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h3>Información de la Ambulancia</h3>
        </div>
        
        <form action="{{ route('ambulancias.update', $ambulancia->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-body">
                <div class="form-group">
                    <label>
                        Hospital Asignado
                        <span class="required">*</span>
                    </label>
                    <select name="hospital_id" class="form-control" required>
                        <option value="">Seleccione un hospital</option>
                        @foreach ($hospitales as $h)
                            <option value="{{ $h->id }}" 
                                    @if($h->id == $ambulancia->hospital_id) selected @endif>
                                    {{ $h->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="help-text">Seleccione el hospital al que pertenece esta ambulancia</div>
                </div>

                <div class="form-group">
                    <label>
                        Nombre de la Ambulancia
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="nombre" 
                           class="form-control" 
                           value="{{ old('nombre', $ambulancia->nombre) }}" 
                           placeholder="Ej: Ambulancia A-01"
                           required>
                    <div class="help-text">Identificador único de la ambulancia</div>
                </div>

                <div class="form-group">
                    <label>Placas del Vehículo</label>
                    <input type="text" 
                           name="placas" 
                           class="form-control" 
                           value="{{ old('placas', $ambulancia->placas) }}"
                           placeholder="Ej: ABC-1234"
                           style="text-transform: uppercase;">
                    <div class="help-text">Número de placas de circulación</div>
                </div>

                <div class="form-group">
                    <label>
                        Estado Operativo
                        <span class="required">*</span>
                    </label>
                    <select name="estado" class="form-control" required>
                        <option value="disponible" @selected(old('estado', $ambulancia->estado)=='disponible')>
                            Disponible
                        </option>
                        <option value="ocupada" @selected(old('estado', $ambulancia->estado)=='ocupada')>
                            Ocupada
                        </option>
                        <option value="en_ruta" @selected(old('estado', $ambulancia->estado)=='en_ruta')>
                            En ruta
                        </option>
                        <option value="fuera_servicio" @selected(old('estado', $ambulancia->estado)=='fuera_servicio')>
                            Fuera de servicio
                        </option>
                    </select>
                    <div class="help-text">Estado actual de disponibilidad de la unidad</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <svg class="icon" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                    Actualizar Ambulancia
                </button>
                
                <a href="{{ route('ambulancias.index') }}" class="btn-cancel">
                    <svg class="icon" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>

@endsection