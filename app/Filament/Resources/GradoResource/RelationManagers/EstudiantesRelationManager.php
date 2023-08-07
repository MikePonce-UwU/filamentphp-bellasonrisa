<?php

namespace App\Filament\Resources\GradoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstudiantesRelationManager extends RelationManager
{
    protected static string $relationship = 'estudiantes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo_estudiante')
                    ->label('Código estudiantil')
                    ->unique()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nombre_completo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('sexo')
                    ->required()
                    ->options([
                        'male' => 'Chico',
                        'female' => 'Chica',
                    ]),
                Forms\Components\DatePicker::make('fecha_nacimiento')
                    ->label('Fecha de nacimiento')
                    ->required(),
                Forms\Components\TextInput::make('cedula')
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono')
                    ->unique()
                    ->maxLength(255),
                Forms\Components\Textarea::make('lugar_nacimiento')
                    ->maxLength(255),
                Forms\Components\Textarea::make('direccion')
                    ->maxLength(255),
                Forms\Components\Textarea::make('expediente_medico')
                    ->maxLength(255),
                Forms\Components\Select::make('tutor_id')
                    ->relationship(name: 'tutor', titleAttribute: 'name')
                    ->options(\App\Models\User::where('name', 'like', 'Padre de familia')->get()->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre_completo')
            ->columns([
                Tables\Columns\TextColumn::make('nombre_completo')->sortable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')->sortable(),
                Tables\Columns\TextColumn::make('sexo')->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
