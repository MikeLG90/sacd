@extends('layouts.vertical', ['title' => 'Centro de Comando C5'])

@section('content')
<style>
    /* --- Estilos Tácticos "C5 Professional" --- */
    body { background-color: #0f172a; }
    
    .map-wrapper {
        position: relative; height: 85vh; overflow: hidden; 
        border-radius: 12px; border: 2px solid #334155;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
    }

    /* Overlay sutil para dar textura */
    .map-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(ellipse at center, transparent 40%, rgba(15, 23, 42, 0.3) 100%);
        pointer-events: none; z-index: 500;
    }

    /* Panel Flotante */
    .c5-panel {
        position: absolute; top: 20px; left: 20px; z-index: 1000;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.98) 0%, rgba(30, 41, 59, 0.98) 100%);
        border: 2px solid #3b82f6; border-left: 5px solid #3b82f6;
        color: #e2e8f0; padding: 24px; border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6); width: 420px; 
        font-family: 'Courier New', monospace; backdrop-filter: blur(10px);
    }

    /* Inputs y Botones */
    .c5-input {
        background: rgba(0, 0, 0, 0.5); border: 2px solid #475569;
        color: #fff; width: 100%; padding: 12px; margin-bottom: 15px;
        border-radius: 6px; font-size: 15px; transition: all 0.3s;
    }
    .c5-input:focus { outline: none; border-color: #3b82f6; background: rgba(0, 0, 0, 0.7); }

    .btn-search {
        background: #3b82f6; color: white; font-weight: 800; border: none;
        width: 100%; padding: 12px; text-transform: uppercase; letter-spacing: 1px;
        border-radius: 6px; transition: all 0.2s; margin-bottom: 10px;
    }
    .btn-search:hover { background: #2563eb; transform: translateY(-1px); }

    /* Botón de Despliegue (Inicialmente oculto o deshabilitado) */
    .btn-deploy {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white; font-weight: 800; border: none;
        width: 100%; padding: 14px; text-transform: uppercase; letter-spacing: 1.5px;
        border-radius: 6px; box-shadow: 0 0 15px rgba(220, 38, 38, 0.5);
        display: none; /* Se muestra solo al confirmar ubicación */
        animation: pulse-btn 2s infinite;
    }
    @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); } 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); } }

    /* Log */
    .status-log {
        margin-top: 15px; padding: 10px; background: rgba(0,0,0,0.4);
        border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 4px;
        font-size: 0.8rem; text-align: center; font-weight: bold; color: #4ade80;
    }

    /* Overlay Roja */
    .alert-overlay {
        display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(185, 28, 28, 0.98) 0%, rgba(153, 27, 27, 0.98) 100%);
        z-index: 9999; color: white; flex-direction: column; 
        align-items: center; justify-content: center; text-align: center;
    }
</style>

<div class="map-wrapper">
    <div id="mapa-global" style="height: 100%; width: 100%;"></div>
    <div class="map-overlay"></div>

    <div class="c5-panel">
        <div style="border-bottom: 1px solid rgba(59,130,246,0.3); padding-bottom: 10px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin:0; color:#60a5fa; font-weight:800;">CANAL 911 - ACTIVO</h5>
            <span style="background:#10b981; color:white; padding:2px 8px; border-radius:10px; font-size:0.7rem;">EN VIVO</span>
        </div>

        <label style="font-size: 0.75rem; color: #93c5fd; font-weight: bold; display:block; margin-bottom:5px;">
            1. BÚSQUEDA DE UBICACIÓN (VOZ/TEXTO)
        </label>
        <input type="text" id="direccion-input" class="c5-input" 
               placeholder="Ej: Mercado Viejo, Chetumal" 
               value="Museo de la Cultura Maya, Chetumal">
        
        <button id="btn-buscar" onclick="buscarDireccion()" class="btn-search">
             LOCALIZAR OBJETIVO
        </button>

        <button id="btn-desplegar" onclick="confirmarDespliegue()" class="btn-deploy">
             CONFIRMAR Y DESPLEGAR DRON
        </button>
        
        <div id="status-log" class="status-log">SISTEMA EN ESPERA...</div>
    </div>
</div>

<div id="alerta-roja" class="alert-overlay">
    <h1 style="font-size: 5rem; font-weight: 900; letter-spacing: 5px;"> ALERTA C5 </h1>
    <h2 class="mt-4">COORDENADAS CONFIRMADAS</h2>
    <div style="margin-top: 20px;">
        <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <h4 class="mt-4">INICIANDO VUELO DE DRON...</h4>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // 1. Mapa Inicial
    const map = L.map('mapa-global', { zoomControl: false }).setView([18.5090, -88.3020], 14);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap & CARTO', maxZoom: 20
    }).addTo(map);

    // Variables Globales para el incidente
    let targetMarker = null;
    let finalLat = null;
    let finalLng = null;

    // Icono de "Objetivo" (Rojo)
    const targetIcon = L.divIcon({
        className: 'custom-target',
        html: "<div style='background-color: #ef4444; width: 20px; height: 20px; border: 3px solid white; border-radius: 50%; box-shadow: 0 0 15px #ef4444; animation: pulse 1s infinite;'></div>",
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });

    // --- FUNCIÓN 1: BUSCAR (GEOCODING) ---
    async function buscarDireccion() {
        let direccion = document.getElementById('direccion-input').value;
        const statusLog = document.getElementById('status-log');
        
        if(!direccion) return alert("Ingresa dirección");

        statusLog.innerText = "Calculando posición...";
        statusLog.style.color = "#facc15"; // Amarillo

        // Auto-contexto
        if (!direccion.toLowerCase().includes('chetumal')) direccion += ", Chetumal, Quintana Roo, Mexico";

        try {
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(direccion)}&limit=1`;
            const response = await axios.get(url);

            if (response.data && response.data.length > 0) {
                const lugar = response.data[0];
                finalLat = lugar.lat;
                finalLng = lugar.lon;
                
                // --- AQUÍ ESTÁ EL CAMBIO ---
                // No desplegamos, solo mostramos el marcador para que el operador ajuste
                mostrarMarcadorAjustable(finalLat, finalLng);
                
                statusLog.innerText = "VERIFICA PUNTO EN EL MAPA";
                statusLog.style.color = "#fb923c"; // Naranja
                
                // Cambiar botones
                document.getElementById('btn-buscar').style.display = 'none';
                document.getElementById('btn-desplegar').style.display = 'block'; // Mostrar botón rojo

            } else {
                // Fallback al centro
                finalLat = "18.5090"; 
                finalLng = "-88.3020";
                mostrarMarcadorAjustable(finalLat, finalLng);
                statusLog.innerText = "📍 APROXIMACIÓN (AJUSTA EL PUNTO)";
                document.getElementById('btn-buscar').style.display = 'none';
                document.getElementById('btn-desplegar').style.display = 'block';
            }
        } catch (error) {
            console.error(error);
            statusLog.innerText = "Error Red";
        }
    }

    // --- FUNCIÓN INTERMEDIA: MARCADOR ARRASTRABLE ---
    function mostrarMarcadorAjustable(lat, lng) {
        // Zoom al lugar
        map.flyTo([lat, lng], 18, { duration: 1.5 });

        // Si ya había marcador, lo quitamos
        if (targetMarker) map.removeLayer(targetMarker);

        // Crear marcador arrastrable
        targetMarker = L.marker([lat, lng], {
            icon: targetIcon,
            draggable: true // ¡Esto permite al operador corregir!
        }).addTo(map);

        // Popup instructivo
        targetMarker.bindPopup("<b>OBJETIVO DETECTADO</b><br>Arrastra para precisar ubicación.").openPopup();

        // Escuchar si lo mueve para actualizar las coordenadas finales
        targetMarker.on('dragend', function(event) {
            const position = event.target.getLatLng();
            finalLat = position.lat;
            finalLng = position.lng;
            document.getElementById('status-log').innerText = " COORDENADAS ACTUALIZADAS";
        });
    }

    // --- FUNCIÓN 2: EJECUTAR (IR A LA APP) ---
    function confirmarDespliegue() {
        if(!finalLat || !finalLng) return;

        // Pantalla Roja
        document.getElementById('alerta-roja').style.display = 'flex';
        
        // Redirigir después de 3s con las coordenadas EXACTAS (ajustadas o no)
        setTimeout(() => {
            window.location.href = `{{ route('incidentes.create') }}?lat=${finalLat}&lng=${finalLng}&auto_start=true`;
        }, 3000);
    }
</script>
<style>
@keyframes pulse { 0% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.7; } 100% { transform: scale(1); opacity: 1; } }
</style>
@endsection