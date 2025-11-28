@extends('layouts.vertical', ['title' => 'Nuevo Incidente'])

@section('content')
<style>
    /* --- Estilos personalizados --- */
    .card-header-custom {
        background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        color: white;
        padding: 1rem 1.25rem;
        border-bottom: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .card-header-custom h4 { margin: 0; font-size: 1.125rem; font-weight: 600; }
    .card-custom {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .card-custom:hover {
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .video-container { position: relative; background: #000; border-radius: 0.5rem; overflow: hidden; }
    .live-badge {
        position: absolute; top: 10px; right: 10px;
        background: #dc2626; color: white;
        padding: 0.375rem 0.75rem; border-radius: 9999px;
        font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.375rem;
        z-index: 10; animation: pulse 2s cubic-bezier(0.4,0,0.6,1) infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1;}50%{opacity:0.7;} }
    .pulse-dot { width:8px;height:8px;background:white;border-radius:50%;animation:pulse-dot 1.5s ease-in-out infinite; }
    @keyframes pulse-dot {0%,100%{transform:scale(1);opacity:1;}50%{transform:scale(1.2);opacity:0.8;}}
    .form-label-custom { display:flex; align-items:center; gap:0.5rem; font-weight:600; color:#374151; margin-bottom:0.5rem; }
    .form-control-custom { border:2px solid #e5e7eb; border-radius:0.5rem; padding:0.625rem 0.875rem; font-size:0.95rem; transition: all 0.2s ease; }
    .form-control-custom:focus { border-color:#dc2626; box-shadow:0 0 0 3px rgba(220,38,38,0.1); outline:none; }
    .form-control-custom:read-only { background-color:#f9fafb;color:#6b7280; }
    .btn-submit {
        background: linear-gradient(135deg,#dc2626 0%,#991b1b 100%);
        color:white; border:none; padding:0.75rem 2rem; border-radius:0.5rem;
        font-weight:600;font-size:1rem; display:flex; align-items:center; gap:0.5rem; justify-content:center; transition:all 0.3s ease;width:100%;
    }
    .btn-submit:hover { background: linear-gradient(135deg,#991b1b 0%,#7f1d1d 100%); transform: translateY(-2px); box-shadow:0 10px 15px -3px rgba(220,38,38,0.3);}
    .btn-submit:active { transform:translateY(0); }
    #mapa-dron { border-radius:0.5rem; height: 300px; margin-bottom: 1rem; }
    .info-badge { background:#dbeafe;color:#1e40af;padding:0.5rem 1rem;border-radius:0.5rem;font-size:0.875rem; display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem; }
</style>

<div class="row">
    <!-- Lado izquierdo: Mapa y Video -->
    <div class="col-md-8">
        <!-- Mapa -->


        <!-- Video -->
        <div class="card card-custom">
            <div class="card-header-custom">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="23 7 16 12 23 17 23 7"/>
                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                </svg>
                <h4>Transmisión en Vivo del Dron</h4>
            </div>
            <div class="card-body">
                <div class="video-container">
                    <div class="live-badge"><span class="pulse-dot"></span>EN VIVO</div>
                    <video id="video-dron" width="100%" height="240" controls autoplay muted loop>
                        <source src="{{ asset('videos/dron_simulado.mp4') }}" type="video/mp4">
                        Tu navegador no soporta video.
                    </video>
                </div>
            </div>
        </div>

                <div class="card card-custom mb-4">
            <div class="card-header-custom">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <h4>Mapa del Dron - Posición en Tiempo Real</h4>
            </div>
            <div class="card-body">
                <div class="info-badge">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>Arrastra el marcador en el mapa para actualizar la ubicación del incidente</span>
                </div>
                <div id="mapa-dron"></div>
            </div>
        </div>
    </div>

    <!-- Lado derecho: Formulario -->
    <div class="col-md-4">
        <div class="card card-custom">
            <div class="card-header-custom">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <h4>Registrar Nuevo Incidente</h4>
            </div>
            <div class="card-body">
<form action="{{ route('incidentes.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Tipo de Incidente</label>
        <input type="text" name="tipo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Ubicación</label>
        <input type="text" name="ubicacion" id="ubicacion" class="form-control" readonly required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Latitud</label>
            <input type="number" step="any" name="lat" id="lat" class="form-control" readonly required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Longitud</label>
            <input type="number" step="any" name="lng" id="lng" class="form-control" readonly required>
        </div>
    </div>

    <div class="mb-3">
        <label>Hospital Asignado</label>
        <input type="text" name="hospital_asignado" id="hospital_asignado" class="form-control" readonly required>
    </div>

    <div class="mb-3">
        <label>Hora del Incidente</label>
        <input type="datetime-local" name="hora" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Prioridad</label>
        <select name="prioridad" class="form-control" required>
            <option value="alta">Alta</option>
            <option value="media">Media</option>
            <option value="baja">Baja</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Número de Víctimas</label>
        <input type="number" name="numero_victimas" class="form-control">
    </div>

    <div class="mb-3">
        <label>Gravedad de Heridos</label>
        <input type="text" name="gravedad_heridos" class="form-control">
    </div>

    <div class="mb-3">
        <label>Observaciones</label>
        <textarea name="observaciones" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Registrar Incidente</button>
</form>

            </div>
        </div>
    </div>
</div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let dronCoords = { 
    lat: 18.5090, // posición inicial del dron
    lng: -88.3020
};

let hospitales = []; // este array se llenará desde la API

async function obtenerTDatos() {
    const r = await fetch("/api/datos-hackaton", { method:'POST' });
    const data = await r.json();
    return data;
}

async function cargarHospitales() {
    const api = await obtenerTDatos();
    const hospitalesApi = api.datosTablas.h25_hospi;

    // Agregar coordenadas simuladas a cada hospital
    hospitales = hospitalesApi.map(h => {
        switch (h.id) {
            case 1: return { ...h, lat: 21.1619, lng: -86.8515 }; // Cancún
            case 2: return { ...h, lat: 18.5094, lng: -88.3009 }; // Chetumal
            case 3: return { ...h, lat: 20.6296, lng: -87.0739 }; // Playa del Carmen
            case 4: return { ...h, lat: 20.5100, lng: -86.9500 }; // Cozumel
            case 5: return { ...h, lat: 19.5800, lng: -88.0500 }; // Felipe Carrillo Puerto
            case 6: return { ...h, lat: 21.2000, lng: -87.4500 }; // Kantunilkín
            default: return { ...h, lat: 0, lng: 0 };
        }
    });
}

// Función para calcular el hospital más cercano usando coordenadas
function calcularHospitalCercano(lat, lng){
    if(!hospitales.length) return null;
    let minDist = Infinity, hospital = null;
    hospitales.forEach(h => {
        const dx = h.lat - lat;
        const dy = h.lng - lng;
        const dist = Math.sqrt(dx*dx + dy*dy);
        if(dist < minDist){ 
            minDist = dist; 
            hospital = h.hospitales; // <-- nombre correcto del hospital
        }
    });
    return hospital;
}

document.addEventListener("DOMContentLoaded", async () => {
    await cargarHospitales();

    // Crear mapa
    const mapa = L.map('mapa-dron').setView([dronCoords.lat, dronCoords.lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);

    // Marcador del dron
    const marker = L.marker([dronCoords.lat, dronCoords.lng], { draggable:true })
        .addTo(mapa)
        .bindPopup("Posición del dron - Arrastra para mover")
        .openPopup();

    marker.on('dragend', function() {
        const pos = marker.getLatLng();
        document.getElementById('lat').value = pos.lat.toFixed(6);
        document.getElementById('lng').value = pos.lng.toFixed(6);
        document.getElementById('ubicacion').value = `Lat: ${pos.lat.toFixed(6)}, Lng: ${pos.lng.toFixed(6)}`;
        document.getElementById('hospital_asignado').value = calcularHospitalCercano(pos.lat, pos.lng) || "No disponible";
    });

    // Inicializar valores en formulario
    document.getElementById('lat').value = dronCoords.lat;
    document.getElementById('lng').value = dronCoords.lng;
    document.getElementById('ubicacion').value = `Lat: ${dronCoords.lat}, Lng: ${dronCoords.lng}`;
    document.getElementById('hospital_asignado').value = calcularHospitalCercano(dronCoords.lat, dronCoords.lng) || "No disponible";
});
</script>

@endsection
