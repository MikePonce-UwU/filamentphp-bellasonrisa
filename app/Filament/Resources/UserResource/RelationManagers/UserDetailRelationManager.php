<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\UserDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'user_detail';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->hasRole('Admin') || UserDetail::where('user_id', '=', $ownerRecord->id)->first() != null;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('salario')
                    ->prefix('C$-')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('adelantos')
                    ->prefix('C$-')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TagsInput::make('dias_laborales')
                    ->required()
                    ->separator(',')
                    ->suggestions([
                        'Lunes',
                        'Martes',
                        'Miércoles',
                        'Jueves',
                        'Sábado',
                        'Domingo',
                    ]),
                Forms\Components\TextInput::make('horas_laborales')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('salario')
            ->columns([
                Tables\Columns\TextColumn::make('salario')->money('nio'),
                Tables\Columns\TextColumn::make('adelantos')->money('nio'),
                Tables\Columns\TextColumn::make('dias_laborales')
                    ->badge()
                    ->separator(',')
                    ->limit(),
                Tables\Columns\TextColumn::make('horas_laborales'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
