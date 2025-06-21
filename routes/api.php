<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EmpleadoController;
use App\Http\Controllers\API\ProvinciaController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('empleados', EmpleadoController::class);
Route::get('empleados/reporte/general', [EmpleadoController::class, 'reporte']);
Route::apiResource('provincias', ProvinciaController::class)->only(['index']);
Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy']);
Route::put('/empleados/{id}', [EmpleadoController::class, 'update']);
Route::get('/empleados/reporte/pdf', [EmpleadoController::class, 'generarReportePdf']);


