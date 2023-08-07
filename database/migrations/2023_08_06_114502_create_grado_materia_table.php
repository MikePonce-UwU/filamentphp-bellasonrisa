<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grado_materia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grado_id')->constrained();
            $table->foreignId('materia_id')->constrained();
            $table->string('unidad_pedagogica')->nullable();
            $table->string('periodo')->nullable();
            $table->string('horas_clase')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grado_materia');
    }
};
