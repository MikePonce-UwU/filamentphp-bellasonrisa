<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;
    protected function getStats(): array
    {
        return [
            //
            Stat::make('N° facturas', \App\Models\Factura::count())
                ->description('Número de facturas registradas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info'),
            Stat::make('N° Estudiantes', \App\Models\Estudiante::count())
                ->description('Número de estudiantes matriculados')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('info'),
            Stat::make('N° Empleados', \App\Models\User::where('current_role_id', '!=', 5)->count())
                ->description('Número de empleados')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('info'),
        ];
    }
}
