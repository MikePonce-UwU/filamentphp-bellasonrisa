<?php

namespace App\Filament\Resources\EstudianteResource\Pages;

use App\Filament\Resources\EstudianteResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateEstudiante extends CreateRecord
{
    protected static string $resource = EstudianteResource::class;

    protected function afterCreate(): void
    {
        $estudiante = $this->record;

        Notification::make()
            ->title('Nuevo estudiante')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$estudiante->nombre_completo} fue creado (estudiante).**")
            ->actions([
                Action::make('View')
                    ->url(EstudianteResource::getUrl('edit', ['record' => $estudiante])),
            ])
            ->sendToDatabase(auth()->user());
    }
}
