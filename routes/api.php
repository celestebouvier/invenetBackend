<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\OrdenReparacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Support\Facades\Mail;




// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Reset contraseña
Route::post('/password/send-code', [PasswordResetController::class, 'sendResetCode']);
Route::post('/password/verify-code', [PasswordResetController::class, 'verifyCode']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);

// Autenticación con Sanctum
Route::middleware(['auth:sanctum'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    //Actualizar datos de usuario (solo Usuario logueado)
    Route::get('/perfil', [UserController::class, 'showProfile']);
    Route::put('/perfil', [UserController::class, 'updateProfile']);
    Route::put('/usuarios/{id}', [UserController::class, 'update']);

    // Acceso general (ver dispositivos)
    Route::get('/inventario', [DispositivoController::class, 'index']);
    Route::get('/dispositivos/{id}', [DispositivoController::class, 'show']);
    Route::get('/dispositivos/{id}/ver-qr', [DispositivoController::class, 'verQr']);
    Route::get('/dispositivos/{id}/qr-pdf', [DispositivoController::class, 'downloadQr']);

    //Reportes
    // Crear un nuevo reporte (solo DOCENTE o ADMINISTRADOR)
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
            Route::get('/dispositivos/enums', [DispositivoController::class, 'enums']);
            Route::get('/dispositivos/{id}', [DispositivoController::class, 'show']);


            // Reportes
            Route::get('/reportes', [ReporteController::class, 'index']); // con ?estado=pending o ?estado=revisado
            Route::put('/reportes/{id}/estado', [ReporteController::class, 'updateEstado']);
            Route::delete('/reportes/{id}', [ReporteController::class, 'destroy']);

             // Órdenes de reparación

            Route::get('ordenes/{id}/pdf', [OrdenReparacionController::class, 'generarPDF']);
            Route::get('ordenes/{id}/verorden', [OrdenReparacionController::class, 'verOrden']);
            Route::get('ordenes/resumen', [OrdenReparacionController::class, 'resumen']);
            Route::get('/ordenes/estado/{estado}', [OrdenReparacionController::class, 'filtrarPorEstado']);
            Route::apiResource('ordenes', OrdenReparacionController::class);

            //Marcas
            Route::apiResource('marcas', MarcaController::class);

            });





});
