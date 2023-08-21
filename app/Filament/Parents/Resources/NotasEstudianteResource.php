<?php

namespace App\Filament\Parents\Resources;

use App\Filament\Parents\Resources\NotasEstudianteResource\Pages;
use App\Filament\Parents\Resources\NotasEstudianteResource\RelationManagers;
use App\Models\Estudiante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotasEstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;
    protected static ?string $breadcrumb = 'Mis Estudiantes';
    protected static ?string $navigationLabel = 'Mis Estudiantes';

    protected static ?string $activeNavigationIcon = 'heroicon-s-users';
    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                Tables\Columns\TextColumn::make('fecha_nacimiento')->sortable(),
                Tables\Columns\TextColumn::make('grado.siglas')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
                                Components\TextEntry::make('materia.siglas')
                                    ->label('Materia'),
                                Components\TextEntry::make('grado.siglas')
                                    ->label('Grado'),
                                Components\TextEntry::make('nota_1_corte')
                                    ->label('I corte'),
                                Components\TextEntry::make('nota_2_corte')
                                    ->label('II Corte'),
                                Components\TextEntry::make('primer_semestre')
                                    ->label('I Semestre'),
                                Components\TextEntry::make('nota_3_corte')
                                    ->label('III Corte'),
                                Components\TextEntry::make('nota_4_corte')
                                    ->label('IV Corte'),
                                Components\TextEntry::make('segundo_semestre')
                                    ->label('II Semestre'),
                                Components\TextEntry::make('nota_final')
                                    ->label('Nota Final'),
                            ])
                    ])
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotasEstudiantes::route('/'),
            // 'create' => Pages\CreateNotasEstudiante::route('/create'),
            // 'edit' => Pages\EditNotasEstudiante::route('/{record}/edit'),
        ];
    }    
    public static function getEloquentQuery(): Builder
    {
        return parent::getModel()::query()->where('tutor_id', auth()->id());
    }
}
