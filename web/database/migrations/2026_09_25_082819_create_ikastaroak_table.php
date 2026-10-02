<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de cursos con título, descripción, fechas y capacidad predeterminada de 30 plazas.
     */
    public function up(): void
    {
        Schema::create('ikastaroak', function (Blueprint $table) {
            $table->id('id_ikastaroa');
            $table->string('izenburua');
            $table->text('deskribapena')->nullable();
            $table->integer('edukiera')->default(30);
            $table->date('hasiera_data');
            $table->date('amaiera_data');
        });
    }

    /**
     * Elimina la tabla de cursos al revertir esta migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikastaroak');
    }
};
