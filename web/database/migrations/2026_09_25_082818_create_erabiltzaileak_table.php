<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erabiltzaileak', function (Blueprint $table) {
            $table->id('id_erabiltzailea');

            $table->string('izena');
            $table->string('abizenak');
            $table->string('emaila')->unique();
            $table->string('pasahitza')->nullable();

            $table->unsignedBigInteger('id_rola');

            $table->boolean('aktibo')->default(false);

            $table->foreign('id_rola')
                ->references('id_rola')
                ->on('rolak');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erabiltzaileak');
    }
};