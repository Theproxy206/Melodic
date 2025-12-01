<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe para no duplicar
        if (!User::where('email', 'label@melodic.com')->exists()) {

            User::create([
                'username'     => 'Melodic Records', // Nombre de la disquera
                'email'        => 'label@melodic.com',
                'password'     => Hash::make('password'), // Contraseña fácil para pruebas
                'role'         => 'label',
                'is_suscribed' => true, // Las labels tienen acceso premium por defecto
                'label'        => null, // Una label no tiene otra label padre
            ]);

            $this->command->info('¡Label de prueba creada exitosamente!');
            $this->command->info('Email: label@melodic.com');
            $this->command->info('Password: password');

        } else {
            $this->command->warn('La Label de prueba ya existe.');
        }
    }
}
