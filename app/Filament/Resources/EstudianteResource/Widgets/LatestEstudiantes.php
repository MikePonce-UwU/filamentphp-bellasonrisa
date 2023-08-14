<?php

namespace App\Filament\Resources\EstudianteResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestEstudiantes extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                null
                // fn ($query) => $query->latest()->get()
            )
            ->columns([
                // ...
                Tables\Columns\TextColumn::make('codigo_estudiante')->label('Código estudiante'),
                Tables\Columns\TextColumn::make('nombre_completo')->label('Nombre estudiante'),
            ]);
    }
}
