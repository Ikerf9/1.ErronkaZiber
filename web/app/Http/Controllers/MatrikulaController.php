<?php

namespace App\Http\Controllers;

use App\Models\Matrikula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatrikulaController extends Controller
{
    /**
     * Valida el estado solicitado y activa o desactiva la matrícula dentro de una transacción.
     * Para reactivarla, comprueba que el alumno esté activo, tenga el rol de alumno y haya plazas disponibles.
     */
    public function update(Request $request, Matrikula $matrikula)
    {
        $data = $request->validate([
            'egoera' => ['required', 'in:aktibo,ez_aktibo'],
        ], [
            'egoera.required' => 'Aukeratu matrikularen egoera.',
            'egoera.in' => 'Matrikularen egoera ez da baliozkoa.',
        ]);

        $error = DB::transaction(function () use ($matrikula, $data) {
            // Esta escritura sin cambio de valor coordina la comprobación de plazas con las nuevas matrículas en SQLite.
            DB::table('ikastaroak')->where('id_ikastaroa', $matrikula->id_ikastaroa)
                ->update(['edukiera' => DB::raw('edukiera')]);
            $matrikula->refresh();

            if ($data['egoera'] === 'aktibo' && $matrikula->egoera !== 'aktibo') {
                $student = $matrikula->erabiltzailea;
                if (! $student?->aktibo || $student->rola?->rola_izena !== 'ikasleak') {
                    return 'Matrikula aktibatzeko, ikaslearen kontuak aktibo egon behar du.';
                }
                $course = $matrikula->ikastaroa;
                if ($course->matrikulak()->where('egoera', 'aktibo')->count() >= $course->edukiera) {
                    return 'Ez dago plaza librerik ikastaro honetan.';
                }
            }

            $matrikula->update(['egoera' => $data['egoera']]);

            return null;
        });

        return $error
            ? back()->withErrors(['matrikula' => $error])
            : back()->with('status', $data['egoera'] === 'aktibo'
                ? 'Matrikula aktibatu da.' : 'Matrikula desaktibatu da. Plaza libre geratu da.');
    }
}
