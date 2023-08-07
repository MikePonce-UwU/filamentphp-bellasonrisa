<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
// use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Mis usuarios';
    protected static ?string $navigationGroup = 'Usuarios';

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $activeNavigationIcon = 'heroicon-s-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                    ->label('Nombre Completo')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->required()
                    ->password()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('cedula')
                    ->label('Cédula de identidad')
                    ->unique(),
                Forms\Components\TextInput::make('telefono')
                    ->label('Teléfono')
                    ->unique(),
                Forms\Components\DatePicker::make('fecha_nacimiento')
                    ->label('FDN'), 
                Forms\Components\Select::make('sexo')
                    ->label('Sexo')
                    ->required()
                    ->options([
                        'male' => 'Hombre',
                        'female' => 'Mujer',
                    ]),
                Forms\Components\Select::make('current_role_id')
                    ->relationship(name: 'current_role', titleAttribute: 'name')
                    ->label('Rol asignado')
                    ->required()
                    ->options(\Spatie\Permission\Models\Role::all()->pluck('name', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->description(fn (User $user): string => $user->email, position: 'above')
                    ->copyable()
                    ->copyMessage('Correo copiado al clipboard')
                    ->copyMessageDuration(1000)
                    ->copyableState(fn (User $record): string => "URL: {$record->email}")
                    ->sortable(),
                Tables\Columns\TextColumn::make('cedula')
                    ->label('Cédula')
                    ->placeholder('Sin asignar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')
                    ->label('FDN')
                    ->date()
                    ->placeholder('Sin asignar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_role.name')
                    ->badge()
                    ->color(fn (string $name): string => match ($name) {
                        'admin' => 'success',
                        default => 'danger',
                    })
                    ->label('Rol principal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->limitList()
                    ->label('Roles'),
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
            \App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
