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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_estudiante')->unique()->nullable();
            $table->string('nombre_completo');
            $table->string('fecha_nacimiento');
            $table->string('cedula')->nullable();
            $table->string('telefono')->nullable();
            $table->text('lugar_nacimiento')->nullable();
            $table->text('expediente_medico')->nullable();
            $table->text('direccion')->nullable();
            $table->string('sexo')->default('male');
            $table->foreignId('grado_id')->constrained();
            $table->foreignId('tutor_id')->nullable()->constrained('users', 'id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
