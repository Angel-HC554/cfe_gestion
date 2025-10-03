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
        Schema::create('historial_ordenes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('orden_vehiculo_id');
            $table->foreign('orden_vehiculo_id')->references('id')->on('orden_vehiculos')->onDelete('cascade');
            $table->string('tipo_evento');
            $table->text('detalles');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            //user_id->foreign key to users table en caso de necesitarse
            //una orden puede tener muchos historial_ordenes
            //un historial_ordenes pertenece a una orden
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_ordenes');
    }
};
