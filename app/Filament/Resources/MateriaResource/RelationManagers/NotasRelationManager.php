<?php

namespace App\Filament\Resources\MateriaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotasRelationManager extends RelationManager
{
    protected static string $relationship = 'notas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('estudiante_id')
                    ->label('Estudiante')
                    ->relationship('estudiante', 'nombre_completo')
                    ->options(\App\Models\Estudiante::all()->pluck('nombre_completo', 'id'))
                    ->required(),
                Forms\Components\Select::make('grado_id')
                    ->label('Grado')
                    ->relationship('grado', 'nombre_completo')
                    ->options(\App\Models\Grado::all()->pluck('nombre_completo', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('nota_1_corte')
                    ->label('Nota 1er Corte'),
                Forms\Components\TextInput::make('nota_2_corte')
                    ->label('Nota 2do corte'),
                Forms\Components\TextInput::make('nota_3_corte')
                    ->label('Nota 3er corte'),
                Forms\Components\TextInput::make('nota_4_corte')
                    ->label('Nota 4to corte'),
            ]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nota_total')
            ->columns([
                Tables\Columns\TextColumn::make('estudiante_id'),
                Tables\Columns\TextColumn::make('grado_id'),
                Tables\Columns\TextColumn::make('nota_1_corte'),
                Tables\Columns\TextColumn::make('nota_2_corte'),
                Tables\Columns\TextColumn::make('nota_3_corte'),
                Tables\Columns\TextColumn::make('nota_4_corte'),
                Tables\Columns\TextColumn::make('primer_semestre'),
                Tables\Columns\TextColumn::make('nota_2_semestre'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Select::make('estudiante_id')
                            ->label('Estudiante')
                            ->relationship('estudiante', 'nombre_completo')
                            ->options(\App\Models\Estudiante::all()->pluck('nombre_completo', 'id'))
                            ->required(),
                        Forms\Components\Select::make('grado_id')
                            ->label('Grado')
                            ->relationship('grado', 'nombre_completo')
                            ->options(\App\Models\Grado::all()->pluck('nombre_completo', 'id'))
                            ->required(),
                        Forms\Components\TextInput::make('nota_1_corte')
                            ->label('Nota 1er Corte'),
                        Forms\Components\TextInput::make('nota_2_corte')
                            ->label('Nota 2do corte'),
                        Forms\Components\TextInput::make('nota_3_corte')
                            ->label('Nota 3er corte'),
                        Forms\Components\TextInput::make('nota_4_corte')
                            ->label('Nota 4to corte'),
                    ]),
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
