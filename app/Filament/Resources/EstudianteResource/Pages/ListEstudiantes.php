<?php

namespace App\Filament\Resources\EstudianteResource\Pages;

use App\Filament\Resources\EstudianteResource;
use App\Imports\EstudianteImport;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListEstudiantes extends ListRecords
{
    protected static string $resource = EstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // Actions\Action::make('import-students')
            //     ->label('Import Students')
            //     ->icon('heroicon-m-plus')
            //     ->form(function (Form $form): Form {
            //         return $form
            //             ->schema([
            //                 Forms\Components\FileUpload::make('file')
            //                     ->label('Importar Estudiantes')
            //                     ->required(),

            //             ]);
            //     })
            //     ->action(function () {
            //         $collection = Excel::toCollection(new EstudianteImport, request()->file('file'), null, \Maatwebsite\Excel\Excel::CSV);
            //         dd($collection);
            //     }),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return EstudianteResource::getWidgets();
    }
}
