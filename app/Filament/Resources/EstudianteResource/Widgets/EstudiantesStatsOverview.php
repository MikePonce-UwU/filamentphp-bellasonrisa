<?php

namespace App\Filament\Resources\EstudianteResource\Widgets;

use App\Filament\Resources\EstudianteResource\Pages\ListEstudiantes;
use App\Models\Estudiante;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class EstudiantesStatsOverview extends BaseWidget
{
    use InteractsWithPageTable;
    protected static ?int $sort = 2;

    protected function getTablePage(): string
    {
        return ListEstudiantes::class;
    }
    
    protected function getStats(): array
    {
        $estudiantes = Trend::model(Estudiante::class)
        ->between(
            start: now()->subYear(),
            end: now()
        )
        ->perMonth()
        ->count();
        return [
            //
            Stat::make('N° Estudiantes', $this->getPageTableQuery()->count())
            ->chart(
                $estudiantes
                ->map(fn (TrendValue $val) => $val->aggregate)
                ->toArray()
            ),
        ];
    }
}
