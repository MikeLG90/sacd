<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidenteAmbulancia extends Model
{
    protected $table = 'incidente_ambulancia';

    protected $fillable = [
        'incidente_id',
        'ambulancia_id',
        'hospital_id',
        'estado',
    ];

    public function incidente()
    {
        return $this->belongsTo(Incidente::class);
    }

    public function ambulancia()
    {
        return $this->belongsTo(Ambulancia::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
