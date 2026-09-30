<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
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

    public function down(): void
    {
        // Previous per-course capacities cannot be recovered reliably.
        // Keep the capacity and all existing enrollments intact.
    }
};
