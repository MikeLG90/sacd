<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_create_incidentes_table.php
public function up()
{
    Schema::create('incidentes', function (Blueprint $table) {
        $table->id();
        $table->string('tipo'); // Ej: "Accidente vehicular"
        $table->string('ubicacion');
        $table->decimal('lat', 10, 7);
        $table->decimal('lng', 10, 7);
        $table->string('hospital_asignado')->nullable(); // Se calcula en el Job
        $table->dateTime('hora');
        $table->string('prioridad')->default('media'); // Valor por defecto
        
        // Estos ahora deben aceptar NULL
        $table->integer('numero_victimas')->nullable();
        $table->string('gravedad_heridos')->nullable();
        $table->text('observaciones')->nullable();
        $table->text('descripcion')->nullable();
        
        $table->timestamps();
    });
}
};
