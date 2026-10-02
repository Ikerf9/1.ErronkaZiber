<?php

namespace Database\Seeders;

use App\Models\Erabiltzailea;
use App\Models\Rola;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Crea el rol y la cuenta de administrador si no existen, dentro de una transacción.
     * Guarda la contraseña como hash y conserva los datos de las cuentas ya existentes.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $rola = Rola::firstOrCreate(
                ['rola_izena' => 'admin'],
                ['deskribapena' => 'Administratzailea'],
            );

            Erabiltzailea::firstOrCreate(
                ['emaila' => 'admin@example.com'],
                [
                    'izena' => 'Admin',
                    'abizenak' => 'Administratzailea',
                    'pasahitza' => Hash::make('Admin123'),
                    'id_rola' => $rola->id_rola,
                    'aktibo' => true,
                ],
            );
        });
    }
}
