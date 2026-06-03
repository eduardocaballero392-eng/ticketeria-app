<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // firstOrCreate: no falla si ya existe
        $exists = DB::table('tecnico')->where('correo', 'admin@empresa.com')->exists();

        if (!$exists) {
            DB::table('tecnico')->insert([
                'codigo_tecnico'   => 'ADM001',
                'nombre'           => 'Admin',
                'apellido_paterno' => 'Principal',
                'apellido_materno' => null,
                'dni'              => '60824920',
                'correo'           => 'admin@empresa.com',
                'contraseña'       => Hash::make('admin123'),
                'id_cargo'         => 1,
                'activo'           => true,
            ]);
            echo "Admin user created.\n";
        } else {
            echo "Admin user already exists, skipping.\n";
        }
    }
}