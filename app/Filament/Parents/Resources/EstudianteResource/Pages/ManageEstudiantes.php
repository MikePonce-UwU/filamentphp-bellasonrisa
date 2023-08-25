<?php

namespace App\Filament\Parents\Resources\EstudianteResource\Pages;

use App\Filament\Parents\Resources\EstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEstudiantes extends ManageRecords
{
    protected static string $resource = EstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
