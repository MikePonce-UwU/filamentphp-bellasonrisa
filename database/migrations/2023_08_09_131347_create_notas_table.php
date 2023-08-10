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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained();
            $table->foreignId('grado_id')->constrained();
            $table->foreignId('materia_id')->constrained();
            $table->string('nota_1_corte')->nullable();
            $table->string('nota_2_corte')->nullable();
            $table->string('nota_3_corte')->nullable();
            $table->string('nota_4_corte')->nullable();
            $table->string('nota_1_semestre')->nullable();
            $table->string('nota_2_semestre')->nullable();
            $table->string('nota_total')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
