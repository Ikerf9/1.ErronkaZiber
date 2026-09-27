<?php

namespace Database\Seeders;

use App\Models\Erabiltzailea;
use App\Models\Ikastaroa;
use App\Models\Rola;
use Illuminate\Database\Seeder;

class IkastetxeaSeeder extends Seeder
{
    public function run(): void
    {
        $role = Rola::firstOrCreate(['rola_izena' => 'ikasleak'], ['deskribapena' => 'Ikasleak']);
        foreach ([
            ['Ane', 'Etxeberria', 'ane@example.com'],
            ['Mikel', 'Garcia', 'mikel@example.com'],
            ['Irati', 'Agirre', 'irati@example.com'],
            ['Unai', 'Lopez', 'unai@example.com'],
            ['Leire', 'Zabala', 'leire@example.com'],
            ['Jon', 'Aldaz', 'jon@example.com'],
        ] as [$name, $surname, $email]) {
            Erabiltzailea::firstOrCreate(['emaila' => $email], [
                'izena' => $name, 'abizenak' => $surname, 'id_rola' => $role->id_rola,
                'pasahitza' => null, 'aktibo' => false,
            ]);
        }

        foreach ([
            ['Web garapena', 'Sortu webguneak HTML, CSS, JavaScript eta PHP erabiliz.', 20],
            ['Zibersegurtasunaren oinarriak', 'Ikasi sareak, kontuak eta datuak babesten.', 15],
            ['Datu-baseak eta SQL', 'Diseinatu datu-baseak eta landu SQL kontsultak.', 20],
            ['Sare informatikoak', 'Konfiguratu sare lokalak eta ezagutu komunikazio-protokoloak.', 18],
        ] as [$title, $description, $capacity]) {
            Ikastaroa::firstOrCreate(['izenburua' => $title], [
                'deskribapena' => $description, 'edukiera' => $capacity,
                'hasiera_data' => '2026-10-05', 'amaiera_data' => '2026-12-18',
            ]);
        }
    }
}
