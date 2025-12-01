<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'especialidades',          // text
        'capacidad_respuesta',     // text
        'zona_cobertura',          // text
        'tipo_ambulancia',         // varchar
        'total_unidades',          // varchar (según tu esquema es string)
        'disponibilidad_unidades', // varchar
        'telefono_contacto',
        'correo',
        'lat',                     // decimal
        'lng',                     // decimal
        'nivel_respuesta',         // varchar
        'camas_disponibles',       // int
        'capacidad_total',         // int
        'synced_at',               // timestamp personalizado
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'lat' => 'float',               // Convierte decimal a float de PHP
        'lng' => 'float',               // Convierte decimal a float de PHP
        'camas_disponibles' => 'integer',
        'capacidad_total' => 'integer',
        'synced_at' => 'datetime',    
    ];


    public function ambulancias()
    {
        return $this->hasMany(Ambulancia::class, 'hospital_id');
    }


    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('nombre', 'LIKE', "%{$termino}%");
        }
    }
}