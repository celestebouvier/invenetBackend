<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DispositivoController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {

      // CRUD de usuarios
    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('dispositivos', DispositivoController::class);
    Route::apiResource('reportes', ReporteController::class);

});
