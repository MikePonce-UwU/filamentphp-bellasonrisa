<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nota>
 */
class NotaFactory extends Factory
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
            'user_id' => fake()->numberBetween(1, \App\Models\User::count()),
            'grado_id' => fake()->numberBetween(1, \App\Models\Grado::count()),
            'materia_id' => fake()->numberBetween(1, \App\Models\Materia::count()),
            'estudiante_id' => fake()->numberBetween(1, \App\Models\Estudiante::count()),
            'nota_1_corte' => fake()->numberBetween(60, 100),
            'nota_2_corte' => fake()->numberBetween(60, 100),
            'nota_3_corte' => fake()->numberBetween(60, 100),
            'nota_4_corte' => fake()->numberBetween(60, 100),
        ];
    }
}
