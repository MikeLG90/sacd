<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\Hospital;
use App\Models\Ambulancia;
use App\Models\IncidenteAmbulancia;
use Illuminate\Support\Facades\Http;

class IncidenteController extends Controller
{
    // Mostrar formulario de nuevo incidente
    public function create()
    {
        return view("incidentes.create");
    }

    // Guardar incidente en BD
public function store(Request $request)
{
    $data = $request->validate([
        "tipo" => "required|string|max:100",
        "descripcion" => "nullable|string",
        "ubicacion" => "required|string|max:255",
        "lat" => "required|numeric",
        "lng" => "required|numeric",
        "hospital_asignado" => "required|string|max:255",
        "hora" => "required|date",
        "prioridad" => "required|string|max:50",
        "numero_victimas" => "nullable|integer",
        "gravedad_heridos" => "nullable|string|max:255",
        "observaciones" => "nullable|string",
    ]);

    // 1. Guardar incidente
    $incidente = Incidente::create($data);

    // 2. Buscar hospital
    $hospital = Hospital::where("nombre", $incidente->hospital_asignado)->firstOrFail();

    // 3. Buscar ambulancia disponible
    $ambulancia = Ambulancia::where("hospital_id", $hospital->id)
        ->where("estado", "disponible")
        ->first();

    if (!$ambulancia) {
        return back()->with("error", "No hay ambulancias disponibles en este hospital.");
    }

    // 4. Registrar asignación
    IncidenteAmbulancia::create([
        "incidente_id" => $incidente->id,
        "ambulancia_id" => $ambulancia->id,
        "hospital_id" => $ambulancia->hospital_id,
        "estado" => "asignado",
    ]);

    // 5. Cambiar estado de ambulancia
    $ambulancia->update(["estado" => "en_ruta"]);

    // 6. Enviar a WebSocket
    try {

    Http::post("http://localhost:3000/broadcast/incidente", [
    'event' => 'incidente.creado',
    'data' => $incidente
]);


        Http::post("http://localhost:3000/broadcast/asignacion-ambulancia", [
            "event" => "ambulancia.asignada",
            "data" => [
                "incidente" => $incidente,
                "ambulancia" => $ambulancia,
            ],
        ]);

    } catch (\Exception $e) {
        \Log::error("No se puede enviar al WebSocket: " . $e->getMessage());
    }

    return redirect("/reportes/incidentes")->with(
        "success",
        "Incidente registrado correctamente con hospital asignado."
    );
}


    public function show($id)
    {
        $incidente = Incidente::findOrFail($id);
        return view("reportes.incidentes", compact("incidente"));
    }
}
