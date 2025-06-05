<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\OrdenReparacionController;
use App\Http\Controllers\ReporteController;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Autenticación con Sanctum
Route::middleware(['auth:sanctum'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Acceso general (ver dispositivos)
    Route::get('/dispositivos', [DispositivoController::class, 'index']);
    Route::get('/dispositivos/{id}', [DispositivoController::class, 'show']);

    // Crear un nuevo reporte (solo DOCENTE autenticado)
    Route::post('/reportes', [ReporteController::class, 'store']);

    // ORDENES DE REPARACIÓN (técnicos pueden marcar como completadas)
    Route::put('/ordenes/{id}/completar', [OrdenReparacionController::class, 'completarOrden']);

        // Acceso restringido a administradores
        Route::middleware(['admin'])->group(function () {
             // Usuarios (CRUD completo)
            Route::apiResource('usuarios', UserController::class);

            // Dispositivos (crear, actualizar, eliminar)
            Route::post('/dispositivos', [DispositivoController::class, 'store']);
            Route::put('/dispositivos/{id}', [DispositivoController::class, 'update']);
            Route::delete('/dispositivos/{id}', [DispositivoController::class, 'destroy']);

            // Reportes
            Route::apiResource('reportes', ReporteController::class);

             // Órdenes de reparación
            Route::apiResource('ordenes', OrdenReparacionController::class);
            Route::get('ordenes/{id}/pdf', [OrdenReparacionController::class, 'generarPDF']);
            Route::get('/ordenes/resumen', [OrdenReparacionController::class, 'resumen']);
            Route::get('/ordenes/estado/{estado}', [OrdenReparacionController::class, 'filtrarPorEstado']);
            });

            //Marcas
            Route::apiResource('marcas', MarcaController::class);



});
