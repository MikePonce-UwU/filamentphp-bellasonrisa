<?php

namespace App\Filament\Parents\Resources\NotasEstudianteResource\Pages;

use App\Filament\Parents\Resources\NotasEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotasEstudiantes extends ListRecords
{
    protected static string $resource = NotasEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
