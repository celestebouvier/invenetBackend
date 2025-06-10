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
            $table->unsignedBigInteger('usuario_id') ->nullable;
            $table->unsignedBigInteger('reporte_id');
            $table->unsignedBigInteger('tecnico_id');
            $table->text('descripcion')->nullable;
            $table->enum('estado', ['pendiente', 'en_proceso', 'completada'])->default('pendiente');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reporte_id')->references('id')->on('reportes')->onDelete('cascade');
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
