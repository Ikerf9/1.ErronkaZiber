<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rolak', function (Blueprint $table) {
            $table->id('id_rola');
            $table->string('rola_izena');
            $table->text('deskribapena')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rolak');
    }
};