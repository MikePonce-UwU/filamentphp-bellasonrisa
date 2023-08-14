<?php

namespace App\Filament\Widgets;

use App\Models\Factura;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class FacturasChart extends ChartWidget
{
    protected static ?string $heading = 'Facturas del mes';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Trend::model(Factura::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
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
