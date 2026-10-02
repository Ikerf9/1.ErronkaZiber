<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Establece la capacidad de todos los cursos en 30 dentro de una transacción.
     * Interrumpe la migración si algún curso ya tiene más de 30 matrículas activas.
     */
    public function up(): void
    {
        DB::transaction(function () {
            if (DB::table('matrikulak')->select('id_ikastaroa')->where('egoera', 'aktibo')
                ->groupBy('id_ikastaroa')->havingRaw('COUNT(*) > 30')->exists()) {
                throw new RuntimeException('A course already has more than 30 active enrollments. Resolve those enrollments before applying this migration.');
            }
            DB::table('ikastaroak')->update(['edukiera' => 30]);
        });
    }

    /**
     * Conserva las capacidades y las matrículas porque no se pueden recuperar las capacidades anteriores.
     */
    public function down(): void
    {
        // No se pueden recuperar con fiabilidad las capacidades anteriores de cada curso.
        // Se conservan la capacidad y todas las matrículas existentes.
    }
};
