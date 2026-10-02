<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders del administrador y del centro para cargar los datos iniciales.
     */
    public function run(): void
    {
        $this->call([AdminSeeder::class, IkastetxeaSeeder::class]);
    }
}
