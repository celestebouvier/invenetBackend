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
            $table->string('ubicacion'); // Sala informática o multimedia
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
