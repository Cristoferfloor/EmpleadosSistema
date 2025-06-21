<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

      protected $fillable = [
        'codigo_empleado',
        'nombres',
        'apellidos',
        'cedula',
        'fecha_nacimiento',
        'email',
        'observaciones_personales',
        'fotografia',
        'estado'
    ];

    
    public function datosLaborales()
    {
        return $this->hasOne(DatosLaborales::class);
    }
}
