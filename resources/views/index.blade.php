@extends('layouts.vertical', ['title' => 'Dashboard de Emergencias'])

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .card {
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
    }
    
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 10;
        border-bottom: 2px solid #dee2e6;
    }
    
    .stat-card {
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    #mapa-chetumal {
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')

<!-- TARJETAS DE ESTADÍSTICAS -->
<div class="row">
    <!-- Emergencias activas -->
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="avatar-md bg-light bg-opacity-50 rounded">
                    <iconify-icon icon="solar:file-bold-duotone" class="fs-32 text-danger avatar-title"></iconify-icon>
                </div>
                <div class="text-end">
                    <p class="text-muted mb-0">Reportes generados</p>
                    <h3 class="text-dark mt-1 mb-0">1</h3>
                </div>
            </div>
            <div class="card-footer bg-light bg-opacity-50 py-2 d-flex justify-content-between">
                <a href="#" class="text-reset fw-semibold fs-12">Ver detalles</a>
            </div>
        </div>
    </div>

    <!-- Ambulancias disponibles 
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="avatar-md bg-light bg-opacity-50 rounded">
                    <iconify-icon icon="solar:ambulance-bold-duotone" class="fs-32 text-primary avatar-title"></iconify-icon>
                </div>
                <div class="text-end">
                    <p class="text-muted mb-0">Ambulancias disponibles</p>
                    <h3 class="text-dark mt-1 mb-0">7</h3>
                </div>
            </div>
            <div class="card-footer bg-light bg-opacity-50 py-2 d-flex justify-content-between">
                <a href="#" class="text-reset fw-semibold fs-12">Ver flota</a>
            </div>
        </div>
    </div>-->

    <!-- Drones activos -->
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="avatar-md bg-light bg-opacity-50 rounded">
                    <iconify-icon icon="mdi:drone" class="fs-32 text-info avatar-title"></iconify-icon>
                </div>
                <div class="text-end">
                    <p class="text-muted mb-0">Drones operativos</p>
                    <h3 class="text-dark mt-1 mb-0">1</h3>
                </div>
            </div>
            <div class="card-footer bg-light bg-opacity-50 py-2 d-flex justify-content-between">
                <a href="#" class="text-reset fw-semibold fs-12">Ver drones</a>
            </div>
        </div>
    </div>

    <!-- Hospitales disponibles -->
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="avatar-md bg-light bg-opacity-50 rounded">
                    <iconify-icon icon="solar:hospital-bold-duotone" class="fs-32 text-success avatar-title"></iconify-icon>
                </div>
                <div class="text-end">
                    <p class="text-muted mb-0">Hospitales</p>
                    <h3 class="text-dark mt-1 mb-0">6</h3>
                </div>
            </div>
            <div class="card-footer bg-light bg-opacity-50 py-2 d-flex justify-content-between">
                <a href="#" class="text-reset fw-semibold fs-12">Ver mapa</a>
            </div>
        </div>
    </div>
</div>

<!-- MAPA CENTRAL -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Mapa de disponibilidad</h4>
                <button class="btn btn-sm btn-outline-primary">
                    <i class="bx bx-refresh"></i> Actualizar
                </button>
            </div>
            <div class="card-body">
                <div id="mapa-chetumal" style="height: 450px; border-radius: 8px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- TABLA 1: ÚLTIMAS EMERGENCIAS -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    <i class="bx bx-alarm text-danger"></i> Últimas emergencias
                </h4>
                <a href="#" class="btn btn-sm btn-soft-primary">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Hora</th>
                                <th>Tipo</th>
                                <th>Ubicación</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Unidad Asignada</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-emergencias">
                            <!-- Los datos se cargarán dinámicamente -->
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Cargando datos...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABLA 2: VIALIDADES CERCANOS -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    Listado de vialidades
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Colonia</th>
                                <th>Localidad</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Alertas</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-vialidades">
                            <!-- Los datos se cargarán dinámicamente -->
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Cargando datos...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- TABLA 3: HOSPITALES CERCANOS -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    <i class="bx bx-hospital text-success"></i> Listado de hospitales
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Hospital</th>
                                <th>Zona de Cobertura</th>
                                <th>Unidades Totales</th>
                                <th>Disponibilidad</th>
                                <th>Tipo Ambulancia</th>
                                <th>Especialidades</th>
                                <th>Contacto</th>
                                <th>Correo</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-hospitales">
                            <!-- Los datos se cargarán dinámicamente -->
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Cargando datos...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.curve"></script>
<script src="https://unpkg.com/leaflet-ant-path"></script>
<script>
let mapa = null;

// Obtener datos del API
async function obtenerTDatos() {
    const r = await fetch("/api/datos-hackaton", { method: 'POST' });
    const data = await r.json();
    //console.log(data);
    return data;
}

// Función para colorear vialidades según estado
function colorPorEstado(estado) {
    estado = estado.toLowerCase();
    if (estado.includes("congestión")) return "orange";
    if (estado.includes("reparación") || estado.includes("cierre") || estado.includes("obra")) return "red";
    if (estado.includes("inundación")) return "blue";
    if (estado.includes("tráfico pesado")) return "purple";
    return "green";
}

// Cargar vialidades en la tabla
async function cargarVialidades() {
    const api = await obtenerTDatos();
    const vialidades = api.datosTablas.h25_vialidades;
    const tbody = document.getElementById("tabla-vialidades");
    tbody.innerHTML = "";
    
    if (vialidades.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">
                    No hay vialidades disponibles
                </td>
            </tr>
        `;
        return;
    }
    
    vialidades.forEach(v => {
        tbody.innerHTML += `
            <tr>
                <td><strong>${v.vialidad}</strong></td>
                <td>${v.colonia ?? "No definido"}</td>
                <td>${v.localidad ?? "No definido"}</td>
                <td>${v.descripcion_vialidad ?? "No definido"}</td>
                <td>${v.estado ?? "No definido"}</td>
                <td>${v.tipo_alertas ?? "No definido"}</td>
            </tr>
        `;
        console.log(v.vialidad);
    });
}

// Cargar hospitales en la tabla
async function cargarHospitales() {
    const api = await obtenerTDatos();
    const hospitales = api.datosTablas.h25_hospi;
    console.log(hospitales);
    const tbody = document.getElementById("tabla-hospitales");
    tbody.innerHTML = "";
    
    if (hospitales.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">
                    No hay hospitales disponibles
                </td>
            </tr>
        `;
        return;
    }
    
    hospitales.forEach(h => {
        tbody.innerHTML += `
            <tr>
                <td><strong>${h.hospitales}</strong></td>
                <td>${h.zona_cobertura ?? "No definido"}</td>
                <td><span class="badge bg-info">${h.total_unidades ?? "N/D"}</span></td>
                <td><span class="badge bg-success">${h.disponibilidad_unidades ?? "N/D"}</span></td>
                <td>${h.tipo_ambulancia ?? "N/D"}</td>
                <td><small>${h.especialidades ?? "N/D"}</small></td>
                <td>${h.telefono_contacto ?? "N/D"}</td>
                <td><small>${h["CORREO ELECTRÓNICO"] ?? "N/D"}</small></td>
            </tr>
        `;
    });
}

// Cargar vialidades en el mapa
async function cargarVialidadesEnMapa() {
    try {
        const api = await obtenerTDatos();
        const vialidades = api.datosTablas.h25_vialidades;
        
        vialidades.forEach(v => {
            const inicio = [v.latitud_inicio, v.longitud_inicio];
            const fin = [v.latitud_final, v.longitud_final];
            const color = colorPorEstado(v.estado);
            
            const outline = L.polyline([inicio, fin], {
                color: color,
                weight: 6,
                opacity: 0.9
            }).addTo(mapa);
            
            const linea = L.polyline([inicio, fin], {
                color: color,
                weight: 14,
                opacity: 0.2
            }).addTo(mapa);
            
            linea.bindPopup(`
                <div style="min-width: 200px;">
                    <h6><strong>${v.vialidad}</strong></h6>
                    <hr style="margin: 8px 0;">
                    <p style="margin: 4px 0;"><strong>Estado:</strong> ${v.estado}</p>
                    <p style="margin: 4px 0;"><strong>Alerta:</strong> ${v.tipo_alertas}</p>
                    <p style="margin: 4px 0;"><strong>Descripción:</strong> ${v.descripcion_vialidad}</p>
                </div>
            `);
        });
    } catch (error) {
        console.error("Error al cargar los datos: ", error);
    }
}

// Inicialización del mapa y drones volando
document.addEventListener("DOMContentLoaded", () => {
    console.log("hola");
    mapa = L.map('mapa-chetumal').setView([18.5036, -88.3055], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);
    
    L.marker([18.5036, -88.3055])
        .addTo(mapa)
        .bindPopup("<b>Chetumal, Q.Roo</b><br>Centro.")
        .openPopup();
    
    cargarVialidades();
    cargarHospitales();
    cargarVialidadesEnMapa();

    // --------------------------
    // Icono de internet
    const internetIcon = L.icon({
        iconUrl: 'https://iconos8.es/icon/21922/quadcopter', // Cambiar por tu icono
        iconSize: [40, 40],
        iconAnchor: [20, 20]
    });

    // Drones con rutas simuladas
    const drones = [
        {
            marker: L.marker([18.5036, -88.3055], {icon: internetIcon}).addTo(mapa),
            ruta: [
                [18.5036, -88.3055],
                [18.5060, -88.3080],
                [18.5100, -88.3100],
                [18.5036, -88.3055]
            ],
            index: 0
        },
        {
            marker: L.marker([18.5070, -88.3000], {icon: internetIcon}).addTo(mapa),
            ruta: [
                [18.5070, -88.3000],
                [18.5090, -88.3030],
                [18.5110, -88.3060],
                [18.5070, -88.3000]
            ],
            index: 0
        }
    ];

    // Función para mover drones
    function moverDrones() {
        drones.forEach(d => {
            d.index = (d.index + 1) % d.ruta.length;
            d.marker.setLatLng(d.ruta[d.index]);
        });
    }

    // Animar drones cada 500ms
    setInterval(moverDrones, 500);
});
</script>

@endsection