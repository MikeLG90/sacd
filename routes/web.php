<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\IncidenteController;
use App\Http\Controllers\DroneController;
use App\Http\Controllers\HospitalesController;
use App\Http\Controllers\AmbulanciaController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('ambulancias', AmbulanciaController::class);


// rutas para hospitales
Route::get('/hospitales/index', [HospitalesController::class, 'index']);


Route::get('/drones/index', [DroneController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/incidentes/nuevo', [IncidenteController::class, 'create'])->name('incidentes.create');
    Route::put('/incidentes/{id}', [IncidenteController::class, 'update'])->name('incidentes.update');
    Route::post('/incidentes', [IncidenteController::class, 'store'])->name('incidentes.store');
    Route::get('/incidentes-ver/{id}', [IncidenteController::class, 'show'])->name('incidentes.show');
});

Route::get('/reportes/incidentes', [ReporteController::class, 'index'])->name('reportes.incidentes');
Route::get('/reportes/incidentes/pdf', [ReporteController::class, 'generarPDF'])->name('reportes.incidentes.pdf');
Route::get('/reportes/incidentes/{id}', [ReporteController::class, 'generarPDFIndividual'])->name('pdf.individual');


require __DIR__ . '/auth.php';

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('/home', fn()=>view('index'))->name('home');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});

