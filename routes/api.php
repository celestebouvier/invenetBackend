<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\OrdenReparacionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {


    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('dispositivos', DispositivoController::class);
    Route::apiResource('reportes', ReporteController::class);
    Route::apiResource('ordenes', OrdenReparacionController::class);
    Route::get('ordenes/{id}/pdf', [OrdenReparacionController::class, 'generarPDF']);
    Route::get('/ordenes/resumen', [OrdenReparacionController::class, 'resumen']);

Route::middleware('auth:sanctum')->put('ordenes/{id}/completar', [OrdenReparacionController::class, 'completarOrden']);

});
