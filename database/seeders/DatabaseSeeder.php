<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Closure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->command->warn(PHP_EOL . 'Creando random grados...');
        $grados = $this->withProgressBar(10, fn() => \App\Models\Grado::factory(10)->create());
        $this->command->info('Grados creados!');

        $this->command->warn(PHP_EOL . 'Creando random materias...');
        $materias = $this->withProgressBar(10, fn() => \App\Models\Materia::factory(10)->create());
        $this->command->info('Materias creadas!');
        
        $this->command->warn(PHP_EOL . 'Creando random estudiantes...');
        $estudiantes = $this->withProgressBar(100, fn() => \App\Models\Estudiante::factory(100)->create());
        $this->command->info('Estudiantes creados!');
        
        $this->command->warn(PHP_EOL . 'Creando random notas...');
        $notas = $this->withProgressBar(1000, fn() => \App\Models\Nota::factory(1000)->create());
        $this->command->info('Notas creadas!');
        
        $this->command->warn(PHP_EOL . 'Creando roles...');
        \App\Models\Role::factory()->create([
            'name' => 'Admin',
        ]);
        \App\Models\Role::factory()->create([
            'name' => 'Director',
        ]);
        \App\Models\Role::factory()->create([
            'name' => 'Sub-director',
        ]);
        \App\Models\Role::factory()->create([
            'name' => 'Maestro',
        ]);
        \App\Models\Role::factory()->create([
            'name' => 'Padre de familia',
        ]);
        \App\Models\Role::factory()->create([
            'name' => 'Contador',
        ]);
        $user = \App\Models\User::find(1)->first();
        $user->assignRole(['Admin', 'Director', 'Sub-director', 'Maestro', 'Padre de familia']);
        $this->command->info('Roles creados, asignados al administrador!');
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
    }
    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
