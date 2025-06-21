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
        Schema::create('datos_laborales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained()->onDelete('cascade');
            $table->date('fecha_ingreso');
            $table->string('cargo');
            $table->string('departamento');
            $table->foreignId('provincia_id')->constrained('provincias');
            $table->decimal('sueldo', 10, 2);
            $table->boolean('jornada_parcial')->default(false);
            $table->text('observaciones_laborales')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_laborales');
    }
};
