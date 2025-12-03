<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Incidente;
use App\Models\Hospital;
use App\Models\Ambulancia;
use App\Models\IncidenteAmbulancia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsignarAmbulanciaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $incidente;

    public function __construct(Incidente $incidente)
    {
        $this->incidente = $incidente;
    }

    public function handle()
    {
        Log::info("Iniciando asignación para Incidente ID: " . $this->incidente->id);

        // 1. Lógica de Geolocalización (Simplificada para el ejemplo)
        // Aquí podrías usar una query geoespacial real.
        // Por ahora, buscaremos el hospital más cercano basándonos en tu lógica previa,
        // pero idealmente esto se hace con SQL (ST_Distance).
        
        // Supongamos que recibimos el hospital como string o lo calculamos aquí.
        // Para optimizar, voy a buscar la ambulancia disponible más cercana GLOBALMENTE 
        // o en el hospital que ya traías pre-calculado si lo envías.
        
        $hospital = Hospital::where('nombre', $this->incidente->hospital_asignado)->first();
        
        if (!$hospital) {
             // Fallback: Buscar cualquier hospital
             $hospital = Hospital::first(); 
        }

        // 2. Buscar Ambulancia
        $ambulancia = Ambulancia::where('hospital_id', $hospital->id)
            ->where('estado', 'disponible')
            ->first();

        if ($ambulancia) {
            // 3. Crear Asignación
            IncidenteAmbulancia::create([
                'incidente_id' => $this->incidente->id,
                'ambulancia_id' => $ambulancia->id,
                'hospital_id' => $hospital->id,
                'estado' => 'asignado',
            ]);

            // 4. Actualizar estado ambulancia
            $ambulancia->update(['estado' => 'en_ruta']);
            
            // Actualizar incidente con el hospital oficial
            $this->incidente->update(['hospital_asignado' => $hospital->nombre]);

            Log::info("Ambulancia {$ambulancia->id} asignada.");

            // 5. Enviar al WebSocket (Node.js)
            try {
                Http::timeout(2)->post("http://localhost:3000/broadcast/asignacion-ambulancia", [
                    "event" => "ambulancia.asignada",
                    "data" => [
                        "incidente" => $this->incidente,
                        "ambulancia" => $ambulancia,
                        "mensaje" => "NUEVA EMERGENCIA: Despacho Inmediato"
                    ],
                ]);
            } catch (\Exception $e) {
                Log::error("Error conectando a WS: " . $e->getMessage());
            }
        } else {
            Log::warning("No hay ambulancias disponibles para el incidente " . $this->incidente->id);
            // Opcional: Enviar alerta a supervisores vía WS
        }
    }
}