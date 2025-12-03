@extends('layouts.vertical', ['title' => 'Centro de Comando'])

@section('css')
<style>
    :root {
        --bs-blue-navy: #0f172a;
        --bs-gray-soft: #f8fafc;
        --bs-border-color: #e2e8f0;
    }

    body {
        background-color: #f1f5f9;
    }

    /* Tarjetas Ejecutivas */
    .card-executive {
        background: #ffffff;
        border: 1px solid var(--bs-border-color);
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        margin-bottom: 1.5rem;
        transition: box-shadow 0.3s ease;
    }

    /* Encabezado de KPIs */
    .kpi-header {
        border-left: 4px solid var(--bs-blue-navy);
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .kpi-title {
        color: var(--bs-blue-navy);
        font-weight: 700;
        font-size: 1.25rem;
        margin: 0;
    }

    .kpi-subtitle {
        color: #64748b;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .kpi-number {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
        color: var(--bs-blue-navy);
    }

    /* Alertas Profesionales */
    .alert-executive {
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        border-left: 4px solid #ef4444;
        color: #991b1b;
        padding: 1rem 1.5rem;
        border-radius: 6px;
        box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.1);
        animation: slideInTop 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideInTop {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Tabla Profesional */
    .table-responsive {
        border-radius: 8px;
    }

    .table-executive {
        width: 100%;
        margin-bottom: 0;
        color: #334155;
        vertical-align: middle;
    }

    .table-executive thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e2e8f0;
        padding: 1rem 1.5rem;
    }

    .table-executive tbody td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.9rem;
    }

    .table-executive tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Animación de nueva fila (Flash sutil) */
    @keyframes highlightRow {
        0% { background-color: #fffbeb; }
        100% { background-color: transparent; }
    }

    .new-row {
        animation: highlightRow 2s ease-out;
    }

    /* Badges "Soft" (Estilo moderno) */
    .badge-soft {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 6px;
    }

    .badge-soft-danger { background-color: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }
    .badge-soft-warning { background-color: #fffbeb; color: #f59e0b; border: 1px solid #fef3c7; }
    .badge-soft-info { background-color: #eff6ff; color: #3b82f6; border: 1px solid #dbeafe; }
    .badge-soft-secondary { background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    /* Botones */
    .btn-executive {
        background-color: #fff;
        border: 1px solid #cbd5e1;
        color: #475569;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.4rem 1rem;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-executive:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    /* Estado de Conexión */
    .connection-pill {
        position: fixed;
        top: 25px;
        right: 25px;
        padding: 6px 16px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        z-index: 1050;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-dot {
        height: 8px;
        width: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .dot-success { background-color: #10b981; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2); }
    .dot-danger { background-color: #ef4444; box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2); }

    /* Tipografía monoespaciada para IDs */
    .font-monospace-custom {
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        color: var(--bs-blue-navy);
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-5">
    
<div id="connection-status" class="connection-pill" style="top: 85px;">
    <span class="status-dot dot-danger"></span> 
    <span id="status-text" class="text-secondary">Desconectado</span>
</div>
    
    <div class="card card-executive kpi-header mb-4">
        <div>
            <h2 class="kpi-title">Monitor de Control de Incidentes</h2>
            <p class="kpi-subtitle">
                <i class="fas fa-satellite-dish me-1"></i> Transmisión de datos en tiempo real
            </p>
        </div>
        <div class="text-end border-start ps-4">
            <div class="text-secondary text-uppercase small fw-bold mb-1">Total Activos</div>
            <div class="kpi-number" id="total-incidentes">0</div>
        </div>
    </div>

    <div id="alerta-incidente" class="alert-executive d-none mb-4">
        <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-circle fs-5 mt-1 me-3"></i>
            <div>
                <h6 class="fw-bold mb-1">Nueva Alerta de Seguridad</h6>
                <div id="alerta-texto" class="small"></div>
            </div>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.classList.add('d-none')"></button>
        </div>
    </div>

    <div class="card card-executive border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-executive" id="tabla-incidentes">
                <thead>
                    <tr>
                        <th width="10%">ID REF.</th>
                        <th width="15%">Clasificación</th>
                        <th width="20%">Ubicación</th>
                        <th width="10%">Prioridad</th>
                        <th width="20%">Asignación Hospitalaria</th>
                        <th width="10%" class="text-center">Víctimas</th>
                        <th width="15%" class="text-end">Gestión</th>
                    </tr>
                </thead>
                <tbody id="body-incidentes">
                    <tr id="empty-state">
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted opacity-50">
                                <i class="fas fa-clipboard-check fs-2 mb-2"></i>
                                <p class="small m-0">Sin incidentes pendientes en cola</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<audio id="sonido-alerta">
    <source src="/sounds/alert.mp3" type="audio/mpeg">
</audio>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const wsUrl = "ws://localhost:8080";
    const statusEl = document.getElementById("connection-status");
    const statusTextEl = document.getElementById("status-text");
    const statusDotEl = statusEl.querySelector(".status-dot");
    let totalIncidentes = 0;
    
    console.log("Conectando a C5 Secure Network...");
    let ws = new WebSocket(wsUrl);

    // --- 1. MANEJO DE MENSAJES ---
    ws.onmessage = function(event) {
        let mensaje = JSON.parse(event.data);
        console.log("Evento recibido:", mensaje.event);

        // CASO A: NUEVA ASIGNACIÓN (FASE 1)
        if (mensaje.event === "ambulancia.asignada") {
            // La estructura aquí es { incidente: {...}, ambulancia: {...} }
            const incidente = mensaje.data.incidente;
            procesarIncidente(incidente, true); // true = es nuevo
        }
        
        // CASO B: ACTUALIZACIÓN DE DATOS (FASE 2 - IA)
        else if (mensaje.event === "incidente.actualizado") {
            // La estructura aquí es directa: el objeto incidente
            const incidente = mensaje.data;
            procesarIncidente(incidente, false); // false = es actualización
        }
    };

    // --- 2. FUNCIÓN CENTRAL DE PROCESAMIENTO ---
    function procesarIncidente(incidente, esNuevo) {
        const tbody = document.getElementById("body-incidentes");
        
        // Buscamos si ya existe la fila (para evitar duplicados o para actualizar)
        const filaExistente = document.getElementById(`fila-${incidente.id}`);

        if (filaExistente) {
            // --- ESCENARIO: ACTUALIZACIÓN ---
            console.log(`Actualizando fila #${incidente.id}...`);
            
            // Actualizamos celdas específicas
            // Celda 5: Victimas
            const celdaVictimas = filaExistente.querySelector(".col-victimas");
            celdaVictimas.innerHTML = `<span class="fw-bold">${incidente.numero_victimas ?? 0}</span>`;

            // Celda 3: Prioridad (por si cambió)
            const celdaPrioridad = filaExistente.querySelector(".col-prioridad");
            celdaPrioridad.innerHTML = generarBadgePrioridad(incidente.prioridad);

            // Efecto visual de "Dato Actualizado"
            filaExistente.classList.add("row-updated");
            setTimeout(() => filaExistente.classList.remove("row-updated"), 2000);
            
            // Notificación discreta
            mostrarAlertaFlotante(`Actualización: Incidente #${incidente.id}`, `Nuevos datos recibidos del operador.`);

        } else {
            // --- ESCENARIO: NUEVO INCIDENTE ---
            console.log(`Creando nueva fila #${incidente.id}...`);
            
            // Quitar empty state
            const emptyState = document.getElementById("empty-state");
            if (emptyState) emptyState.remove();

            const html = generarHTMLFila(incidente);
            tbody.insertAdjacentHTML("afterbegin", html);
            
            // Contadores
            totalIncidentes++;
            document.getElementById("total-incidentes").textContent = totalIncidentes;

            // Alerta Sonora y Visual
            document.getElementById("sonido-alerta").play().catch(() => {});
            mostrarAlertaFlotante(`¡NUEVO INCIDENTE!`, `Tipo: ${incidente.tipo} en ${incidente.ubicacion}`);
        }
    }

    // --- 3. GENERADORES DE HTML ---
    function generarHTMLFila(incidente) {
        return `
            <tr id="fila-${incidente.id}" class="new-row">
                <td class="font-monospace-custom">#${incidente.id}</td>
                <td><span class="fw-bold text-dark">${incidente.tipo}</span></td>
                <td class="text-secondary"><i class="fas fa-map-pin me-1 text-muted small"></i> ${incidente.ubicacion}</td>
                <td class="col-prioridad">${generarBadgePrioridad(incidente.prioridad)}</td>
                <td class="text-secondary">${incidente.hospital_asignado || '<span class="text-muted fst-italic">Calculando...</span>'}</td>
                <td class="text-center col-victimas"><span class="fw-bold">${incidente.numero_victimas ?? '--'}</span></td>
                <td class="text-end">
                    <a href="/incidentes/${incidente.id}" class="btn btn-executive btn-sm">Monitor</a>
                </td>
            </tr>
        `;
    }

    function generarBadgePrioridad(prioridad) {
        let p = prioridad ? prioridad.toLowerCase() : 'media';
        let clase = 'badge-soft-warning';
        if (p === 'alta') clase = 'badge-soft-danger';
        if (p === 'baja') clase = 'badge-soft-info';
        return `<span class="badge badge-soft ${clase}">${prioridad || 'Media'}</span>`;
    }

    function mostrarAlertaFlotante(titulo, mensaje) {
        const alertaDiv = document.getElementById("alerta-incidente");
        document.getElementById("alerta-texto").innerHTML = `<strong>${titulo}</strong><br>${mensaje}`;
        alertaDiv.classList.remove("d-none");
        setTimeout(() => alertaDiv.classList.add("d-none"), 6000);
    }

    // --- EVENTOS DE CONEXIÓN (Status) ---
    ws.onopen = () => {
        statusDotEl.className = 'status-dot dot-success';
        statusTextEl.innerText = 'Conectado al sistema';
    };
    ws.onclose = () => {
        statusDotEl.className = 'status-dot dot-danger';
        statusTextEl.innerText = 'Sin Señal';
    };
});
</script>

<style>
    /* Animación para cuando se actualiza un dato (Flash Azul) */
    @keyframes flashUpdate {
        0% { background-color: #dbeafe; }
        100% { background-color: transparent; }
    }
    .row-updated {
        animation: flashUpdate 2s ease-out;
    }
</style>
@endsection