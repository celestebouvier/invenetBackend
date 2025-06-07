<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DispositivoController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dispositivos/{id}/qr-pdf', [DispositivoController::class, 'downloadQr'])->name('dispositivos.qr.pdf');
