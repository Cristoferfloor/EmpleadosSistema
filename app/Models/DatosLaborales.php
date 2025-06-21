<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosLaborales extends Model
{
    use HasFactory;
    protected $fillable = [
        'empleado_id',
        'fecha_ingreso',
        'cargo',
        'departamento',
        'provincia_id',
        'sueldo',
        'jornada_parcial',
        'observaciones_laborales'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
}
