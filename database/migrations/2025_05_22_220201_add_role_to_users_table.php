<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Agrega el campo role como enum con valores específicos y default
            $table->enum('role', ['admin', 'tecnico', 'docente'])->after('password');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Elimina la columna role en caso de hacer rollback
            $table->dropColumn('role');
        });
    }
}
