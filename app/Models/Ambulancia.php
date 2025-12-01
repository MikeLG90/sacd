<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ambulancia extends Model
{
    use HasFactory;

    protected $table = 'ambulancias';

    protected $fillable = [
        'hospital_id',
        'user_id',
        'nombre',
        'placas',
        'estado'
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(AmbulanciaIncidente::class);
    }
}
