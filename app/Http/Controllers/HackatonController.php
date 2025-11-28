<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class HackatonController extends Controller
{
    public function obtenerToken() {
    $response = Http::asForm()->post('https://comedatos.qroo.gob.mx/oauth/token', [
        'grant_type' => 'password',
        'client_id' => '4',
        'client_secret' => 'VJi8wbu3t5tiXP7A7e81G8kXq6jK5VxlcLWVIucR',
        'username' => '8122110003@utchetumal.edu.mx',
        'password' => 'T3mp0r4l.'
    ]);

    return $response->json();
}

    public function obtenerDatos() {
        $tokenResponse = $this->obtenerToken();
        $token = $tokenResponse['access_token'];

        $response = Http::withToken($token)->post('https://comedatos.qroo.gob.mx/api/NucleoDigital', [
            'email' => '8122110003@utchetumal.edu.mx',
            'password' => 'T3mp0r4l.'
        ]);

        return $response->json();
    }

}
