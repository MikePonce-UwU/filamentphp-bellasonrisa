<?php

namespace App\Filament\Resources\MateriaResource\Pages;

use App\Filament\Resources\MateriaResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewMateria extends ViewRecord
{
    protected static string $resource = MateriaResource::class;

    // public function infolist(Infolist $info): Infolist
    // {
    //     return $info
    //         ->schema([
    //             //
    //             Infolists\Components\TextEntry::make('nombre_completo')
    //                 ->columnSpanFull(),
    //             Infolists\Components\TextEntry::make('siglas')
    //                 ->columnSpanFull(),
    //         ]);
    // }
}
