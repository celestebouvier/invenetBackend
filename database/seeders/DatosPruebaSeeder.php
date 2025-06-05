<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dispositivo;
use App\Models\OrdenReparacion;

class DatosPruebaSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'adminis@invenet.com',
            'password' => Hash::make('admin123'),
            'role' => 'administrador',
        ]);

        $tecnico = User::create([
            'name' => 'Técnico Juan',
            'email' => 'tecnico@invenet.com',
            'password' => Hash::make('tecnico123'),
            'role' => 'tecnico',
        ]);

        $docente = User::create([
            'name' => 'Docente María',
            'email' => 'docente@invenet.com',
            'password' => Hash::make('docente123'),
            'role' => 'docente',
        ]);

        // Dispositivos
        $disp1 = Dispositivo::create([
            'tipo' => 'Computadora',
            'marca' => 'Dell',
            'modelo' => 'Optiplex 7010',
            'nro_serie' => 'ABC123XYZ',
            'ubicacion' => 'Sala Informática',
            'estado' => 'activo',
        ]);

        $disp2 = Dispositivo::create([
            'tipo' => 'Proyector',
            'marca' => 'Epson',
            'modelo' => 'EB-X06',
            'nro_serie' => 'PJ456789',
            'ubicacion' => 'Sala Multimedia',
            'estado' => 'activo',
        ]);

        // Órdenes de reparación
        OrdenReparacion::create([
            'dispositivo_id' => $disp1->id,
            'usuario_id' => $admin->id,
            'descripcion' => 'No enciende la PC',
            'estado' => 'pendiente',
        ]);

        OrdenReparacion::create([
            'dispositivo_id' => $disp2->id,
            'usuario_id' => $tecnico->id,
            'descripcion' => 'Proyector con imagen borrosa',
            'estado' => 'en_proceso',
        ]);
    }
}
