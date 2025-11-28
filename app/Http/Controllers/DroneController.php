<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drone;

class DroneController extends Controller
{
    public function index()
    {
        $drones = Drone::all();
        return view('drones.index', compact('drones'));
    }

    public function show(Drone $drone)
    {
        return view('drones.show', compact('drone'));
    }
}
