<?php

namespace App\Filament\Resources\EstudianteResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EstudiantesStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected function getStats(): array
    {
        return [
            //
            Stat::make('N° Estudiantes', \App\Models\Estudiante::count())
                ->description('')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->descriptionColor('warning'),
        ];
    }
}
