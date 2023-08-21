<?php

namespace App\Filament\Parents\Resources\NotasEstudianteResource\Pages;

use App\Filament\Parents\Resources\NotasEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotasEstudiante extends EditRecord
{
    protected static string $resource = NotasEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
