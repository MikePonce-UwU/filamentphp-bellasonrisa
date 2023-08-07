<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstudianteResource\Pages;
use App\Filament\Resources\EstudianteResource\RelationManagers;
use App\Models\Estudiante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    protected static ?string $navigationLabel = 'Mis Estudiantes';
    protected static ?string $navigationGroup = 'Estudiantes';

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                Forms\Components\Select::make('grado_id')
                    ->relationship(name: 'grado', titleAttribute: 'nombre_completo')
                    ->options(\App\Models\Grado::get()->pluck('nombre_completo', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('tutor_id')
                    ->relationship(name: 'tutor', titleAttribute: 'name')
                    ->options(\App\Models\User::where('name', 'like', 'Padre de familia')->get()->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('codigo_estudiante')->sortable(),
                Tables\Columns\TextColumn::make('nombre_completo')->sortable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')->sortable(),
                Tables\Columns\TextColumn::make('grado.siglas')->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstudiantes::route('/'),
            'create' => Pages\CreateEstudiante::route('/create'),
            'edit' => Pages\EditEstudiante::route('/{record}/edit'),
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
