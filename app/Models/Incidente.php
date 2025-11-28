<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
    use HasFactory;

    protected $table = 'incidentes';

    protected $fillable = [
        'tipo',
        'descripcion',
        'ubicacion',
        'lat',
        'lng',
        'hora',
        'hospital_asignado',
        'estado',
        'prioridad',
        'numero_victimas',
        'gravedad_heridos',
        'observaciones'
    ];
}
