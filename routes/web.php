<?php

use Illuminate\Support\Facades\Route;
use App\Models\Empleado;

Route::get('/', function () {
    $empleados = Empleado::with('datosLaborales')->orderBy('created_at', 'desc')->get();
    return view('welcome', compact('empleados'));
});
Route::get('/empleados/nuevo', function () {
    return view('empleados.create'); 
});
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
