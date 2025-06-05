<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenesReparacionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordenes_reparacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dispositivo_id');
            $table->unsignedBigInteger('usuario_id');
            $table->text('descripcion');
            $table->enum('estado', ['pendiente', 'en_proceso', 'completada'])->default('pendiente');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('dispositivo_id')->references('id')->on('dispositivos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_reparacion');
    }
}
