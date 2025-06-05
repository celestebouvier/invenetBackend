<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDispositivosTable extends Migration
{
    public function up(): void
    {
        Schema::table('dispositivos', function (Blueprint $table) {
            $table->dropColumn('nombre'); // 1. Eliminar campo
            $table->string('nro_serie')->nullable()->change(); // 2. Hacer nullable
            $table->enum('tipo', ['CPU', 'netbook', 'televisor', 'proyector', 'monitor', 'router', 'switch'])->change(); // 3. Convertir en ENUM
        });
    }

    public function down(): void
    {
        Schema::table('dispositivos', function (Blueprint $table) {
            $table->string('nombre');
            $table->string('nro_serie')->nullable(false)->change();
            $table->string('tipo')->change(); // Volver a string plano
        });
    }
}
