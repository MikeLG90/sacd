<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeiminiController extends Controller
{
public function optimizarTexto(Request $request)
{
    $request->validate([
        'texto' => 'required|string|min:3'
    ]);

    $descripcion = $request->input('texto');
    $victimas = $request->input('victimas', 0);
    $apiKey = env('OPENAI_API_KEY');

    if (empty($apiKey)) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró OPENAI_API_KEY en el .env'
        ]);
    }

    // Prompt que exige JSON estricto
$prompt = "
Eres un despachador profesional del servicio de emergencias 911, altamente capacitado en evaluación rápida de incidentes, priorización de recursos y comunicación médica operativa.

Analiza la siguiente descripción del incidente: \"{$descripcion}\".
Número de posibles víctimas: {$victimas}.

Tu tarea es:
1. Evaluar la gravedad y urgencia del incidente.
2. Determinar la prioridad recomendada para el despacho (alta, media o baja).
3. Elaborar un informe médico-operativo detallado de entre 40 y 60 palabras, describiendo:
   - condición observable de las víctimas,
   - riesgos inmediatos o potenciales,
   - síntomas críticos,
   - y cualquier elemento relevante para el equipo de ambulancias.

Responde únicamente en el siguiente formato JSON, sin agregar texto adicional antes o después:

{
  \"recommended_priority\": \"alta | media | baja\",
  \"brief_for_ambulance\": \"Informe médico-operativo detallado (40-60 palabras).\"
}
";


    try {
        $response = Http::withHeaders([
            "Authorization" => "Bearer {$apiKey}",
            "Content-Type" => "application/json"
        ])->post("https://api.openai.com/v1/chat/completions", [
            "model" => "gpt-4o-mini",   // o "gpt-4o"
            "messages" => [
                ["role" => "user", "content" => $prompt]
            ],
            "temperature" => 0.2,
            "response_format" => ["type" => "json_object"]
        ]);

        $json = $response->json();

        if (!isset($json["choices"][0]["message"]["content"])) {
            return response()->json([
                "success" => false,
                "message" => "OpenAI devolvió vacío o sin mensaje."
            ]);
        }

        // El JSON ya viene limpio gracias a response_format
        $data = json_decode($json["choices"][0]["message"]["content"], true);

        return response()->json([
            "success" => true,
            "prioridad_sugerida" => $data["recommended_priority"] ?? "alta",
            "optimizado" => $data["brief_for_ambulance"] ?? "",
            "modelo_usado" => "gpt-4o-mini"
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => "Error OpenAI: " . $e->getMessage()
        ]);
    }
}
}