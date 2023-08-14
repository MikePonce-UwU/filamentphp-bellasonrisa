<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EstudianteResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class EstudiantesTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(EstudianteResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                // ...
                Tables\Columns\TextColumn::make('codigo_estudiante')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nombre_completo')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')->sortable(),
                Tables\Columns\TextColumn::make('grado.siglas')->sortable(),
            ]);
    }
}
