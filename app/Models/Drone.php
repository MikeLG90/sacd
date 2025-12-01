<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drone extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'modelo',
        'serial',
        'lat',
        'lng',
        'estatus',
        'video_stream'
    ];

    // Relación con incidentes (un dron puede atender muchos incidentes)
    public function incidentes()
    {
        return $this->hasMany(Incidente::class);
    }
}