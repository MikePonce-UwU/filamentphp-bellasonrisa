<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacturaResource\Pages;
use App\Filament\Resources\FacturaResource\RelationManagers;
use App\Models\Factura;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacturaResource extends Resource
{
    protected static ?string $model = Factura::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('user_id')
                    ->label('Usuario')
                    ->relationship('user', 'name')
                    ->options(\App\Models\User::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('numero_factura')
                    ->label('Número factura')
                    ->mask('a*99999999999')
                    ->required(),
                Forms\Components\Textarea::make('descripcion_factura')
                    ->label('Razón de la factura')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('total_factura')
                    ->label('total factura')
                    ->prefix('CS$')
                    ->numeric()
                    ->required(),
                Forms\Components\Toggle::make('income')
                    ->label('Entrada o salida de dinero?')
                    ->onIcon('heroicon-s-check')
                    ->offIcon('heroicon-s-x-mark')
                    ->required(),
                Forms\Components\Radio::make('tipo_factura')
                    ->options([
                        'arancel' => 'Arancel',
                        'uniforme_escolar' => 'Uniforme Escolar',
                        'uniforme_deportivo' => 'Uniforme Deportivo',
                        'matricula' => 'Matrícula',
                        'planilla' => 'Pago de planilla',
                    ])
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->description('A nombre de:', position: 'above')
                    ->limit(15)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('numero_factura')
                    ->label('# factura')
                    ->html()
                    ->color('danger')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_factura')
                    ->label('Total facturado')
                    ->numeric(decimalPlaces: 2)
                    ->money('nio'),
                Tables\Columns\ToggleColumn::make('income')
                    ->label('Entrada/salida')
                    ->disabled(),
                Tables\Columns\TextColumn::make('tipo_factura')
                    ->label('Tipo de factura')
                    ->limit(10)
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de factura')
                    ->date(),
                Tables\Columns\TextColumn::make('total_factura')
                    ->summarize([
                        Sum::make()
                            ->label('Suma de Entradas')
                            ->query(fn ($query) => $query->where('income', true))
                            ->numeric(2)
                            ->money('nio'),
                        Sum::make()
                            ->label('Suma de Salidas')
                            ->query(fn ($query) => $query->where('income', false))
                            ->numeric(2)
                            ->money('nio')
                    ]),
                Tables\Columns\ToggleColumn::make('income')
                ->disabled()
                    ->summarize([
                        Count::make()
                            ->label('# de Entradas')
                            ->query(fn ($query) => $query->where('income', true))
                            ->numeric(),
                        Count::make()
                            ->label('# de Salidas')
                            ->query(fn ($query) => $query->where('income', false))
                            ->numeric()
                    ]),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListFacturas::route('/'),
            'create' => Pages\CreateFactura::route('/create'),
            'edit' => Pages\EditFactura::route('/{record}/edit'),
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
