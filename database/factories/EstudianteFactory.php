<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre_completo' => fake()->name(),
            'fecha_nacimiento' => fake()->date(),
            'telefono' => fake('es-NI')->phoneNumber(),
            'lugar_nacimiento' => fake()->address(),
            'expediente_medico' => fake()->text(),
            'direccion' => fake()->address(),
            'sexo' => fake()->randomElement(['male', 'female']),
            'grado_id' => fake()->numberBetween(1, \App\Models\Grado::count()),
        ];
    }
}
