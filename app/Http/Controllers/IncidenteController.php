<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\Hospital;
use App\Models\Ambulancia;
use App\Models\IncidenteAmbulancia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Importante para ver errores

class IncidenteController extends Controller
{
public function create(Request $request)
{
    $lat = $request->query('lat', 18.5090); 
    
    $lng = $request->query('lng', -88.3020);

    // Enviamos estas variables a la vista
    return view("incidentes.create", compact('lat', 'lng'));
}

public function store(Request $request)
    {
        // 1. Log inicial para depurar
        Log::info("--- INICIANDO DESPACHO ---");
        Log::info("Datos recibidos:", $request->all());

        // Validación
        $data = $request->validate([
            "tipo" => "required|string",
            "lat" => "required|numeric",
            "lng" => "required|numeric",
            "ubicacion" => "required|string",
            "hora" => "required|date",
            "prioridad" => "nullable|string",
            "hospital_asignado" => "nullable|string", 
            "descripcion" => "nullable|string",
            "numero_victimas" => "nullable|integer",
            "gravedad_heridos" => "nullable|string",
            "observaciones" => "nullable|string",
        ]);

        // 2. Crear Incidente
        $incidente = Incidente::create($data);
        Log::info("Incidente creado ID: " . $incidente->id);

        // 3. Lógica de Búsqueda de Hospital (Flexible con LIKE)
        $hospitalNombre = $request->hospital_asignado;
        $hospital = null;

        if ($hospitalNombre) {
            // Buscamos coincidencias parciales (Ej: "Chetumal" encuentra "Hospital General de Chetumal")
            $hospital = Hospital::where('nombre', 'LIKE', "%{$hospitalNombre}%")->first();
        }

        // Fallback: Si no se encuentra o viene nulo, usar el primero disponible
        if (!$hospital) {
            Log::warning("No se encontró hospital exacto para: '$hospitalNombre'. Usando el primero disponible.");
            $hospital = Hospital::first(); 
        }

        // 4. Lógica de Búsqueda de Ambulancia (En Cascada)
        $ambulancia = null;

        // Intento A: Buscar en el hospital detectado
        if ($hospital) {
            Log::info("Buscando ambulancia en hospital: " . $hospital->nombre);
            $ambulancia = Ambulancia::where('hospital_id', $hospital->id)
                ->where('estado', 'disponible') 
                ->first();
        }

        // Intento B: Si no hay en ese hospital, buscar CUALQUIER ambulancia disponible (Auxilio Global)
        if (!$ambulancia) {
            Log::warning("No hay ambulancias en el hospital local. Buscando globalmente...");
            $ambulancia = Ambulancia::where('estado', 'disponible')->first();
        }

        // 5. Asignación y Actualización de BD
        $asignado = false;
        
        if ($ambulancia && $hospital) {
            // Crear relación
            IncidenteAmbulancia::create([
                'incidente_id' => $incidente->id,
                'ambulancia_id' => $ambulancia->id,
                'hospital_id' => $hospital->id, // Usar ID del hospital asignado
                'estado' => 'asignado',
            ]);

            // Actualizar estados
            $ambulancia->update(['estado' => 'en_ruta']);
            
            // Actualizar el incidente con el nombre real del hospital de la BD
            $incidente->update(['hospital_asignado' => $hospital->nombre]);
            
            $asignado = true;
            Log::info("ASIGNACIÓN ÉXITOSA: Ambulancia ID " . $ambulancia->id);
        } else {
            Log::error("FALLO DE ASIGNACIÓN: No hay ambulancias disponibles en todo el sistema.");
        }

        // 6. WebSocket (Envío síncrono con Timeout)
        try {
            $payload = [
                "event" => $asignado ? "ambulancia.asignada" : "incidente.pendiente",
                "data" => [
                    "incidente" => $incidente,
                    "ambulancia" => $ambulancia, // Será null si no se asignó
                    "mensaje" => $asignado ? "URGENTE: Salida Inmediata" : "ALERTA: Incidente registrado SIN unidad disponible"
                ]
            ];

            // Usamos timeout de 2 segundos para no colgar PHP si Node no responde
            $response = Http::timeout(2)->post("http://localhost:3000/broadcast/asignacion-ambulancia", $payload);
            
            Log::info("Respuesta WS Node: " . $response->status());

        } catch (\Exception $e) {
            // Capturamos error de conexión pero NO detenemos el flujo
            Log::error("ERROR WEBSOCKET: No se pudo conectar con Node.js. " . $e->getMessage());
        }

        // 7. Respuesta al Frontend
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $asignado ? 'Ambulancia asignada correctamente.' : 'Incidente registrado. NO SE ENCONTRARON AMBULANCIAS.',
                'id' => $incidente->id
            ]);
        }

        // Redirección estándar
        return redirect("/incidentes/reportes");
    }

// Método para actualizar los detalles (Fase 2)
public function update(Request $request, $id)
    {
        // 1. Buscar
        $incidente = Incidente::findOrFail($id);

        // 2. Validar
        $data = $request->validate([
            'descripcion' => 'nullable|string',
            'numero_victimas' => 'nullable|integer',
            'gravedad_heridos' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'prioridad' => 'nullable|string',
        ]);

        // 3. Actualizar en BD
        $incidente->update($data);

        // 4. IMPORTANTE: Refrescar el modelo para asegurar que tenemos todos los datos actualizados
        $incidente->refresh(); 

        // 5. ENVIAR TODO EL OBJETO AL WEBSOCKET
        try {
             // Aquí enviamos $incidente->toArray(), que contiene ID, Lat, Lng, Descripción nueva, Víctimas, etc.
             Http::timeout(1)->post("http://localhost:3000/broadcast/incidente-actualizado", $incidente->toArray());
             
             \Log::info("Update enviado al WS. Datos completos del incidente ID: " . $id);

        } catch (\Exception $e) {
             \Log::error("Error enviando actualización WS: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Informe actualizado y enviado a la unidad.');
    }
    public function show($id)
    {
        $incidente = Incidente::findOrFail($id);
        return view("incidentes.show", compact("incidente")); // Asegúrate que la vista exista
    }
}