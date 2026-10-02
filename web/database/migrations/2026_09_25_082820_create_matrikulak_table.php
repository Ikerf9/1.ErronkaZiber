<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea las matrículas que relacionan usuarios y cursos, con fecha y estado.
     * Impide duplicar la pareja usuario-curso y elimina sus matrículas cuando se borra el usuario o el curso.
     */
    public function up(): void
    {
        Schema::create('matrikulak', function (Blueprint $table) {
            $table->id('id_matrikula');

            $table->unsignedBigInteger('id_erabiltzailea');
            $table->unsignedBigInteger('id_ikastaroa');

            $table->date('matrikula_data');
            $table->string('egoera')->default('aktibo');

            $table->foreign('id_erabiltzailea')
                ->references('id_erabiltzailea')
                ->on('erabiltzaileak')
                ->cascadeOnDelete();

            $table->foreign('id_ikastaroa')
                ->references('id_ikastaroa')
                ->on('ikastaroak')
                ->cascadeOnDelete();

            $table->unique([
                'id_erabiltzailea',
                'id_ikastaroa'
            ]);
        });
    }

    /**
     * Elimina la tabla de matrículas al revertir esta migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrikulak');
    }
};
