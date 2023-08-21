<?php

namespace App\Filament\Parents\Resources;

use App\Filament\Parents\Resources\FacturaResource\Pages;
use App\Filament\Parents\Resources\FacturaResource\RelationManagers;
use App\Models\Factura;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacturaResource extends Resource
{
    protected static ?string $model = Factura::class;

    protected static ?string $activeNavigationIcon = 'heroicon-s-rectangle-stack';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('numero_factura')
                    ->label('# factura')
                    ->html()
                    ->color('danger')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->description('A nombre de:', position: 'above')
                    ->limit(15)
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
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ])
            ->emptyStateActions([
                //     Tables\Actions\CreateAction::make(),
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
            // 'create' => Pages\CreateFactura::route('/create'),
            // 'edit' => Pages\EditFactura::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getModel()::query()->where('user_id', auth()->id());
    }
}
