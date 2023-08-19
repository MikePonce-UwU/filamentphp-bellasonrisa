<?php

namespace App\Filament\Resources\NotaResource\Pages;

use App\Filament\Resources\MateriaResource;
use App\Filament\Resources\NotaResource;
use App\Models\Estudiante;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateNota extends CreateRecord
{
    protected static string $resource = NotaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $estudiante = Estudiante::find($data['estudiante_id'])->first()->nombre_completo;
        // dd($estudiante);
        $data['user_id'] = auth()->id();
        return $data;
    }
    protected function afterCreate(): void
    {
        $data = $this->record;
        $user = auth()->user()->name;

        $estudiante = Estudiante::query()->where('id', $data['estudiante_id'])->first()->nombre_completo;
        Notification::make()
            ->title('Nueva nota')
            ->icon('heroicon-o-folder')
            ->body("**{$user} creó un nuevo record de nota para el estudiante {$estudiante}.**")
            ->actions([
                Action::make('View')
                    ->url(MateriaResource::getUrl('edit', ['record' => $data['materia_id']])),
            ])
            ->sendToDatabase(User::all());
    }
}
