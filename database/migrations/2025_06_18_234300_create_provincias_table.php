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
        Schema::create('provincias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_provincia');
            $table->string('capital_provincia');
            $table->text('descripcion_provincia')->nullable();
            $table->string('poblacion_provincia')->nullable();
            $table->string('superficie_provincia')->nullable();
            $table->string('latitud_provincia')->nullable();
            $table->string('longitud_provincia')->nullable();
            $table->integer('id_region')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provincias');
    }
};
