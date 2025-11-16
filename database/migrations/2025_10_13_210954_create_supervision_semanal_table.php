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
        Schema::create('supervision_semanal', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');//preguntar luego si si
            $table->unsignedBigInteger('vehiculo_id');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->string('no_eco');
            $table->string('foto_del');
            $table->string('foto_tra');
            $table->string('foto_lado_izq');
            $table->string('foto_lado_der');
            $table->string('foto_poliza')->nullable();
            $table->string('foto_tar_circ')->nullable();
            $table->string('foto_kit')->nullable();
            $table->string('foto_atent')->nullable();
            $table->text('resumen_est')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervision_semanal');
    }
};
