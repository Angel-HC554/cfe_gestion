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
        Schema::create('orden_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('area');
            $table->string('zona');
            $table->string('departamento');
            $table->string('noeconomico');
            $table->string('marca');
            $table->string('placas');
            $table->string('taller')->nullable();
            $table->integer('kilometraje')->nullable();
            $table->date('fecharecep')->nullable();
            //si y no, casillas
            $table->string('radiocom');
            $table->string('llantaref');
            $table->string('autoestereo');
            $table->string('gatoh');
            $table->string('llavecruz');
            $table->string('extintor');
            $table->string('botiquin');
            $table->string('escalera');
            $table->string('escalerad');
            //gasolina
            $table->string('gasolina');
            //opciones de checkbox
            $table->string('vehicle1');
            $table->string('vehicle2');
            $table->string('vehicle3');
            $table->string('vehicle4');
            $table->string('vehicle5');
            $table->string('vehicle6');
            $table->string('vehicle7');
            $table->string('vehicle8');
            $table->string('vehicle9');
            $table->string('vehicle10');
            $table->string('vehicle11');
            $table->string('vehicle12');
            $table->string('vehicle13');
            $table->string('vehicle14');
            $table->string('vehicle15');
            $table->string('vehicle16');
            $table->string('vehicle17');
            $table->string('vehicle18');
            $table->string('vehicle19');
            $table->string('vehicle20');
            //observaciones y fecha firma
            $table->text('observacion');
            $table->date('fechafirm');
            //firmas y rpe
            $table->string('areausuaria');
            $table->string('rpeusuaria');
            $table->string('autoriza');
            $table->string('rpejefedpt');
            $table->string('resppv');
            $table->string('rperesppv');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_vehiculos');
    }
};
