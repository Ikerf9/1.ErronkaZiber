<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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

    public function down(): void
    {
        Schema::dropIfExists('matrikulak');
    }
};