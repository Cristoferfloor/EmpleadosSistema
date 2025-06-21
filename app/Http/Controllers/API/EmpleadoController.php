<?php

namespace App\Http\Controllers\API;

use PDF;
use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\DatosLaborales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
   public function index(Request $request)
{
    $query = Empleado::with('datosLaborales');

    if ($request->has('search') && $request->search !== '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nombres', 'like', "%$search%")
              ->orWhere('apellidos', 'like', "%$search%")
              ->orWhere('codigo_empleado', 'like', "%$search%");
        });
    }

    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    $empleados = $query->paginate(20);

    return response()->json($empleados);
}


   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'cedula' => 'required|string|max:20|unique:empleados',
        'fecha_nacimiento' => 'required|date',
        'email' => 'required|email|unique:empleados',
        'codigo_empleado' => 'required|string|unique:empleados',
        'estado' => 'required|in:VIGENTE,RETIRADO',
        'datos_laborales.fecha_ingreso' => 'required|date',
        'datos_laborales.cargo' => 'required|string|max:255',
        'datos_laborales.departamento' => 'required|string|max:255',
        'datos_laborales.provincia_id' => 'required|exists:provincias,id',
        'datos_laborales.sueldo' => 'required|numeric|min:0',
        'datos_laborales.jornada_parcial' => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $empleado = Empleado::create([
        'nombres' => $request->nombres,
        'apellidos' => $request->apellidos,
        'cedula' => $request->cedula,
        'fecha_nacimiento' => $request->fecha_nacimiento,
        'email' => $request->email,
        'codigo_empleado' => $request->codigo_empleado,
        'estado' => $request->estado,
        'observaciones_personales' => $request->observaciones_personales,
    ]);

    $datos = $request->input('datos_laborales');

    $datosLaborales = new DatosLaborales([
        'fecha_ingreso' => $datos['fecha_ingreso'],
        'cargo' => $datos['cargo'],
        'departamento' => $datos['departamento'],
        'provincia_id' => $datos['provincia_id'],
        'sueldo' => $datos['sueldo'],
        'jornada_parcial' => $datos['jornada_parcial'],
        'observaciones_laborales' => $datos['observaciones_laborales'] ?? null,
    ]);

    $empleado->datosLaborales()->save($datosLaborales);

    return response()->json($empleado->load('datosLaborales.provincia'), 201);
}

    public function show($id)
    {
        $empleado = Empleado::with('datosLaborales.provincia')->findOrFail($id);
        return response()->json($empleado);
    }

    public function update(Request $request, $id)
{
    $empleado = Empleado::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'cedula' => 'required|string|max:20|unique:empleados,cedula,' . $empleado->id,
        'fecha_nacimiento' => 'required|date',
        'email' => 'required|email|unique:empleados,email,' . $empleado->id,
        'codigo_empleado' => 'required|string|unique:empleados,codigo_empleado,' . $empleado->id,
        'estado' => 'required|in:VIGENTE,RETIRADO',
        'datos_laborales.fecha_ingreso' => 'required|date',
        'datos_laborales.cargo' => 'required|string|max:255',
        'datos_laborales.departamento' => 'required|string|max:255',
        'datos_laborales.provincia_id' => 'required|exists:provincias,id',
        'datos_laborales.sueldo' => 'required|numeric|min:0',
        'datos_laborales.jornada_parcial' => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $empleado->update([
        'nombres' => $request->nombres,
        'apellidos' => $request->apellidos,
        'cedula' => $request->cedula,
        'fecha_nacimiento' => $request->fecha_nacimiento,
        'email' => $request->email,
        'codigo_empleado' => $request->codigo_empleado,
        'estado' => $request->estado,
        'observaciones_personales' => $request->observaciones_personales,
    ]);

    $datos = $request->input('datos_laborales');

    $empleado->datosLaborales()->update([
        'fecha_ingreso' => $datos['fecha_ingreso'],
        'cargo' => $datos['cargo'],
        'departamento' => $datos['departamento'],
        'provincia_id' => $datos['provincia_id'],
        'sueldo' => $datos['sueldo'],
        'jornada_parcial' => $datos['jornada_parcial'],
        'observaciones_laborales' => $datos['observaciones_laborales'] ?? null,
    ]);

    return response()->json($empleado->load('datosLaborales.provincia'));
}

public function destroy($id)
{
    try {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Empleado eliminado correctamente'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar el empleado'
        ], 500);
    }
}

    public function vistaPreviaReporte()
{
    $empleados = Empleado::with('datosLaborales.provincia')->orderBy('nombres')->get();

    return view('reportes.empleados', compact('empleados'));
}
public function reporte()
    {
        $empleados = Empleado::with('datosLaborales.provincia')->get();
        return response()->json($empleados);
    }
   public function generarReportePdf(Request $request)
{
    try {
        $empleados = Empleado::with('datosLaborales')
            ->orderBy('nombres')
            ->get();

        $data = [
            'title' => 'Reporte de Empleados',
            'date' => date('d/m/Y'),
            'empleados' => $empleados
        ];

       $pdf = PDF::loadView('reportes.empleados', $data)->setPaper('a4', 'landscape');


        if ($request->has('preview')) {
            return $pdf->stream('reporte_empleados.pdf');
        }

        return $pdf->download('reporte_empleados.pdf');

    } catch (\Exception $e) {
        \Log::error("Error generando PDF: " . $e->getMessage());
        return response()->json([
            'error' => 'Error al generar el reporte PDF',
            'details' => $e->getMessage()
        ], 500);
    }
}

}