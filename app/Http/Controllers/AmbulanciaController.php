<?php

namespace App\Http\Controllers;

use App\Models\Ambulancia;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;

class AmbulanciaController extends Controller
{
    public function index()
    {
        $ambulancias = Ambulancia::with('hospital')->orderBy('id', 'DESC')->paginate(10);
        return view('ambulancias.index', compact('ambulancias'));
    }

    public function create()
    {
        $hospitales = Hospital::all();
        return view('ambulancias.create', compact('hospitales'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'nombre' => 'required|string|max:255',
            'placas' => 'nullable|string|max:50',
            'estado' => 'required|in:disponible,ocupada,en_ruta,fuera_servicio',
        ]);

        Ambulancia::create($data);

        return redirect()->route('ambulancias.index')
                         ->with('success', 'Ambulancia registrada correctamente.');
    }

    public function show($id)
    {
        $ambulancia = Ambulancia::with(['hospital', 'user'])->findOrFail($id);
        return view('ambulancias.show', compact('ambulancia'));
    }

    public function edit($id)
    {
        $ambulancia = Ambulancia::findOrFail($id);
        $hospitales = Hospital::all();
        return view('ambulancias.edit', compact('ambulancia', 'hospitales'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'nombre' => 'required|string|max:255',
            'placas' => 'nullable|string|max:50',
            'estado' => 'required|in:disponible,ocupada,en_ruta,fuera_servicio',
        ]);

        $ambulancia = Ambulancia::findOrFail($id);
        $ambulancia->update($data);

        return redirect()->route('ambulancias.index')
                         ->with('success', 'Ambulancia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $ambulancia = Ambulancia::findOrFail($id);
        $ambulancia->delete();

        return redirect()->route('ambulancias.index')
                         ->with('success', 'Ambulancia eliminada.');
    }
}
