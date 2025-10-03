<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('agencia');
            $table->string('no_economico');
            $table->string('placas');
            $table->string('tipo_vehiculo');
            $table->string('marca');
            $table->string('modelo');
            $table->year('año');
            $table->string('estado');//,['En circulacion', 'En mantenimiento', 'Fuera de circulacion por falla pendiente', 'Fuera de circulacion']);
            $table->string('propiedad');//,['Propio (CFE)', 'Arrendado']);
            $table->string('proceso');
            $table->string('alias')->nullable();
            $table->string('rpe_creamod');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
