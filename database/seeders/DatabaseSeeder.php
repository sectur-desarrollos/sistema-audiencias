<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AudienceStatus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'JFPG',
            'email' => 'jfpg@turismochiapas.gob.mx',
            'password' => bcrypt('123')
        ]);
        \App\Models\Dependency::create([
            'name' => 'Secretaría de Hacienda',
            'activo' => true,
        ]);
        \App\Models\Dependency::create([
            'name' => 'Secretaría de Economía',
            'activo' => true,
        ]);
        \App\Models\Dependency::create([
            'name' => 'DIF',
            'activo' => true,
        ]);
        \App\Models\ContactType::create([
            'name' => 'Teléfono',
            'activo' => true,
        ]);
        \App\Models\ContactType::create([
            'name' => 'Personal',
            'activo' => true,
        ]);
        \App\Models\ContactType::create([
            'name' => 'Email',
            'activo' => true,
        ]);
        // Estatus de Audiencia
        $statuses = [
            ['name' => 'Iniciado', 'description' => 'La audiencia está en etapa inicial.', 'activo' => true],
            ['name' => 'En Proceso', 'description' => 'La audiencia está en curso.', 'activo' => true],
            ['name' => 'Cancelado', 'description' => 'La audiencia ha sido cancelada.', 'activo' => true],
            ['name' => 'Finalizado', 'description' => 'La audiencia ha finalizado.', 'activo' => true],
        ];

        foreach ($statuses as $status) {
            AudienceStatus::create($status);
        }
    }
}
