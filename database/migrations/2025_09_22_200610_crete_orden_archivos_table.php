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
        Schema::create('orden_archivos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('orden_vehiculo_id');
            $table->foreign('orden_vehiculo_id')->references('id')->on('orden_vehiculos')->onDelete('cascade');
            $table->string('ruta_archivo');
            $table->enum('tipo_archivo', ['entrada','salida'])->default('entrada');
            $table->string('comentarios')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_archivos');
    }
};
