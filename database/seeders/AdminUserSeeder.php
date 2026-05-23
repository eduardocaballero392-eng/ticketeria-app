<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tecnico')->insert([
            'codigo_tecnico'   => 'ADM001',
            'nombre'           => 'Admin',
            'apellido_paterno' => 'Principal', // CORREGIDO
            'apellido_materno' => null,        // opcional
            'dni'              => 60824920,
            'correo'           => 'admin@empresa.com',
            'contraseña'       => Hash::make('admin123'), // coincide con la columna
            'id_cargo'         => 1,// asegúrate que exista el cargo admin en la tabla cargo
            'activo'           => true,
        ]);
    }
}