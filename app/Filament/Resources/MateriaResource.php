<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MateriaResource\Pages;
use App\Filament\Resources\MateriaResource\RelationManagers;
use App\Models\Materia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
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
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Información básica')
                    ->icon('heroicon-o-exclamation-circle')
                    ->schema([
                        Components\TextEntry::make('nombre_completo'),
                        Components\TextEntry::make('siglas'),
                    ]),
                // Components\Section::make('Notas')
                //     ->icon('heroicon-o-folder')
                //     ->schema([
                //         Components\RepeatableEntry::make('notas')
                //         ->schema([
                //             Components\Section::make()
                //                 ->schema([
                //                     Components\TextEntry::make('estudiante.nombre_completo'),
                //                     Components\TextEntry::make('grado.nombre_completo'),
                //                     Components\TextEntry::make('user.name'),
                //                 ]),
                //             Components\Section::make()
                //                 ->schema([
                //                     Components\TextEntry::make('primer_semestre'),
                //                     Components\TextEntry::make('segundo_semestre'),
                //                     Components\TextEntry::make('nota_final'),
                //                 ]),
                //         ])
                //     ]),
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
