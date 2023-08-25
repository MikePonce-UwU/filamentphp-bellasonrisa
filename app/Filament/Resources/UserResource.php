<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                    ->mask('999-999999-9999a')
                    ->placeholder('999-999999-9999A')
                    ->unique(),
                Forms\Components\TextInput::make('telefono')
                    ->label('Teléfono')
                    ->mask('9999-9999')
                    ->placeholder('9999-9999')
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
                    ->description(fn (User $user): string => $user->email)
                    ->sortable(),
                Tables\Columns\TextColumn::make('cedula')
                    ->label('Cédula')
                    ->placeholder('Sin asignar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->copyable()
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('current_role.name')
                    ->label('Rol asignado')
                    ->badge()
                    ->icon('heroicon-o-at-symbol'),
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
            RelationManagers\RolesRelationManager::class,
            RelationManagers\PermissionsRelationManager::class,
            RelationManagers\UserDetailRelationManager::class,
            RelationManagers\MateriasRelationManager::class,
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
