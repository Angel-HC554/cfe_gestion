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
        Schema::create('supervision_diaria', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('vehiculo_id');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->string('no_eco');
            $table->string('nombre_auxiliar');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('gasolina');
            $table->integer('kilometraje');
            $table->boolean('aceite');
            $table->boolean('liq_fren');
            $table->boolean('anti_con');
            $table->boolean('agua');
            $table->boolean('radiador');
            $table->boolean('llantas');
            $table->boolean('llanta_r');
            $table->boolean('tapon_gas');
            $table->boolean('limp_cab');
            $table->boolean('limp_ext');
            $table->boolean('cinturon');
            $table->boolean('limpia_par');
            $table->boolean('manijas_puer');
            $table->boolean('espejo_int');
            $table->boolean('espejo_lat_i');
            $table->boolean('espejo_lat_d');
            $table->boolean('gato');
            $table->boolean('llave_cruz');
            $table->boolean('extintor');
            $table->boolean('direccionales');
            $table->boolean('luces');
            $table->boolean('intermit');
            $table->boolean('golpes');
            $table->string('golpes_coment')->nullable();
            $table->string('escaneo_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervision_diaria');
    }
};
