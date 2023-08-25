<?php

namespace App\Filament\Parents\Resources;

use App\Filament\Parents\Resources\EstudianteResource\Pages;
use App\Filament\Parents\Resources\EstudianteResource\RelationManagers;
use App\Models\Estudiante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\components;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    protected static ?string $activeNavigationIcon = 'heroicon-s-document-text';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Mis estudiantes';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('codigo_estudiante')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nombre_completo')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('grado.siglas')->sortable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ])
            ->emptyStateActions([
                // Tables\Actions\CreateAction::make(),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make()
                ->schema([
                    Components\RepeatableEntry::make('notas')
                        ->schema([
                            Components\TextEntry::make('materia.siglas'),
                            Components\TextEntry::make('primer_semestre'),
                            Components\TextEntry::make('segundo_semestre'),
                            Components\TextEntry::make('nota_final'),
                        ])
                        ->columns(4),
                ])
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEstudiantes::route('/'),
        ];
    }    
    public static function getEloquentQuery(): Builder
    {
        return parent::getModel()::query()->where('tutor_id', auth()->id());
    }
}
