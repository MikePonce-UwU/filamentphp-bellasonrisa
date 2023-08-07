<?php

namespace App\Filament\Resources\GradoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\AttachAction;

class MateriasRelationManager extends RelationManager
{
    protected static string $relationship = 'materias';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_completo')->label('Nombre completo')->required(),
                Forms\Components\TextInput::make('siglas')->label('Siglas')->required(),
                // pivotes
                Forms\Components\TextInput::make('unidad_pedagogica')->label('Unidad pedagógica'),
                Forms\Components\TextInput::make('periodo')->label('Período'),
                Forms\Components\TextInput::make('horas_clase')->label('Horas de clase (por día)'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre_completo')
            ->columns([
                Tables\Columns\TextColumn::make('nombre_completo'),
                Tables\Columns\TextColumn::make('pivot.unidad_pedagogica')->label('Unidad pedagógica'),
                Tables\Columns\TextColumn::make('pivot.periodo')->label('Período'),
                Tables\Columns\TextColumn::make('pivot.horas_clase')->label('Horas de clase (por día)'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('unidad_pedagogica')->label('Unidad pedagógica'),
                        Forms\Components\TextInput::make('periodo')->label('Período'),
                        Forms\Components\TextInput::make('horas_clase')->label('Horas de clase (por día)'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('unidad_pedagogica')->label('Unidad pedagógica'),
                        Forms\Components\TextInput::make('periodo')->label('Período'),
                        Forms\Components\TextInput::make('horas_clase')->label('Horas de clase (por día)'),
                    ]),
            ]);
    }
}
