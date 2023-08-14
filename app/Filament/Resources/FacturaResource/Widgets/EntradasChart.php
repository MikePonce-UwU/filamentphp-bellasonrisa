<?php

namespace App\Filament\Resources\FacturaResource\Widgets;

use App\Models\Factura;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class EntradasChart extends ChartWidget
{
    protected static ?string $heading = 'Facturas';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Trend::model(Factura::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Facturas registradas',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
