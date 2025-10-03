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
        Schema::table('orden_vehiculos', function (Blueprint $table) {
            $table->string('orden_500')->default('NO');
            $table->enum('status', ['PENDIENTE', 'ENTREGADO PV', 'VEHICULO TALLER', 'VEHICULO FUNCIONAMIENTO'])->default('PENDIENTE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_vehiculos', function (Blueprint $table) {
            //
        });
    }
};
