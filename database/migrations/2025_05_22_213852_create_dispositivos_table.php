<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // Ej: CPU, Monitor, Switch, etc.
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('codigo_qr')->unique(); // Valor asociado al QR
            $table->text('descripcion')->nullable();
            $table->enum('ubicacion', [
            'Sala Informática 1',
            'Sala Informática 2',
            'Sala Informática 3',
            'Sala Multimedia 1',
            'Sala Multimedia 2',
            'Sala Multimedia 3',
            'Otro',
            ]);
            $table->string('nro_serie')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositivos');
    }
};
