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

    /* Video Styles */
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

    /* Form Styles */
    .form-control-custom { border:2px solid #e5e7eb; border-radius:0.5rem; padding:0.625rem 0.875rem; transition: all 0.2s ease; }
    .form-control-custom:focus { border-color:#dc2626; box-shadow:0 0 0 3px rgba(220,38,38,0.1); outline:none; }
    .btn-despacho {
        background: #ef4444; color: white; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
        box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.4); border: none; padding: 1rem; width: 100%; margin-bottom: 1.5rem;
        display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s;
    }
    .btn-despacho:hover { background: #dc2626; transform: scale(1.02); }
    .btn-despacho:disabled { background: #9ca3af; cursor: not-allowed; transform: none; }
    .btn-despacho.enviado { background: #10b981; pointer-events: none; }

    #mapa-dron { border-radius:0.5rem; height: 300px; margin-bottom: 1rem; }
    .info-badge { background:#dbeafe;color:#1e40af;padding:0.5rem 1rem;border-radius:0.5rem;font-size:0.875rem; display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem; }
</style>

<div class="row">
    <div class="col-md-8">
        <div class="card card-custom mb-4">
            <div class="card-header-custom">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                <h4 class="text-white">Transmisión en vivo del dron</h4>
            </div>
            <div class="card-body">
                <div class="video-container">
                    <div class="live-badge"><span class="pulse-dot"></span>EN VIVO</div>
                    <video id="video-dron" controls autoplay muted style="width:100%; height:240px;"></video>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
        <script>
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
        </script>

        <div class="card card-custom">
            <div class="card-header-custom">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <h4 class="text-white">Mapa del incidente</h4>
            </div>
            <div class="card-body">
                <div class="info-badge">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>Arrastra el marcador para fijar el punto de encuentro y asignar hospital</span>
                </div>
                <div id="mapa-dron"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-custom">
            <div class="card-header-custom">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <h4 class="text-white">Gestión de Incidente</h4>
            </div>
            <div class="card-body">
                
                <form id="form-incidente" action="{{ route('incidentes.store') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" id="incidente_id" name="incidente_id">
                    <div id="method-field-container"></div>

                    <h5 class="mb-3 text-secondary fw-bold">1. Datos de Despacho</h5>

                    <div class="mb-2">
                        <label class="fw-bold">Tipo de Incidente</label>
                        <input type="text" name="tipo" id="tipo" class="form-control" required placeholder="Ej: Atropello, Choque...">
                    </div>

                    <div class="mb-2">
                        <label class="fw-bold">Prioridad Inicial</label>
                        <select name="prioridad" id="prioridad" class="form-control">
                            <option value="alta" selected>Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="small text-muted">Latitud</label>
                            <input type="number" step="any" name="lat" id="lat" class="form-control form-control-sm" readonly required>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="small text-muted">Longitud</label>
                            <input type="number" step="any" name="lng" id="lng" class="form-control form-control-sm" readonly required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="small text-muted">Ubicación (Ref)</label>
                        <input type="text" name="ubicacion" id="ubicacion" class="form-control form-control-sm" readonly required>
                    </div>
                    
                    <div class="mb-3">
                         <label class="small text-muted fw-bold">Hospital Sugerido (Auto)</label>
                         <input type="text" name="hospital_asignado" id="hospital_asignado" class="form-control form-control-sm" readonly style="background-color: #f0f9ff; border-color: #bae6fd;">
                    </div>

                    <div class="mb-3">
                         <label class="small text-muted">Hora</label>
                         <input type="datetime-local" name="hora" id="hora" class="form-control form-control-sm" required value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>

                    <button type="button" id="btn-despacho-rapido" class="btn btn-despacho rounded-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        <span>DESPACHAR AMBULANCIA AHORA</span>
                    </button>
                    
                    <hr class="my-4">

                    <h5 class="mb-3 text-secondary fw-bold">2. Detalles Complementarios</h5>
                    <div class="alert alert-light border small text-muted">
                        Llena estos datos mientras la ambulancia va en camino.
                    </div>

                    <div class="mb-3">
                        <label>Descripción Visual</label>
                        <textarea name="descripcion" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label>Víctimas</label>
                            <input type="number" name="numero_victimas" class="form-control">
                        </div>
                        <div class="col-6 mb-3">
                            <label>Gravedad</label>
                            <input type="text" name="gravedad_heridos" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="2"></textarea>
                    </div>

                    <button type="submit" id="btn-submit-final" class="btn btn-primary w-100 py-2 fw-bold">
                        Guardar Informe Completo
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// --- Configuración Inicial ---
let dronCoords = { lat: 18.5090, lng: -88.3020 };
let incidentId = null;

// --- Datos de Hospitales (Para cálculo en vivo) ---
// --- Datos de Hospitales (Nombres EXACTOS de la BD + Coordenadas manuales) ---
const hospitales = [
    { 
        nombre: 'Hospital General de Chetumal (SESA)', 
        lat: 18.5094, 
        lng: -88.3009 
    },
    { 
        nombre: 'Hospital General de Cancún "Jesús Kumate Rodríguez"', 
        lat: 21.1619, 
        lng: -86.8515 
    },
    { 
        nombre: 'Hospital General de Playa del Carmen (SESA)', 
        lat: 20.6296, 
        lng: -87.0739 
    },
    { 
        nombre: 'Hospital General de Cozumel (SESA)', 
        lat: 20.5100, 
        lng: -86.9500 
    },
    { 
        nombre: 'Hospital Integral de Felipe Carrillo Puerto (SESA)', 
        lat: 19.5800, 
        lng: -88.0500 
    },
    { 
        nombre: 'Hospital Integral de Kantunilkín (SESA)', 
        lat: 21.2000, 
        lng: -87.4500 
    }
];

// --- Lógica del Mapa y Hospital ---
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

document.addEventListener("DOMContentLoaded", async () => {
    // Mapa
    const mapa = L.map('mapa-dron').setView([dronCoords.lat, dronCoords.lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap'
    }).addTo(mapa);

    // Marcador
    const marker = L.marker([dronCoords.lat, dronCoords.lng], { draggable:true })
        .addTo(mapa)
        .bindPopup("Punto de incidente")
        .openPopup();

    function updateCoords(lat, lng) {
        document.getElementById('lat').value = lat.toFixed(6);
        document.getElementById('lng').value = lng.toFixed(6);
        document.getElementById('ubicacion').value = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
        
        // Calcular y mostrar hospital
        const hospital = calcularHospitalCercano(lat, lng);
        document.getElementById('hospital_asignado').value = hospital;
    }

    marker.on('dragend', function() {
        const pos = marker.getLatLng();
        updateCoords(pos.lat, pos.lng);
    });

    // Carga inicial
    updateCoords(dronCoords.lat, dronCoords.lng);
});

// --- Lógica AJAX (Despacho Rápido) ---
document.getElementById('btn-despacho-rapido').addEventListener('click', async function() {
    const btn = this;
    const lat = document.getElementById('lat').value;
    const tipo = document.getElementById('tipo').value;
    // Capturamos el hospital calculado por JS
    const hospital = document.getElementById('hospital_asignado').value; 
    
    if(!tipo) {
        alert("⚠️ Por favor ingresa el TIPO de incidente.");
        document.getElementById('tipo').focus();
        return;
    }

    // Estado cargando
    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span>⏳ ASIGNANDO...</span>';

    // Payload para Laravel
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
            // Éxito visual
            btn.classList.add('enviado');
            btn.innerHTML = '<span>✅ UNIDAD EN CAMINO</span>';
            
            // Guardar ID y preparar formulario para UPDATE
            incidentId = data.id;
            document.getElementById('incidente_id').value = incidentId;
            const form = document.getElementById('form-incidente');
            form.action = "/incidentes/" + incidentId; 
            
            // Inyectar método PUT
            document.getElementById('method-field-container').innerHTML = '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('btn-submit-final').innerText = "Actualizar Informe";
            alert("🚀 ¡Unidad despachada del " + hospital + "!");

        } else {
            throw new Error(data.message || 'Error en servidor');
        }

    } catch (error) {
        console.error(error);
        alert("❌ Error: " + error.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
});
</script>
@endsection