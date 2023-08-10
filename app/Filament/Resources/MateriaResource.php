<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MateriaResource\Pages;
use App\Filament\Resources\MateriaResource\RelationManagers;
use App\Models\Materia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MateriaResource extends Resource
{
    protected static ?string $model = Materia::class;

    protected static ?string $navigationLabel = 'Mis Clases';
    protected static ?string $navigationGroup = 'Estudiantes';

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static ?string $activeNavigationIcon = 'heroicon-s-printer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('nombre_completo')->label('Nombre completo')->required(),
                Forms\Components\TextInput::make('siglas')->label('Siglas')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('nombre_completo')->label('Nombre')->sortable(),
                Tables\Columns\TextColumn::make('siglas')->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\NotasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterias::route('/'),
            'create' => Pages\CreateMateria::route('/create'),
            // 'view' => Pages\ViewMateria::route('/{record}'),
            'edit' => Pages\EditMateria::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}


// Forms\Components\Select::make('grado_id')
//                     ->label('Grado')
//                     ->required(),
//                 Forms\Components\Select::make('estudiante_id')
//                     ->label('Estudiante')
//                     ->required(),
//                 Forms\Components\TextInput::make('nota_1_corte')
//                     ->label('Nota 1er Corte')
//                     ->number(),
//                 Forms\Components\TextInput::make('nota_2_corte')
//                     ->label('Nota 2do corte')
//                     ->number(),
//                 Forms\Components\TextInput::make('nota_3_corte')
//                     ->label('Nota 3er corte')
//                     ->number(),
//                 Forms\Components\TextInput::make('nota_4_corte')
//                     ->label('Nota 4to corte')
//                     ->number(),
//                 Forms\Components\TextInput::make('nota_1_semestre')
//                     ->label('Nota 1er Semestre')
//                     ->number(),
//                 Forms\Components\TextInput::make('nota_2_semestre')
//                     ->label('Nota 2do Semestre')
//                     ->number(),

// Tables\Columns\TextColumn::make('user_id'),
//                 Tables\Columns\TextColumn::make('grado_id'),
//                 Tables\Columns\TextColumn::make('estudiante_id'),
//                 Tables\Columns\TextColumn::make('nota_1_corte'),
//                 Tables\Columns\TextColumn::make('nota_2_corte'),
//                 Tables\Columns\TextColumn::make('nota_3_corte'),
//                 Tables\Columns\TextColumn::make('nota_4_corte'),
//                 Tables\Columns\TextColumn::make('nota_1_semestre'),
//                 Tables\Columns\TextColumn::make('nota_2_semestre'),