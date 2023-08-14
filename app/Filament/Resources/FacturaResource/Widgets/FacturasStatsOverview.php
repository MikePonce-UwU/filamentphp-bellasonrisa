<?php

namespace App\Filament\Resources\FacturaResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FacturasStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            //
            Stat::make('N° facturas', \App\Models\Factura::count())
                ->description('')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->descriptionColor('warning'),
            // Stat::make()
        ];
    }
}
