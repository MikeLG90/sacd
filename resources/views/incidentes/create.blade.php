@extends('layouts.vertical', ['title' => 'Nuevo Incidente'])

@section('content')
<style>
    /* --- Variables de Color --- */
    :root {
        --primary-red: #dc2626;
        --primary-red-dark: #991b1b;
        --ai-gradient-start: #10a37f;
        --ai-gradient-end: #1a7f64;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    /* --- Estilos Globales --- */
    body {
        background-color: #f8fafc;
    }

    /* --- Headers Personalizados --- */
    .card-header-custom {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
        display: flex;
        align-items: center;
        gap: 0.875rem;
        position: relative;
        overflow: hidden;
    }

    .card-header-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .card-header-custom h4 { 
        margin: 0; 
        font-size: 1.125rem; 
        font-weight: 700;
        letter-spacing: 0.025em;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 1;
    }

    .card-header-custom svg {
        z-index: 1;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }

    /* --- Card Styles --- */
    .card-custom {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
    }

    .card-custom:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-4px);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* --- Video Container --- */
    .video-container { 
        position: relative; 
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 0.75rem; 
        overflow: hidden;
        box-shadow: inset 0 2px 8px rgba(0,0,0,0.3);
    }

    .live-badge {
        position: absolute; 
        top: 1rem; 
        right: 1rem;
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: white;
        padding: 0.5rem 1rem; 
        border-radius: 2rem;
        font-size: 0.75rem; 
        font-weight: 800; 
        display: flex; 
        align-items: center; 
        gap: 0.5rem;
        z-index: 10; 
        animation: pulse-badge 2s cubic-bezier(0.4,0,0.6,1) infinite;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.5);
        letter-spacing: 0.1em;
    }

    @keyframes pulse-badge { 
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.9; transform: scale(1.05); } 
    }

    .pulse-dot { 
        width: 10px;
        height: 10px;
        background: white;
        border-radius: 50%;
        animation: pulse-dot 1.5s ease-in-out infinite;
        box-shadow: 0 0 8px rgba(255,255,255,0.8);
    }

    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.7; }
    }

    /* --- Form Styles --- */
    .form-control, .form-control-sm {
        border: 2px solid #e5e7eb; 
        border-radius: 0.5rem; 
        padding: 0.625rem 0.875rem; 
        transition: all 0.2s ease;
        font-size: 0.9375rem;
    }

    .form-control:focus, .form-control-sm:focus { 
        border-color: #dc2626; 
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1); 
        outline: none; 
    }

    label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Added styles for label icons */
    .label-icon {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    /* Added styles for priority icons */
    .priority-icon {
        width: 16px;
        height: 16px;
        margin-right: 0.375rem;
        vertical-align: middle;
    }

    /* --- Section Headers --- */
    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .section-header h5 {
        margin: 0;
        color: #1f2937;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 0.025em;
    }

    .section-number {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.875rem;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
    }

    /* --- Botón Despacho --- */
    .btn-despacho {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white; 
        font-weight: 800; 
        text-transform: uppercase; 
        letter-spacing: 0.05em;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4); 
        border: none; 
        padding: 1.125rem 1.5rem; 
        width: 100%; 
        margin-bottom: 1.5rem;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 0.75rem; 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 0.75rem;
        font-size: 0.9375rem;
        position: relative;
        overflow: hidden;
    }

    .btn-despacho::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-despacho:hover::before {
        left: 100%;
    }

    .btn-despacho:hover { 
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-2px); 
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.5);
    }

    .btn-despacho:disabled { 
        background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
        cursor: not-allowed; 
        transform: none; 
    }

    .btn-despacho.enviado { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        pointer-events: none; 
        animation: success-pulse 0.5s ease-out;
    }

    @keyframes success-pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* --- Botón IA Mejorado con Logo ChatGPT --- */
    .btn-ai {
        font-size: 0.8125rem; 
        font-weight: 700; 
        color: white;
        border: none;
        background: linear-gradient(135deg, var(--ai-gradient-start) 0%, var(--ai-gradient-end) 100%);
        padding: 0.5rem 1rem; 
        border-radius: 0.5rem; 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(16, 163, 127, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-ai::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-ai:hover::before {
        left: 100%;
    }

    .btn-ai:hover { 
        background: linear-gradient(135deg, #0d8c6a 0%, #0a6b51 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 163, 127, 0.4);
    }

    .btn-ai:disabled { 
        color: #9ca3af; 
        border: 1px solid #e5e7eb; 
        background: #f9fafb; 
        box-shadow: none;
    }

    .chatgpt-logo {
        width: 18px;
        height: 18px;
        filter: brightness(0) invert(1);
    }

    /* --- Info Badge --- */
    .info-badge { 
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        padding: 0.875rem 1.125rem;
        border-radius: 0.75rem;
        font-size: 0.875rem; 
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        border: 2px solid #93c5fd;
        box-shadow: 0 2px 8px rgba(30, 64, 175, 0.1);
    }

    .info-badge svg {
        flex-shrink: 0;
    }

    /* --- Alert Custom --- */
    .alert-custom {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 2px solid #fbbf24;
        border-radius: 0.75rem;
        padding: 0.875rem 1.125rem;
        font-size: 0.875rem;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    /* --- Mapa --- */
    #mapa-dron { 
        border-radius: 0.75rem; 
        height: 320px; 
        margin-bottom: 1rem;
        box-shadow: inset 0 2px 8px rgba(0,0,0,0.1);
        border: 2px solid #e5e7eb;
    }

    /* --- Hospital Field --- */
    .hospital-field {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 2px solid #7dd3fc !important;
        font-weight: 600;
        color: #0c4a6e;
    }

    /* --- Submit Button --- */
    .btn-submit-final {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-submit-final:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    /* --- Divider --- */
    .custom-divider {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        margin: 2rem 0;
    }

    /* --- Row Spacing --- */
    .form-row-spacing {
        margin-bottom: 1rem;
    }

    /* --- Responsive --- */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .btn-despacho {
            font-size: 0.875rem;
            padding: 1rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Columna Izquierda: Video y Mapa -->
        <div class="col-lg-8">
            <!-- Card Video -->
            <div class="card card-custom mb-4">
                <div class="card-header-custom">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="23 7 16 12 23 17 23 7"/>
                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                    </svg>
                    <h4 class="text-white">Transmisión en Vivo del Dron</h4>
                </div>
                <div class="card-body">
                    <div class="video-container">
                        <div class="live-badge">
                            <span class="pulse-dot"></span>
                            EN VIVO
                        </div>
                        <video id="video-dron" controls autoplay muted style="width:100%; height:280px; display:block;"></video>
                    </div>
                </div>
            </div>

            <!-- Card Mapa -->
            <div class="card card-custom">
                <div class="card-header-custom">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <h4 class="text-white">Ubicación del Incidente</h4>
                </div>
                <div class="card-body">
                    <div class="info-badge">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        <span><strong>Instrucción:</strong> Arrastra el marcador en el mapa para fijar el punto exacto del incidente y asignar el hospital más cercano</span>
                    </div>
                    <div id="mapa-dron"></div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Formulario -->
        <div class="col-lg-4">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <h4 class="text-white">Gestión de Incidente</h4>
                </div>
                <div class="card-body">
                    <form id="form-incidente" action="{{ route('incidentes.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="incidente_id" name="incidente_id">
                        <div id="method-field-container"></div>

                        <!-- Sección 1: Datos de Despacho -->
                        <div class="section-header">
                            <div class="section-number">1</div>
                            <h5>Datos de Despacho</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de Incidente</label>
                            <input type="text" name="tipo" id="tipo" class="form-control" required placeholder="Ej: Atropello, Choque, Accidente...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prioridad Inicial</label>
                            <!-- Replaced emoji icons with SVG icons in select options -->
                            <select name="prioridad" id="prioridad" class="form-control">
                                <option value="alta" selected>
                                    <svg class="priority-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" fill="#dc2626"/>
                                    </svg>
                                    Alta
                                </option>
                                <option value="media">
                                    <svg class="priority-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" fill="#eab308"/>
                                    </svg>
                                    Media
                                </option>
                                <option value="baja">
                                    <svg class="priority-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" fill="#16a34a"/>
                                    </svg>
                                    Baja
                                </option>
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted small">Latitud</label>
                                <input type="number" step="any" name="lat" id="lat" class="form-control form-control-sm" readonly required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small">Longitud</label>
                                <input type="number" step="any" name="lng" id="lng" class="form-control form-control-sm" readonly required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Ubicación (Referencia)</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control form-control-sm" readonly required>
                        </div>

                        <div class="mb-3">
                            <!-- Replaced hospital emoji with SVG icon -->
                            <label class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                    <path d="M12 2v20"/>
                                    <path d="M8 12h8"/>
                                </svg>
                                Hospital Asignado (Automático)
                            </label>
                            <input type="text" name="hospital_asignado" id="hospital_asignado" class="form-control hospital-field" readonly>
                        </div>

                        <div class="mb-3">
                            <!-- Replaced clock emoji with SVG icon -->
                            <label class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                Fecha y Hora
                            </label>
                            <input type="datetime-local" name="hora" id="hora" class="form-control" required value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>

                        <!-- Botón Despacho -->
                        <button type="button" id="btn-despacho-rapido" class="btn btn-despacho">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                            </svg>
                            <span>Despachar Ambulancia Ahora</span>
                        </button>

                        <!-- Divider -->
                        <hr class="custom-divider">

                        <!-- Sección 2: Detalles Complementarios -->
                        <div class="section-header">
                            <div class="section-number">2</div>
                            <h5>Detalles Complementarios</h5>
                        </div>

                        <div class="alert-custom">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                            <span>Completa los detalles y usa la <strong>IA</strong> para mejorar la comunicación con el equipo médico.</span>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Descripción Visual</label>
                                <button type="button" class="btn btn-ai" onclick="mejorarTextoIA('descripcion')">
                                    <svg class="chatgpt-logo" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M22.2819 9.8211a5.9847 5.9847 0 0 0-.5157-4.9108 6.0462 6.0462 0 0 0-6.5098-2.9A6.0651 6.0651 0 0 0 4.9807 4.1818a5.9847 5.9847 0 0 0-3.9977 2.9 6.0462 6.0462 0 0 0 .7427 7.0966 5.98 5.98 0 0 0 .511 4.9107 6.051 6.051 0 0 0 6.5146 2.9001A5.9847 5.9847 0 0 0 13.2599 24a6.0557 6.0557 0 0 0 5.7718-4.2058 5.9894 5.9894 0 0 0 3.9977-2.9001 6.0557 6.0557 0 0 0-.7475-7.0729zm-9.022 12.6081a4.4755 4.4755 0 0 1-2.8764-1.0408l.1419-.0804 4.7783-2.7582a.7948.7948 0 0 0 .3927-.6813v-6.7369l2.02 1.1686a.071.071 0 0 1 .038.052v5.5826a4.504 4.504 0 0 1-4.4945 4.4944zm-9.6607-4.1254a4.4708 4.4708 0 0 1-.5346-3.0137l.142.0852 4.783 2.7582a.7712.7712 0 0 0 .7806 0l5.8428-3.3685v2.3324a.0804.0804 0 0 1-.0332.0615L9.74 19.9502a4.4992 4.4992 0 0 1-6.1408-1.6464zM2.3408 7.8956a4.485 4.485 0 0 1 2.3655-1.9728V11.6a.7664.7664 0 0 0 .3879.6765l5.8144 3.3543-2.0201 1.1685a.0757.0757 0 0 1-.071 0l-4.8303-2.7865A4.504 4.504 0 0 1 2.3408 7.872zm16.5963 3.8558L13.1038 8.364 15.1192 7.2a.0757.0757 0 0 1 .071 0l4.8303 2.7913a4.4944 4.4944 0 0 1-.6765 8.1042v-5.6772a.79.79 0 0 0-.407-.667zm2.0107-3.0231l-.142-.0852-4.7735-2.7818a.7759.7759 0 0 0-.7854 0L9.409 9.2297V6.8974a.0662.0662 0 0 1 .0284-.0615l4.8303-2.7866a4.4992 4.4992 0 0 1 6.6802 4.66zM8.3065 12.863l-2.02-1.1638a.0804.0804 0 0 1-.038-.0567V6.0742a4.4992 4.4992 0 0 1 7.3757-3.4537l-.142.0805L8.704 5.459a.7948.7948 0 0 0-.3927.6813zm1.0976-2.3654l2.602-1.4998 2.6069 1.4998v2.9994l-2.5974 1.4997-2.6067-1.4997Z"/>
                                    </svg>
                                    <span>Mejorar con IA</span>
                                </button>
                            </div>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Ej: Herida en la cabeza con sangrado abundante..."></textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <!-- Replaced users emoji with SVG icon -->
                                <label class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                    Víctimas
                                </label>
                                <input type="number" name="numero_victimas" class="form-control" placeholder="Cantidad">
                            </div>
                            <div class="col-6">
                                <!-- Replaced medical symbol emoji with SVG icon -->
                                <label class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2v20"/>
                                        <path d="M2 12h20"/>
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    </svg>
                                    Gravedad
                                </label>
                                <input type="text" name="gravedad_heridos" class="form-control" placeholder="Leve/Grave">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Observaciones</label>
                                <button type="button" class="btn btn-ai" onclick="mejorarTextoIA('observaciones')">
                                    <svg class="chatgpt-logo" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M22.2819 9.8211a5.9847 5.9847 0 0 0-.5157-4.9108 6.0462 6.0462 0 0 0-6.5098-2.9A6.0651 6.0651 0 0 0 4.9807 4.1818a5.9847 5.9847 0 0 0-3.9977 2.9 6.0462 6.0462 0 0 0 .7427 7.0966 5.98 5.98 0 0 0 .511 4.9107 6.051 6.051 0 0 0 6.5146 2.9001A5.9847 5.9847 0 0 0 13.2599 24a6.0557 6.0557 0 0 0 5.7718-4.2058 5.9894 5.9894 0 0 0 3.9977-2.9001 6.0557 6.0557 0 0 0-.7475-7.0729zm-9.022 12.6081a4.4755 4.4755 0 0 1-2.8764-1.0408l.1419-.0804 4.7783-2.7582a.7948.7948 0 0 0 .3927-.6813v-6.7369l2.02 1.1686a.071.071 0 0 1 .038.052v5.5826a4.504 4.504 0 0 1-4.4945 4.4944zm-9.6607-4.1254a4.4708 4.4708 0 0 1-.5346-3.0137l.142.0852 4.783 2.7582a.7712.7712 0 0 0 .7806 0l5.8428-3.3685v2.3324a.0804.0804 0 0 1-.0332.0615L9.74 19.9502a4.4992 4.4992 0 0 1-6.1408-1.6464zM2.3408 7.8956a4.485 4.485 0 0 1 2.3655-1.9728V11.6a.7664.7664 0 0 0 .3879.6765l5.8144 3.3543-2.0201 1.1685a.0757.0757 0 0 1-.071 0l-4.8303-2.7865A4.504 4.504 0 0 1 2.3408 7.872zm16.5963 3.8558L13.1038 8.364 15.1192 7.2a.0757.0757 0 0 1 .071 0l4.8303 2.7913a4.4944 4.4944 0 0 1-.6765 8.1042v-5.6772a.79.79 0 0 0-.407-.667zm2.0107-3.0231l-.142-.0852-4.7735-2.7818a.7759.7759 0 0 0-.7854 0L9.409 9.2297V6.8974a.0662.0662 0 0 1 .0284-.0615l4.8303-2.7866a4.4992 4.4992 0 0 1 6.6802 4.66zM8.3065 12.863l-2.02-1.1638a.0804.0804 0 0 1-.038-.0567V6.0742a4.4992 4.4992 0 0 1 7.3757-3.4537l-.142.0805L8.704 5.459a.7948.7948 0 0 0-.3927.6813zm1.0976-2.3654l2.602-1.4998 2.6069 1.4998v2.9994l-2.5974 1.4997-2.6067-1.4997Z"/>
                                    </svg>
                                    <span>Mejorar con IA</span>
                                </button>
                            </div>
                            <textarea name="observaciones" id="observaciones" class="form-control" rows="3" placeholder="Detalles adicionales del incidente..."></textarea>
                        </div>

                        <!-- Botón Submit Final -->
                        <button type="submit" id="btn-submit-final" class="btn btn-primary btn-submit-final w-100">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                                <polyline points="7 3 7 8 15 8"/>
                            </svg>
                            Guardar Informe Completo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<script>

// --- Configuración Inicial ---
let dronCoords = { 
    lat: {{ $lat }}, 
    lng: {{ $lng }} 
};

let incidentId = null;

// --- Datos de Hospitales ---
const hospitales = [
    { nombre: 'Hospital General de Chetumal (SESA)', lat: 18.5094, lng: -88.3009 },
    { nombre: 'Hospital General de Cancún "Jesús Kumate Rodríguez"', lat: 21.1619, lng: -86.8515 },
    { nombre: 'Hospital General de Playa del Carmen (SESA)', lat: 20.6296, lng: -87.0739 },
    { nombre: 'Hospital General de Cozumel (SESA)', lat: 20.5100, lng: -86.9500 },
    { nombre: 'Hospital Integral de Felipe Carrillo Puerto (SESA)', lat: 19.5800, lng: -88.0500 },
    { nombre: 'Hospital Integral de Kantunilkín (SESA)', lat: 21.2000, lng: -87.4500 }
];

// --- Calcular Hospital Cercano ---
function calcularHospitalCercano(lat, lng) {
    let minDist = Infinity;
    let hospitalCercano = "No disponible";
    hospitales.forEach(h => {
        const dx = h.lat - lat;
        const dy = h.lng - lng;
        const dist = Math.sqrt(dx*dx + dy*dy);
        if (dist < minDist) {
            minDist = dist;
            hospitalCercano = h.nombre;
        }
    });
    return hospitalCercano;
}

// --- Inicialización del Video ---
document.addEventListener("DOMContentLoaded", () => {
    const video = document.getElementById('video-dron');
    const src = "http://192.168.1.108:8080/hls/drone1/index.m3u8";
    
    if (Hls.isSupported()) {
        const hls = new Hls();
        hls.loadSource(src);
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED, () => video.play());
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = src;
        video.addEventListener('loadedmetadata', () => video.play());
    }
});

// --- Inicialización del Mapa ---
document.addEventListener("DOMContentLoaded", async () => {
    const mapa = L.map('mapa-dron').setView([dronCoords.lat, dronCoords.lng], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, 
        attribution: '&copy; OpenStreetMap'
    }).addTo(mapa);

    const marker = L.marker([dronCoords.lat, dronCoords.lng], { draggable: true })
        .addTo(mapa)
        .bindPopup("Punto de incidente")
        .openPopup();

    function updateCoords(lat, lng) {
        document.getElementById('lat').value = lat.toFixed(6);
        document.getElementById('lng').value = lng.toFixed(6);
        document.getElementById('ubicacion').value = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
        
        const hospital = calcularHospitalCercano(lat, lng);
        document.getElementById('hospital_asignado').value = hospital;
    }

    marker.on('dragend', function() {
        const pos = marker.getLatLng();
        updateCoords(pos.lat, pos.lng);
    });

    updateCoords(dronCoords.lat, dronCoords.lng);
});

// --- Despacho Rápido ---
document.getElementById('btn-despacho-rapido').addEventListener('click', async function() {
    const btn = this;
    const lat = document.getElementById('lat').value;
    const tipo = document.getElementById('tipo').value;
    const hospital = document.getElementById('hospital_asignado').value;

    if(!tipo) {
        alert("Por favor ingresa el TIPO de incidente.");
        document.getElementById('tipo').focus();
        return;
    }

    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span>DESPACHANDO...</span>';

    const payload = {
        lat: lat,
        lng: document.getElementById('lng').value,
        ubicacion: document.getElementById('ubicacion').value,
        tipo: tipo,
        prioridad: document.getElementById('prioridad').value,
        hora: document.getElementById('hora').value,
        hospital_asignado: hospital
    };

    try {
        const response = await fetch("{{ route('incidentes.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (response.ok) {
            btn.classList.add('enviado');
            btn.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg><span>UNIDAD EN CAMINO</span>';
            
            incidentId = data.id;
            document.getElementById('incidente_id').value = incidentId;
            
            const form = document.getElementById('form-incidente');
            form.action = "/incidentes/" + incidentId;
            document.getElementById('method-field-container').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('btn-submit-final').innerText = "Actualizar Informe";
            
            alert("Unidad despachada desde " + hospital);
        } else {
            throw new Error(data.message || 'Error en servidor');
        }
    } catch (error) {
        console.error(error);
        alert("Error: " + error.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
});

// --- Mejora con IA ---
async function mejorarTextoIA(campoId) {
    const input = document.getElementById(campoId);
    const textoActual = input.value;
    const btn = document.querySelector(`button[onclick="mejorarTextoIA('${campoId}')"]`);
    const textoBtnOriginal = btn.innerHTML;

    if (!textoActual || textoActual.length < 3) {
        alert("Escribe al menos unas palabras para que la IA funcione.");
        input.focus();
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<svg class="chatgpt-logo" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg><span>Procesando...</span>';
    input.style.backgroundColor = '#f3f4f6';

    try {
        const response = await fetch("{{ route('ia.optimizar') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ texto: textoActual })
        });

        const data = await response.json();

        if (data.success) {
            input.style.transition = "all 0.5s ease";
            input.style.backgroundColor = "#d1fae5";
            input.style.transform = "scale(1.02)";
            input.value = data.optimizado;
            
            setTimeout(() => {
                input.style.backgroundColor = "";
                input.style.transform = "scale(1)";
            }, 1000);
        } else {
            alert("Error IA: " + data.message);
        }
    } catch (error) {
        console.error(error);
        alert("Error conectando con el servicio de IA.");
    } finally {
        btn.disabled = false;
        btn.innerHTML = textoBtnOriginal;
    }
}
</script>

@endsection
