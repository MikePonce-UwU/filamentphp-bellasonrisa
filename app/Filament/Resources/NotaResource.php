<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotaResource\Pages;
use App\Filament\Resources\NotaResource\RelationManagers;
use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\Materia;
use App\Models\Nota;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotaResource extends Resource
{
    protected static ?string $model = Nota::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $activeNavigationIcon = 'heroicon-s-archive-box';


    public static function form(Form $form): Form
    {
        $materias = auth()->user()->is_admin() ? Materia::all()->pluck('nombre_completo', 'id') : auth()->user()->materias;
        return $form
            ->schema([
                //
                Forms\Components\Section::make('Información básica')
                    ->icon('heroicon-o-exclamation-circle')
                    ->description('La información base de las notas que serán añadidas a los récords del colegio.')
                    ->aside()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('estudiante_id')
                            ->label('Estudiante ID')
                            ->options(Estudiante::all()->pluck('nombre_completo', 'id'))
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('materia_id')
                            ->label('Materia ID')
                            ->options($materias)
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('grado_id')
                            ->label('Grado ID')
                            ->options(Grado::all()->pluck('nombre_completo', 'id'))
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('user_id')
                            ->label('Usuario ID')
                            ->default(auth()->id())
                            ->disabled()
                            ->helperText(str('El campo **Usuario ID** no puede ser modificado*')->markdown()->toHtmlString()),
                    ]),
                Forms\Components\Section::make('Notas')
                    ->icon('heroicon-o-folder')
                    ->description('Los récords de las notas del alumno seleccionado previamente, se clasificarán por nota del primer, segundo, tercer y cuarto corte evaluativo. Al final, en la sección de materias se podrá ver la nota semestral y final.')
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('nota_1_corte')
                            ->label('Nota 1er Corte')
                            ->numeric(),
                        Forms\Components\TextInput::make('nota_2_corte')
                            ->label('Nota 2do Corte')
                            ->numeric(),
                        Forms\Components\TextInput::make('nota_3_corte')
                            ->label('Nota 3er Corte')
                            ->numeric(),
                        Forms\Components\TextInput::make('nota_4_corte')
                            ->label('Nota 4to Corte')
                            ->numeric(),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Información básica')
                    ->icon('heroicon-o-exclamation-circle')
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('estudiante.nombre_completo'),
                                        Components\TextEntry::make('grado.nombre_completo'),
                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('materia.nombre_completo'),
                                        Components\TextEntry::make('user.name'),
                                    ]),
                                ])
                        ])
                    ]),
                Components\Section::make('Notas')
                    ->icon('heroicon-o-folder')
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('nota_1_corte'),
                                        Components\TextEntry::make('nota_2_corte'),
                                        Components\TextEntry::make('primer_semestre'),
                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('nota_3_corte'),
                                        Components\TextEntry::make('nota_4_corte'),
                                        Components\TextEntry::make('segundo_semestre'),
                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('nota_final'),
                                    ]),
                                ]),
                        ])
                    ]),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('grado.nombre_completo')
            ->columns([
                //
                Tables\Columns\TextColumn::make('estudiante.nombre_completo')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('materia.siglas')->sortable()->searchable(),
                Tables\Columns\TextInputColumn::make('nota_1_corte'),
                Tables\Columns\TextInputColumn::make('nota_2_corte'),
                Tables\Columns\TextInputColumn::make('nota_3_corte'),
                Tables\Columns\TextInputColumn::make('nota_4_corte'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotas::route('/'),
            'create' => Pages\CreateNota::route('/create'),
            // 'edit' => Pages\EditNota::route('/{record}/edit'),
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
