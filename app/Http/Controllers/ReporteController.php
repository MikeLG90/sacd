<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Incidente; 

class ReporteController extends Controller
{
    // Mostrar listado de incidentes
    public function index()
    {
        // Obtener todos los incidentes de la base de datos
        $incidentes = Incidente::orderBy('hora', 'desc')->get();

        return view('reportes.incidentes', compact('incidentes'));
    }
public function generarPDF()
{
    // Obtener todos los incidentes de la base de datos
    $incidentes = Incidente::orderBy('hora', 'desc')->get()->toArray();

    // Generar el PDF con la vista
    $pdf = Pdf::loadView('reportes.pdf.incidentes', compact('incidentes'));

    // Descargar PDF
    return $pdf->download('reporte_incidentes.pdf');
}

        public function generarPDFIndividual($id)
    {
        $incidente = \App\Models\Incidente::findOrFail($id);
        $pdf = Pdf::loadView('reportes.pdf.incidente_individual', compact('incidente'));
        return $pdf->download("reporte_incidente_{$id}.pdf");
    }
}
