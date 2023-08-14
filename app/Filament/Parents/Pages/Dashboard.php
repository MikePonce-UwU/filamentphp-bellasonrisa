<?php
namespace App\Filament\Parents\Pages;

use App\Filament\Resources\EstudianteResource\Widgets\EstudiantesStatsOverview;
use App\Filament\Resources\FacturaResource\Widgets\EntradasChart;
use App\Filament\Resources\FacturaresourceResource\Widgets\FacturasStatsOverview;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    // public function getWidgets(): array
    // {
    //     return [
    //         // LatestEstudiantes::class,
    //         FacturasStatsOverview::class,
    //         EstudiantesStatsOverview::class,
    //         EntradasChart::class,
    //     ];
    // }
}