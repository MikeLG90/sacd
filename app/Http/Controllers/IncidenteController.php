<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;

class IncidenteController extends Controller
{
    // Mostrar formulario de nuevo incidente
    public function create()
    {
        return view('incidentes.create');
    }

    // Guardar incidente en BD
public function store(Request $request)
{
    // Validar todos los campos del formulario
    $data = $request->validate([
        'tipo' => 'required|string|max:100',
        'descripcion' => 'nullable|string',
        'ubicacion' => 'required|string|max:255',
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
        'hospital_asignado' => 'required|string|max:255',
        'hora' => 'required|date',
        'prioridad' => 'required|string|max:50',
        'numero_victimas' => 'nullable|integer',
        'gravedad_heridos' => 'nullable|string|max:255',
        'observaciones' => 'nullable|string',
    ]);

    // Guardar en la base de datos
    $incidente = Incidente::create($data);

    return redirect()->route('incidentes.show', $incidente->id)
                     ->with('success', 'Incidente registrado correctamente con hospital asignado.');
}

    public function show($id)
    {
        $incidente = Incidente::findOrFail($id);
        return view('incidentes.show', compact('incidente'));
    }
}
