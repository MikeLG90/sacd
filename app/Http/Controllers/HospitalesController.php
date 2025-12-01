<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HospitalesController extends Controller
{
    public function index() {
        return view("hospitales.index");
    }
}
