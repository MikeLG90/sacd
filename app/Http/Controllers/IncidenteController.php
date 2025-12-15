<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\Hospital;
use App\Models\Ambulancia;
use App\Models\IncidenteAmbulancia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IncidenteController extends Controller
{
    public function create(Request $request)
    {
        $lat = $request->query('lat', 18.5090);
        $lng = $request->query('lng', -88.3020);

        return view("incidentes.create", compact('lat', 'lng'));
    }

    public function store(Request $request)
    {
        Log::info("INCIDENTE STORE", $request->all());

        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            $incidente = Incidente::create($data);

            $hospital = null;
            if ($request->hospital_asignado) {
                $hospital = Hospital::where('nombre', 'LIKE', "%{$request->hospital_asignado}%")->first();
            }

            if (!$hospital) {
                $hospital = Hospital::first();
            }

            $ambulancia = null;
            if ($hospital) {
                $ambulancia = Ambulancia::where('hospital_id', $hospital->id)
                    ->where('estado', 'disponible')
                    ->first();
            }

            if (!$ambulancia) {
                $ambulancia = Ambulancia::where('estado', 'disponible')->first();
            }

            $asignado = false;

            if ($ambulancia && $hospital) {
                IncidenteAmbulancia::create([
                    'incidente_id' => $incidente->id,
                    'ambulancia_id' => $ambulancia->id,
                    'hospital_id' => $hospital->id,
                    'estado' => 'asignado',
                ]);

                $ambulancia->update(['estado' => 'en_ruta']);
                $incidente->update(['hospital_asignado' => $hospital->nombre]);
                $asignado = true;
            }

            try {
                $payload = [
                    "event" => $asignado ? "ambulancia.asignada" : "incidente.pendiente",
                    "data" => [
                        "incidente" => $incidente,
                        "ambulancia" => $ambulancia,
                        "mensaje" => $asignado
                            ? "URGENTE: Salida Inmediata"
                            : "ALERTA: Incidente registrado SIN unidad disponible"
                    ]
                ];

                Http::timeout(2)->post(
                    "https://rutasws-f6hhc6bmekbbekfe.mexicocentral-01.azurewebsites.net/broadcast/asignacion-ambulancia",
                    $payload
                );
            } catch (\Throwable $e) {
                Log::error("WS ERROR", ['error' => $e->getMessage()]);
            }

            return response()->json([
                'success' => true,
                'message' => $asignado
                    ? 'Ambulancia asignada correctamente.'
                    : 'Incidente registrado, sin ambulancias disponibles.',
                'id' => $incidente->id
            ]);

        } catch (\Throwable $e) {
            Log::error("STORE ERROR", ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $incidente = Incidente::findOrFail($id);

            $data = $request->validate([
                'descripcion' => 'nullable|string',
                'numero_victimas' => 'nullable|integer',
                'gravedad_heridos' => 'nullable|string',
                'observaciones' => 'nullable|string',
                'prioridad' => 'nullable|string',
            ]);

            $incidente->update($data);
            $incidente->refresh();

            try {
                Http::timeout(1)->post(
                    "https://rutasws-f6hhc6bmekbbekfe.mexicocentral-01.azurewebsites.net/broadcast/incidente-actualizado",
                    $incidente->toArray()
                );
            } catch (\Throwable $e) {
                Log::error("WS UPDATE ERROR", ['error' => $e->getMessage()]);
            }

            return response()->json([
                'success' => true,
                'id' => $incidente->id
            ]);

        } catch (\Throwable $e) {
            Log::error("UPDATE ERROR", ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar incidente'
            ], 500);
        }
    }

    public function show($id)
    {
        $incidente = Incidente::findOrFail($id);
        return view("incidentes.show", compact("incidente"));
    }
}
