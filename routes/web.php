<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\OrdenReparacionController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dispositivos/{id}/qr-pdf', [DispositivoController::class, 'downloadQr'])->name('dispositivos.qr.pdf');

Route::get('/ordenes/{id}/ver', [OrdenReparacionController::class, 'verOrdenWeb'])->name('ordenes.ver');
