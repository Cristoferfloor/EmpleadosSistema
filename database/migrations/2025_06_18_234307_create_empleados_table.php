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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_empleado')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('cedula')->unique();
            $table->date('fecha_nacimiento');
            $table->string('email')->unique();
            $table->text('observaciones_personales')->nullable();
            $table->string('fotografia')->nullable();
            $table->enum('estado', ['VIGENTE', 'RETIRADO'])->default('VIGENTE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
